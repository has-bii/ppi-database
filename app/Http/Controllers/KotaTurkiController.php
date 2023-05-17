<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\KotaTurki;
use Illuminate\Http\Request;

class KotaTurkiController extends Controller
{
    public function fetch(Request $request)
    {

        $limit = $request->input('limit', 100);

        $kotaTurkis = KotaTurki::query();

        return ResponseFormatter::success($kotaTurkis->paginate($limit), 'Fetch success');
    }
}
