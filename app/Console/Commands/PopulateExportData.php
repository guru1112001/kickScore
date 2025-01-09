<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PopulateExportData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'populate:export-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate export_data table with mapped commentary and fixtures data';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Populating export_data table...');

        // Batch size for chunking
        $batchSize = 1000;

        // Process commentaries in chunks
        DB::table('commentaries')
            ->join('fixtures', 'commentaries.fixture_id', '=', 'fixtures.id')
            ->select(
                'fixtures.id as fixture_id',
                'commentaries.comment as commentary',
                'commentaries.minute',
                'fixtures.name as fixture_name'
            )
            ->orderBy('commentaries.id')
            ->chunk($batchSize, function ($commentaries) {
                $data = [];
                foreach ($commentaries as $commentary) {
                    // Split fixture name into team_a and team_b
                    $teams = explode(" vs ", $commentary->fixture_name);
                    $teamA = DB::table('sportmonkteams')->where('name', $teams[0] ?? '')->value('id');
                    $teamB = DB::table('sportmonkteams')->where('name', $teams[1] ?? '')->value('id');
                    // Prepare data for insertion
                    $data[] = [
                        'fixture_id' => $commentary->fixture_id,
                        'commentary' => $commentary->commentary,
                        'minute' => $commentary->minute,
                        'team_a' => $teamA,
                        'team_b' => $teamB,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                // Insert data into the export_data table
                DB::table('exportdatas')->insert($data);

                $this->info(count($data) . ' records inserted.');
            });

        $this->info('Export data population completed.');
        return 0;
    }
}
