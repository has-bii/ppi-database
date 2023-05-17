<?php

namespace App\Http\Controllers;

use App\Models\Ppi;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;

class PpiController extends Controller
{
    public function fetch(Request $request)
    {

        $limit = $request->input('limit', 100);

        $ppis = Ppi::query();

        return ResponseFormatter::success($ppis->paginate($limit), 'Fetch success');
    }
}
