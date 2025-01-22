<?php

namespace App\Http\Controllers;

use App\Models\Type;
use App\Models\Player;
use App\Models\Fixture;
use App\Models\Commentary;
use App\Models\LiveFixture;
use Illuminate\Http\Request;

class LiveFixtureController extends Controller
{
    public function index()
    {
        $liveFixtures = LiveFixture::all()->map(function ($fixture) {
            return $this->transformFixture($fixture);
        });
        return  response()->json(['data'=>$liveFixtures]);
       
    }
    private function transformFixture($fixture)
    {
        $data=$fixture->toArray();
        
    $data=$this->addTypename($data);
    $data=$this->addcomentary($data,$fixture->participants);
        return $data;
        // return [
        //     'id' => $fixture->id,
        //     'name' => $fixture->name,
        //     'starting_at' => $fixture->starting_at,
        //     'details' => $fixture->details,
        //     'participants' => $fixture->participants,
        //     'weather_report' => $fixture->weather_report,
        //     'venue' => $fixture->venue,
        //     'formations' => $fixture->formations,
        //     'metadata' => $fixture->metadata,
        //     'lineups' => $fixture->lineups,
        //     'timeline' => $fixture->timeline,
        // ];
    }
    private function addTypename($data)
    {
        foreach($data as $key=>$value)
        {
            if(is_array($value)){
                $data[$key]=$this->addTypename($value);
            }
            elseif($key==='type_id'){
                $typename=Type::find($value)->name ?? 'Unknown';
                $data['type_name']=$typename;
            }
            elseif($key==='player_id'){
                $playername=Player::find($value)->name ?? 'Unknown';
                $data['player_name']=$playername;
            }
        }
       
        return $data;
    }
    private function addcomentary($data,$participants)
    {
        $fixtureIds=[];
        foreach($participants as $participant)
        {
            $participantNames = collect($participants)->pluck('name')->toArray();
             // Find matching fixture IDs from the `fixtures` table
        $fixtureIds = Fixture::whereIn('name', $participantNames)->pluck('id')->toArray();

        // Fetch commentaries for the retrieved fixture IDs
        $commentaries = Commentary::whereIn('fixture_id', $fixtureIds)->get();

        // Add the commentaries to the fixture data
        $data['commentaries'] = $commentaries;

        return $data;
           
        }
        
    }


}
