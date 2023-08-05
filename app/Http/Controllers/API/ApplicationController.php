<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\AppStatus;
use Exception;
use Illuminate\Http\Request;
use stdClass;

class ApplicationController extends Controller
{
    public function fetch(Request $request)
    {
        try {
            $id = $request->input('id');
            $name = $request->input('name');
            $desc = $request->input('desc');
            $active = $request->input('active');
            $app_status_id = $request->input('app_status_id');


            // One data
            if ($id) {
                $app = Application::query()->with(['app_status', 'user_application'])->find($id);

                if (!$app)
                    throw new Exception("From is not found!");

                return ResponseFormatter::success($app, 'App fetched successfully');
            }

            // All data
            $apps = Application::query()->with(['app_status' => function ($query) {
                $query->select('id', 'name', 'style');
            }])->get();

            if ($name) {
                $apps->where('name', 'like', '%' . $name . '%');
            }

            if ($desc) {
                $apps->where('desc', 'like', '%' . $desc . '%');
            }

            if ($app_status_id)
                $apps->where('app_status_id', $app_status_id);

            if ($active === '0' || $active === '1')
                $apps->where('active', $active);

            $data = new stdClass;
            $appsRowModel = new Application();
            $app_status = AppStatus::query()->get(['id', 'name', 'style']);

            $data->apps = $apps;
            $data->apps_row = $appsRowModel->getFillable();
            $data->app_status = $app_status;

            return ResponseFormatter::success($data, 'Apps fetched successfully');
        } catch (Exception $error) {
            return ResponseFormatter::error($error->getMessage(), 404);
        }
    }

    public function create(Request $request)
    {
        try {

            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'desc' => ['required', 'string', 'max:255'],
                'active' => ['required', 'string', 'max:255'],
                'app_status_id' => ['required', 'integer', 'exists:app_statuses,id'],
            ]);

            $app = Application::create([
                'name' => $request->name,
                'desc' => $request->desc,
                'active' => $request->active,
                'app_status_id' => $request->app_status_id,
            ]);

            if (!$app)
                throw new Exception("Application has not been created!");

            $data = Application::query()->with(['app_status'])->find($app->id);

            return ResponseFormatter::success($data, 'Application has been created successfully');
        } catch (Exception $error) {
            return ResponseFormatter::error($error->getMessage(), 404);
        }
    }

    public function update(Request $request)
    {
        try {

            $request->validate([
                'name' => ['nullable', 'string', 'max:255'],
                'desc' => ['nullable', 'string', 'max:255'],
                'active' => ['nullable', 'string', 'max:255'],
                'app_status_id' => ['nullable', 'integer', 'exists:app_statuses,id'],
            ]);

            $id = $request->input('id');

            if (!$id)
                throw new Exception("ID field is required!");

            $app = Application::query()->find($id);

            if (!$app)
                throw new Exception("Application has not been found!");

            if ($request->name)
                $app->update(['name' => $request->name]);

            if ($request->desc)
                $app->update(['desc' => $request->desc]);

            if ($request->active === '0' || $request->active === '1')
                $app->update(['active' => $request->active]);

            if ($request->app_status_id)
                $app->update(['app_status_id' => $request->app_status_id]);

            return ResponseFormatter::success($app, 'Form has been updated successfully');
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

            $app = Application::query()->find($id);

            if (!$app)
                throw new Exception("Application has not been found!");

            $app->delete();

            return ResponseFormatter::success(null, 'Application has been deleted successfully');
        } catch (Exception $error) {
            return ResponseFormatter::error($error->getMessage(), 404);
        }
    }
}
