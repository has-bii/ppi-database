<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\AppStatus;
use Exception;
use Illuminate\Http\Request;
use stdClass;

class AppStatusController extends Controller
{
    public function fetch()
    {
        try {
            $statuses = AppStatus::query()->get();

            $statusModel = new AppStatus();

            $data = new stdClass;
            $data->status_row = $statusModel->getFillable();
            $data->statuses = $statuses;

            return ResponseFormatter::success($data, 'Fetched successfully');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 404);
        }
    }

    public function create(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:10', 'unique:app_statuses'],
                'style' => ['required', 'string', 'max:10']
            ]);

            $data = AppStatus::create([
                'name' => $request->name,
                'style' => $request->style
            ]);

            if (!$data)
                throw new Exception('App status has not been created');

            return ResponseFormatter::success($data, 'Fetched successfully');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 404);
        }
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'name' => ['nullable', 'string', 'max:10'],
                'style' => ['nullable', 'string', 'max:10']
            ]);

            $id = $request->input('id');

            if (!$id)
                throw new Exception('ID field is required');

            $data = AppStatus::query()->find($id);

            if (!$data)
                throw new Exception('The app status does not exist!');

            if ($request->name)
                $data->update(['name' => $request->name]);

            if ($request->style)
                $data->update(['style' => $request->style]);

            return ResponseFormatter::success($data, 'Updated successfully');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 404);
        }
    }

    public function delete(Request $request)
    {
        try {
            $id = $request->input('id');

            if (!$id)
                throw new Exception('ID field is required');

            $data = AppStatus::query()->find($id);

            if (!$data)
                throw new Exception('The app status does not exist');

            $data->delete();

            return ResponseFormatter::success(null, 'Deleted successfully');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 404);
        }
    }
}
