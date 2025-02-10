<?php

namespace App\Http\Controllers;

use App\Models\Prediction;
use Illuminate\Http\Request;

class PredictionController extends Controller
{
    public function index(Request $request)
    {
        $fixtureId = $request->query('fixture_id');
        $predictions=Prediction::where('fixture_id',$fixtureId)
        ->orderBy('created_at','desc')
        ->get()
        ->map(function ($prediction) {
            $prediction->prediction = json_decode($prediction->prediction, true);
            return $prediction;
        });
        // $predictions = Prediction::all()->map(function ($prediction) {
        //     $prediction->prediction = json_decode($prediction->prediction, true);
        //     return $prediction;
        // });

        return response()->json($predictions, 200);
    }
}
