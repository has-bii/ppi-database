<?php

namespace App\Http\Controllers\API;

use App\Models\Jurusan;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;

class JurusanController extends Controller
{
    public function fetch(Request $request)
    {

        $limit = $request->input('limit', 100);

        $univ_id = $request->input('universitas_turki_id');

        $jurusans = Jurusan::query();

        if ($univ_id) {
            $jurusans->where('universitas_turki_id', $univ_id)->orderBy('name', 'asc');
        }

        return ResponseFormatter::success($jurusans->paginate($limit), 'Fetch success');
    }
}
