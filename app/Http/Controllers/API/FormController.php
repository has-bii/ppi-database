<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\FormStatus;
use App\Models\Role;
use Exception;
use Illuminate\Http\Request;
use stdClass;

class FormController extends Controller
{
    public function fetch(Request $request)
    {
        try {
            $limit = $request->input('limit', 100);
            $name = $request->input('name');
            $status_id = $request->input('status_id');
            $role_id = $request->input('role_id');
            $id = $request->input('id');


            // One data
            if ($id) {
                $form = Form::query()->with('status')->find($id);

                if (!$form)
                    throw new Exception("From is not found!");

                return ResponseFormatter::success($form, 'Form fetched successfully');
            }

            // All data
            $forms = Form::query()->with(['status' => function ($query) {
                $query->select('id', 'name', 'style');
            }]);

            $forms->with(['role' => function ($query) {
                $query->select('id', 'name');
            }]);

            if ($name) {
                $forms->where('name', 'like', '%' . $name . '%');
            }

            if ($status_id)
                $forms->where('status_id', $status_id);

            if ($role_id)
                $forms->where('role_id', $role_id);

            if ($request->user()->role_id === 3)
                $forms->where('role_id', 3);

            $statuses = FormStatus::query()->get(['id', 'name', 'style']);
            $roles = Role::query()->get(['id', 'name']);

            $data = new stdClass;

            $formModel = new Form();

            $data->rows = $formModel->getFillable();
            $data->cols = $forms->paginate($limit);
            $data->status = $statuses;
            $data->role = $roles;

            return ResponseFormatter::success($data, 'Forms fetched successfully');
        } catch (Exception $error) {
            return ResponseFormatter::error($error->getMessage(), 404);
        }
    }

    public function create(Request $request)
    {
        try {

            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'desc' => ['nullable', 'string', 'max:255'],
                'status_id' => ['nullable', 'integer', 'exists:form_statuses,id'],
                'role_id' => ['nullable', 'integer', 'exists:roles,id'],
            ]);

            $form = Form::create([
                'name' => $request->name,
                'desc' => $request->desc,
                'status_id' => isset($request->status_id) ? $request->status_id : 2,
                'role_id' => isset($request->role_id) ? $request->role_id : 3,
            ]);

            if (!$form)
                throw new Exception("Form has not been created!");

            $data = Form::query()->with(['status', 'role'])->find($form->id);

            return ResponseFormatter::success($data, 'Form has been created successfully');
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
                'status_id' => ['nullable', 'integer', 'exists:form_statuses,id'],
                'role_id' => ['nullable', 'integer', 'exists:roles,id'],
            ]);

            $id = $request->input('id');
            $name = $request->input('name');
            $desc = $request->input('desc');
            $status_id = $request->input('status_id');
            $role_id = $request->input('role_id');
            $question = $request->input('question');

            if (!$id)
                throw new Exception("ID field is required!");

            $ids = explode(',', $id);

            $form = Form::query()->whereIn('id', $ids);

            if (!$form)
                throw new Exception("Form has not been found!");

            if ($name)
                $form->update(['name' => $name]);

            if ($desc)
                $form->update(['desc' => $desc]);

            if ($status_id)
                $form->update(['status_id' => $status_id]);

            if ($role_id)
                $form->update(['role_id' => $role_id]);

            if ($question)
                $form->update(['question' => $question]);

            return ResponseFormatter::success($form, 'Form has been updated successfully');
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

            $ids = explode(',', $id);

            $form = Form::query()->whereIn('id', $ids);

            if (!$form)
                throw new Exception("Form not found!");

            $form->delete();

            return ResponseFormatter::success(null, 'Form has been deleted successfully');
        } catch (Exception $error) {
            return ResponseFormatter::error($error->getMessage(), 404);
        }
    }
}
