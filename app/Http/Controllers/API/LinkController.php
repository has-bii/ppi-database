<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Link;
use Exception;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    public function fetch(Request $request)
    {
        try {
            $my_menu_id = $request->input('my_menu_id');

            $link = Link::query()->where('my_menu_id', $my_menu_id)->first();

            return ResponseFormatter::success($link, 'Fetched successfully');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 404);
        }
    }

    public function create(Request $request)
    {
        try {
            $request->validate([
                'my_menu_id' => ['required', 'integer', 'exists:my_menus,id'],
                'name' => ['required', 'string', 'max:255'],
                'active' => ['required', 'boolean'],
                'url' => ['required', 'string', 'max:255'],
                'icon' => ['required', 'string', 'max:255'],
            ]);

            $link = Link::create([
                'my_menu_id' => $request->my_menu_id,
                'name' => $request->name,
                'active' => $request->active,
                'url' => $request->url,
                'icon' => $request->icon,
            ]);

            if (!$link)
                throw new Exception("New link has not been created!");

            return ResponseFormatter::success($link, 'New link has been created successfully');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 404);
        }
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'id' => ['required', 'integer'],
                'my_menu_id' => ['nullable', 'integer', 'exists:my_menus,id'],
                'name' => ['nullable', 'string', 'max:255'],
                'active' => ['nullable', 'boolean'],
                'url' => ['nullable', 'string', 'max:255'],
                'icon' => ['nullable', 'string', 'max:255'],
            ]);

            $link = Link::query()->find($request->id);

            if (!$link)
                throw new Exception("Link has not been found!");

            if ($request->my_menu_id)
                $link->update(['my_menu_id' => $request->my_menu_id]);

            if ($request->name)
                $link->update(['name' => $request->name]);

            if ($request->active)
                $link->update(['active' => $request->active]);

            if ($request->url)
                $link->update(['url' => $request->url]);

            if ($request->icon)
                $link->update(['icon' => $request->icon]);

            return ResponseFormatter::success($link, 'Link has been updated successfully');
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

            $link = Link::query()->find($id);

            if (!$link)
                throw new Exception("Link has not been found!");

            $link->delete();

            return ResponseFormatter::success(null, 'Menu has been deleted successfully');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 404);
        }
    }
}
