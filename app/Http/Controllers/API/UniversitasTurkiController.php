<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\UniversitasTurki;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;

class UniversitasTurkiController extends Controller
{
    public function fetch(Request $request)
    {

        $limit = $request->input('limit', 200);

        $universitasTurkis = UniversitasTurki::with('jurusan');

        return ResponseFormatter::success($universitasTurkis->paginate($limit), 'Fetch success');
    }
}
