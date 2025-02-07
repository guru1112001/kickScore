<?php

namespace App\Http\Controllers;

use App\Models\Type;
use App\Models\Player;
use App\Models\Fixture;
use App\Models\Commentary;
use App\Models\LiveFixture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
    $data=$this->addCommentary($data,$fixture->participants);
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
    private function addCommentary($data, $participants)
    {
        try {
            $participantNames = collect($participants)->pluck('name')->filter()->toArray();
            
            Log::debug('STEP 1 - Participant names:', $participantNames);
            
            if (!empty($participantNames)) {
                $query = Fixture::query();
                foreach ($participantNames as $name) {
                    $cleanName = trim($name);
                    $query->orWhere('name', 'LIKE', "%{$cleanName}%");
                }
    
                $sql = $query->toSql();
                $bindings = $query->getBindings();
                
                Log::debug('STEP 2 - Generated SQL:', [$sql, $bindings]);
                
                // STEP 3: Get the SportMonks fixture IDs from the fixtures table
                $fixtureIds = $query->distinct()
                    ->pluck('id') // Since `id` = SportMonks `fixture_id` in your DB
                    ->toArray();
    
                Log::debug('STEP 3 - Found Fixture IDs:', $fixtureIds);
                
                // STEP 4: Fetch commentaries using the SportMonks fixture IDs
                $commentaries = Commentary::whereIn('fixture_id', $fixtureIds)
                    ->get()
                    ->toArray();
    
                Log::debug('STEP 4 - Found Commentaries:', $commentaries);
                
                $data['commentaries'] = $commentaries;
            }
    
            return $data;
        } catch (\Exception $e) {
            Log::error('Commentary addition error: '. $e->getMessage());
            return $data;
        }
    }


}
