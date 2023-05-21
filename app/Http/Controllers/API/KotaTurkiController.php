<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\KotaTurki;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;

class KotaTurkiController extends Controller
{
    public function fetch(Request $request)
    {

        $limit = $request->input('limit', 100);

        $kotaTurkis = KotaTurki::query();

        return ResponseFormatter::success($kotaTurkis->paginate($limit), 'Fetch success');
    }

    public function add(Request $request)
    {

        try {

            $request->validate([
                'name' => ['required', 'string', 'max:255', 'unique:kota_turkis']
            ]);

            $kota = KotaTurki::create([
                'name' => $request->name,
            ]);

            if (!$kota) {
                throw new Exception('Kota gagal ditambahkan.');
            }

            return ResponseFormatter::success($kota, 'Kota berhasil ditambahkan');
        } catch (Exception $error) {

            return ResponseFormatter::error($error->getMessage());
        }
    }
}
