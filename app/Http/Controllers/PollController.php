<?php

namespace App\Http\Controllers;



use App\Models\Poll;
use App\Models\PollVote;
use Illuminate\Http\Request;

class PollController extends Controller
{
    // Get all polls with vote counts and percentages
    public function index()
    {
        $user = auth()->user(); // assuming the user is authenticated
        $polls = Poll::with('options')->get();

        $response = [];

        foreach ($polls as $poll) {
            $userVote = PollVote::where('poll_id', $poll->id)
                ->where('user_id', $user->id)
                ->first();

            $pollData = [
                'id' => $poll->id,
                'title' => $poll->title,
                'description' => $poll->description,
                'created_at' => $poll->created_at,
                'updated_at' => $poll->updated_at,
            ];

            $options = [];
            foreach ($poll->options as $option) {
                $optionData = [
                    'id' => $option->id,
                    'option_text' => $option->option,
                ];

                // Only include votes count if the user has already voted
                if ($userVote) {
                    $optionData['votes_count'] = $option->votes()->count();
                }

                $options[] = $optionData;
            }

            $pollData['options'] = $options;
            $response[] = $pollData;
        }

        return response()->json(['polls' => $response]);
    }
    public function vote(Request $request, $pollId)
    {
        $user = auth()->user();

        // Check if the user has already voted for this poll
        $existingVote = PollVote::where('poll_id', $pollId)
            ->where('user_id', $user->id)
            ->first();

        if ($existingVote) {
            return response()->json(['message' => 'You have already voted for this poll.'], 400);
        }

        // Cast the vote
        PollVote::create([
            'poll_id' => $pollId,
            'option_id' => $request->option_id,
            'user_id' => $user->id,
        ]);

        // Return the poll with updated votes count
        $poll = Poll::with('options')->findOrFail($pollId);

        $response = [
            'id' => $poll->id,
            'title' => $poll->title,
            'description' => $poll->description,
            'created_at' => $poll->created_at,
            'updated_at' => $poll->updated_at,
            'options' => []
        ];

        foreach ($poll->options as $option) {
            $response['options'][] = [
                'id' => $option->id,
                'option_text' => $option->option,
                'votes_count' => $option->votes()->count() // Always show votes count after voting
            ];
        }

        return response()->json($response);
    }
    
}
