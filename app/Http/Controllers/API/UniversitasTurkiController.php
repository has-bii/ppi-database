<?php

namespace App\Http\Controllers\API;

use Exception;
use Illuminate\Http\Request;
use App\Models\UniversitasTurki;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;

class UniversitasTurkiController extends Controller
{
    public function fetch(Request $request)
    {

        $limit = $request->input('limit', 200);

        $universitasTurkis = UniversitasTurki::query();

        return ResponseFormatter::success($universitasTurkis->paginate($limit), 'Fetch success');
    }

    public function add(Request $request)
    {

        try {

            $request->validate([
                'name' => ['required', 'string', 'max:255', 'unique:universitas_turkis']
            ]);

            $univ = UniversitasTurki::create([
                'name' => $request->name,
            ]);

            if (!$univ) {
                throw new Exception('Universitas gagal ditambahkan.');
            }

            return ResponseFormatter::success($univ, 'Universitas berhasil ditambahkan');
        } catch (Exception $error) {

            return ResponseFormatter::error($error->getMessage());
        }
    }
}
