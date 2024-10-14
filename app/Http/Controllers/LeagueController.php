<?php

namespace App\Http\Controllers;

use App\Models\League;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\LeagueResource;

class LeagueController extends Controller
{
    public function getAllLeagues()
{
    $leagues = Cache::remember('leagues_all', 86400, function() {
        return League::all();
    });
    return LeagueResource::collection($leagues);
}

public function getLeagueById($id)
{
    $league = Cache::remember("league_{$id}", 86400, function() use ($id) {
        return League::find($id);
    });

    if (!$league) {
        return response()->json(['error' => 'League not found'], 404);
    }

    return new LeagueResource($league);
}
public function getLiveLeagues()
{
    // Assuming leagues are active when 'active' is true
    $liveLeagues = League::where('active', TRUE)->get();
    return LeagueResource::collection($liveLeagues);
}

public function getLeaguesByFixtureDate($date)
{
    // Assuming you have a relationship between League and Fixture
    $leagues = League::whereHas('fixtures', function ($query) use ($date) {
        $query->whereDate('fixture_date', $date);
    })->get();

    return LeagueResource::collection($leagues);
}

public function getLeaguesByCountryId($countryId)
{
    $leagues = League::where('country_id', $countryId)->get();
    return LeagueResource::collection($leagues);
}
public function searchLeaguesByName($name)
{
    $leagues = League::where('name', 'LIKE', "%{$name}%")->get();
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
