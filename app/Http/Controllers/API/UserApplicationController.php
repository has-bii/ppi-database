<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\AppStatus;
use App\Models\Education;
use App\Models\UserApplication;
use Exception;
use Illuminate\Http\Request;
use stdClass;

class UserApplicationController extends Controller
{
    public function fetch(Request $request)
    {
        try {
            $limit = $request->input('limit', 100);
            $id = $request->input('id');
            $user_id = $request->input('user_id');
            $application_id = $request->input('application_id');

            // One data
            if ($user_id && $application_id) {
                $user_app = UserApplication::query()->with(['user' => function ($query) {
                    $query->with('user_info');
                }, 'application', 'app_status', 'education'])->where('application_id', $application_id)->where('user_id', $user_id)->first();

                if (!$user_app)
                    throw new Exception("User app has not been found!");

                return ResponseFormatter::success($user_app, 'User App fetched successfully');
            }

            // One data
            if ($id) {
                $user_app = UserApplication::query()->with(['user' => function ($query) {
                    $query->with('user_info');
                }, 'application', 'app_status', 'education'])->find($id);

                if (!$user_app)
                    throw new Exception("User app has not been found!");

                return ResponseFormatter::success($user_app, 'User App fetched successfully');
            }

            // All apps belong to a user
            if ($user_id) {
                $user_app = UserApplication::query()->with(['user', 'application', 'app_status', 'education'])->where('user_id', $user_id)->get();

                return ResponseFormatter::success($user_app, 'User App fetched successfully');
            }

            $user_apps = UserApplication::query()->with(['user', 'application', 'app_status', 'education']);

            $data = new stdClass;
            $user_apps_row = new UserApplication();
            $data->user_apps_row = $user_apps_row->getFillable();
            $data->app_status = AppStatus::query()->get(['id', 'name']);
            $data->education = Education::query()->get(['id', 'name']);

            if ($application_id) {
                $user_apps->where('application_id', $application_id);
                $application = Application::query()->find($application_id);
                $data->application = $application;
            }


            $data->user_apps = $user_apps->paginate($limit);


            return ResponseFormatter::success($data, 'Fetched successfully');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 404);
        }
    }

    public function create(Request $request)
    {
        try {
            $request->validate([
                'application_id' => ['required', 'integer', 'exists:applications,id'],
                'education_id' => ['required', 'integer', 'exists:education,id'],
                'nilai_ujian' => ['required', 'numeric'],
                'jurusan_1' => ['required', 'string'],
                'jurusan_2' => ['required', 'string'],
                'jurusan_3' => ['required', 'string'],
                'receipt' => ['required', 'image', 'mimes:jpg,png,jpeg']
            ]);

            // Pas ijazah
            if (!$request->file('receipt'))
                throw new Exception("Receipt is required!");

            $fileReceipt = $request->file('receipt');
            $fileName = $fileReceipt->getClientOriginalName();
            $publicPath = public_path('storage/files');
            $fileReceipt->move($publicPath, $fileName);
            $pathReceipt = 'storage/files/' . $fileName;

            $user_app = UserApplication::create([
                'user_id' => $request->user()->id,
                'application_id' => $request->application_id,
                'education_id' => $request->education_id,
                'nilai_ujian' => $request->nilai_ujian,
                'jurusan_1' => $request->jurusan_1,
                'jurusan_2' => $request->jurusan_2,
                'jurusan_3' => $request->jurusan_3,
                'jurusan_3' => $request->jurusan_3,
                'receipt' => $pathReceipt,
            ]);

            if (!$user_app)
                throw new Exception("User Application has not been created!");

            return ResponseFormatter::success($user_app, 'User Application has been created successfully');
        } catch (Exception $error) {
            return ResponseFormatter::error($error->getMessage(), 404);
        }
    }

    public function update(Request $request)
    {
        try {
            $id = $request->input('id');

            if (!$id)
                $id = $request->input('id');

            if (!$id)
                throw new Exception("ID field is required!");

            $request->validate([
                'app_status_id' => ['nullable', 'integer', 'exists:app_statuses,id'],
                'education_id' => ['nullable', 'integer', 'exists:education,id'],
                'jurusan_1' => ['nullable', 'string'],
                'jurusan_2' => ['nullable', 'string'],
                'jurusan_3' => ['nullable', 'string'],
            ]);

            $user_app = UserApplication::query()->find($id);

            if (!$user_app)
                throw new Exception("Application has not been found!");

            if ($request->app_status_id)
                $user_app->update(['app_status_id' => $request->app_status_id]);

            if ($request->education_id)
                $user_app->update(['education_id' => $request->education_id]);

            if ($request->jurusan_1)
                $user_app->update(['jurusan_1' => $request->jurusan_1]);

            if ($request->jurusan_2)
                $user_app->update(['jurusan_2' => $request->jurusan_2]);

            if ($request->jurusan_3)
                $user_app->update(['jurusan_3' => $request->jurusan_3]);

            return ResponseFormatter::success($user_app, 'User Application has been updated successfully');
        } catch (Exception $error) {
            return ResponseFormatter::error($error->getMessage(), 404);
        }
    }

    public function delete(Request $request)
    {
        try {
            $id = $request->input('id');

            if (!$id)
                throw new Exception("ID field is required!");

            $user_app = UserApplication::query()->find($id);

            if (!$user_app)
                throw new Exception("Application has not been found!");

            $user_app->delete();

            return ResponseFormatter::success(null, 'User application has been deleted successfully');
        } catch (Exception $error) {
            return ResponseFormatter::error($error->getMessage(), 404);
        }
    }
}
