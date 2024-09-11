<?php

namespace App\Http\Controllers;



use App\Models\Poll;
use Illuminate\Http\Request;

class PollController extends Controller
{
    // Get all polls with vote counts and percentages
    public function index()
    {
        $polls = Poll::with('options')->get();

        return $polls->map(function ($poll) {
            $totalVotes = $poll->options->sum('votes'); // Total votes for the poll
            $poll->options->each(function ($option) use ($totalVotes) {
                // Calculate percentage of votes for each option
                $option->percentage = $totalVotes > 0 ? round(($option->votes / $totalVotes) * 100, 2) : 0;
            });

            return $poll;
        });
    }

    // Handle voting for a specific option
    public function vote(Request $request, PollOption $option)
    {
        $option->increment('votes');

        // Return updated poll with votes and percentage
        $poll = $option->poll()->with('options')->first();
        $totalVotes = $poll->options->sum('votes');

        $poll->options->each(function ($opt) use ($totalVotes) {
            $opt->percentage = $totalVotes > 0 ? round(($opt->votes / $totalVotes) * 100, 2) : 0;
        });

        return response()->json([
            'poll' => $poll,
            'message' => 'Vote recorded successfully'
        ]);
    }
}
