<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;

class JurusanController extends Controller
{
    public function fetch()
    {
        $jurusans = Jurusan::query()->orderBy('name', 'asc');

        return ResponseFormatter::success($jurusans->get(), 'Fetch success');
    }

    public function add(Request $request)
    {

        try {

            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'universitas_turki_id' => ['required', 'integer'],
            ]);

            $univ = Jurusan::create([
                'name' => $request->name,
                'universitas_turki_id' => $request->universitas_turki_id,
            ]);

            if (!$univ) {
                throw new Exception('Jurusan gagal ditambahkan.');
            }

            return ResponseFormatter::success($univ, 'Jurusan berhasil ditambahkan');
        } catch (Exception $error) {

            return ResponseFormatter::error($error->getMessage());
        }
    }
}
