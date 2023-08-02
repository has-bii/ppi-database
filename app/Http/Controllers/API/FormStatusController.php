<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\FormStatus;
use Exception;
use Illuminate\Http\Request;

class FormStatusController extends Controller
{
    public function fetch(Request $request)
    {
        try {
            $limit = $request->input('limit', 100);
            $id = $request->input('id');
            $name = $request->input('name');
            $style = $request->input('style');


            // One data
            if ($id) {
                $status = FormStatus::query()->find($id);

                if (!$status)
                    throw new Exception("From is not found!");

                return ResponseFormatter::success($status, 'Status fetched successfully');
            }

            // All data
            $statuses = FormStatus::query();

            if ($name) {
                $statuses->where('name', 'like', '%' . $name . '%');
            }

            if ($style) {
                $statuses->where('style', 'like', '%' . $style . '%');
            }

            return ResponseFormatter::success($statuses->get(['id', 'name', 'style']), 'Statuses fetched successfully');
        } catch (Exception $error) {
            return ResponseFormatter::error($error->getMessage(), 404);
        }
    }

    public function create(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'style' => ['required', 'string', 'max:255'],
            ]);

            $status = FormStatus::create([
                'name' => $request->name,
                'style' => $request->style
            ]);

            if (!$status)
                throw new Exception("Status has not been created!");

            return ResponseFormatter::success($status, 'Status has been created successfully');
        } catch (Exception $error) {
            return ResponseFormatter::error($error->getMessage(), 404);
        }
    }

    public function update(Request $request)
    {
        try {

            $request->validate([
                'id' => ['required', 'integer'],
                'name' => ['string', 'max:255'],
                'style' => ['string', 'max:255'],
            ]);

            $id = $request->input('id');
            $name = $request->input('name');
            $style = $request->input('style');

            if (!$id)
                throw new Exception("ID field is required!");

            $status = FormStatus::query()->find($id);

            if (!$status)
                throw new Exception("Status has not been found!");

            if ($name)
                $status->name = $name;

            if ($style)
                $status->style = $style;

            $status->save();

            return ResponseFormatter::success($status, 'Status has been updated successfully');
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

            $status = FormStatus::query()->find($id);

            if (!$status)
                throw new Exception("Status has not been found!");

            $status->delete();

            return ResponseFormatter::success(null, 'Status has been deleted successfully');
        } catch (Exception $error) {
            return ResponseFormatter::error($error->getMessage(), 404);
        }
    }
}
