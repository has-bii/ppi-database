<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Link;
use App\Models\MyMenu;
use App\Models\Role;
use Exception;
use Illuminate\Http\Request;
use stdClass;

class MyMenuController extends Controller
{
    public function fetch(Request $request)
    {
        try {

            $id = $request->input('id');
            $my_menu = MyMenu::query()->with(['link', 'role']);

            // One menu
            if ($id) {
                $my_menu = MyMenu::query()->with(['link', 'role'])->find($id);

                if (!$my_menu)
                    throw new Exception('Menu does not exist');

                $data = new stdClass;
                $data->menus = $my_menu;

                $link_columns = new Link();
                $data->link_columns = $link_columns->getFillable();

                return ResponseFormatter::success($data, 'Fetched successfully');
            }

            // All data
            $my_menu = MyMenu::query()->with(['link', 'role'])->get();
            $myMenu = new MyMenu();
            $roles = Role::query()->get();

            $data = new stdClass;
            $data->menu = $my_menu;
            $data->columns = $myMenu->getFillable();
            $data->roles = $roles;

            return ResponseFormatter::success($data, 'Fetched successfully');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 404);
        }
    }

    public function create(Request $request)
    {
        try {
            $request->validate([
                'label' => ['required', 'string', 'max:255'],
                'role_id' => ['required', 'integer', 'exists:roles,id'],
                'active' => ['required', 'integer'],
            ]);

            $my_menu = MyMenu::create([
                'label' => $request->label,
                'role_id' => $request->role_id,
                'active' => $request->active,
            ]);

            if (!$my_menu)
                throw new Exception("My Menu has not been created!");

            $my_menu = MyMenu::query()->with('role')->find($my_menu->id);

            return ResponseFormatter::success($my_menu, 'New menu has been created successfully');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 404);
        }
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'id' => ['required', 'integer'],
                'label' => ['nullable', 'string', 'max:255'],
                'role_id' => ['nullable', 'integer', 'exists:roles,id'],
                'active' => ['nullable', 'integer'],
            ]);

            $my_menu = MyMenu::query()->find($request->id);

            if (!$my_menu)
                throw new Exception("Menu has not been found!");

            if ($request->label)
                $my_menu->update(['label' => $request->label]);

            if ($request->role_id)
                $my_menu->update(['role_id' => $request->role_id]);

            if ($request->active === '0' || $request->active === '1')
                $my_menu->update(['active' => $request->active]);

            return ResponseFormatter::success($my_menu, 'Menu has been updated successfully');
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

            $my_menu = MyMenu::query()->find($id);

            if (!$my_menu)
                throw new Exception("Menu has not been found!");

            $my_menu->delete();

            return ResponseFormatter::success(null, 'Menu has been deleted successfully');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 404);
        }
    }
}
