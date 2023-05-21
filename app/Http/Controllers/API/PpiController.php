<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Ppi;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;

class PpiController extends Controller
{
    public function fetch(Request $request)
    {

        $limit = $request->input('limit', 100);

        $ppis = Ppi::query();

        return ResponseFormatter::success($ppis->paginate($limit), 'Fetch success');
    }

    public function add(Request $request)
    {

        try {

            $request->validate([
                'name' => ['required', 'string', 'max:255', 'unique:ppis']
            ]);

            $ppi = Ppi::create([
                'name' => $request->name,
            ]);

            if (!$ppi) {
                throw new Exception('PPI gagal ditambahkan.');
            }

            return ResponseFormatter::success($ppi, 'PPI berhasil ditambahkan');
        } catch (Exception $error) {

            return ResponseFormatter::error($error->getMessage());
        }
    }
}
