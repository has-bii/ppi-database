<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Role;
use Exception;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function fetch(Request $request)
    {
        try {
            if ($request->user()->role_id !== 4)
                throw new Exception('Request denied');

            $roles = Role::query()->get();

            $rolesModel = new Role();

            return ResponseFormatter::success([
                'data' => $roles,
                'row' => $rolesModel->getFillable()
            ], 'Fetched successfully');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 404);
        }
    }

    public function create(Request $request)
    {
        try {
            if ($request->user()->role_id !== 4)
                throw new Exception('Request denied');


            $request->validate([
                'name' => ['required', 'string', 'max:10', 'unique:roles,name,except,id']
            ]);

            $role = Role::create([
                'name' => $request->name
            ]);

            if (!$role)
                throw new Exception('Role has not been created!');

            return ResponseFormatter::success($role, 'Fetched successfully');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 404);
        }
    }

    public function update(Request $request)
    {
        try {
            if ($request->user()->role_id !== 4)
                throw new Exception('Request denied');


            $request->validate([
                'id' => ['required', 'integer', 'exists:roles,id'],
                'name' => ['required', 'string', 'max:10', 'unique:roles,name,except,id']
            ]);


            $role = Role::query()->find($request->id);

            if (!$role)
                throw new Exception('Role has not been found!');

            $role->update([
                'name' => $request->name
            ]);

            return ResponseFormatter::success($role, 'Updated successfully');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 404);
        }
    }

    public function delete(Request $request)
    {
        try {
            if ($request->user()->role_id !== 4)
                throw new Exception('Request denied');


            $request->validate([
                'id' => ['required', 'integer', 'exists:roles,id'],
            ]);


            $role = Role::query()->find($request->id);

            if (!$role)
                throw new Exception('Role has not been found!');

            $role->delete();

            return ResponseFormatter::success(null, 'Deleted successfully');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 404);
        }
    }
}
