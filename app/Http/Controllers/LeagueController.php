<?php

namespace App\Http\Controllers;

use App\Models\League;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\LeagueResource;

class LeagueController extends Controller
{
    public function getAllLeagues(Request $request)
    {
        $locale = $request->input('locale', 'en');
        $leagues = League::with(['translations' => function ($query) use ($locale) {
            $query->where('locale', $locale);
        }])->get();

        return LeagueResource::collection($leagues);
    }

    public function getLeagueById(Request $request)
    {
        $id=$request->input('league_id');
        $locale = $request->input('locale', 'en');
        $league = League::with(['translations' => function ($query) use ($locale) {
            $query->where('locale', $locale);
        }])->where('league_id', $id)->first();

        if (!$league) {
            return response()->json(['error' => 'League not found'], 404);
        }

        return new LeagueResource($league);
    }
    public function getLiveLeagues(Request $request)
    {
        $locale = $request->input('locale', 'en'); // Default locale to 'en' if not provided
    
        // Fetch active leagues
        $liveLeagues = League::where('active', 1)->with(['translations' => function ($query) use ($locale) {
            $query->where('locale', $locale);
        }])->get();
    
        return LeagueResource::collection($liveLeagues);
    }

    public function getLeaguesByFixtureDate($date, Request $request)
    {
        $locale = $request->input('locale', 'en');
    
        // Fetch leagues where last_played_at matches the specified date
        $leagues = League::whereDate('last_played_at', $date)
            ->with(['translations' => function ($query) use ($locale) {
                $query->where('locale', $locale);
            }])
            ->get();
    
        return LeagueResource::collection($leagues);
    }

    public function getLeaguesByCountryId($countryId, Request $request)
    {
        $locale = $request->input('locale', 'en');
    
        // Fetch leagues by country ID
        $leagues = League::where('country_id', $countryId)->with(['translations' => function ($query) use ($locale) {
            $query->where('locale', $locale);
        }])->get();
    
        return LeagueResource::collection($leagues);
    }
    public function searchLeaguesByName($name, Request $request)
    {
        $locale = $request->input('locale', 'en');
    
        // Search for leagues by name, including translations
        $leagues = League::whereHas('translations', function ($query) use ($name, $locale) {
            $query->where('locale', $locale)
                  ->where('name', 'LIKE', "%{$name}%");
        })->with(['translations' => function ($query) use ($locale) {
            $query->where('locale', $locale);
        }])->get();
    
        return LeagueResource::collection($leagues);
    }


public function selectLeagues(Request $request)
{
    $user = auth()->user();
    
    // Validate the leagues sent by the user
    $validatedData = $request->validate([
        'leagues' => 'required|array',
        'leagues.*' => 'exists:leagues,id',
    ]);

    // Sync the user's selected leagues
    $user->leagues()->sync($validatedData['leagues']);

    return response()->json([
        'message' => 'Leagues successfully selected',
        'leagues' => $user->leagues,
    ]);
}

}
