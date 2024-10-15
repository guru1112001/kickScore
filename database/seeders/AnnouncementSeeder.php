<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Announcement;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            Announcement::create([
                'title' => 'Announcement ' . $i,
                'description' => 'This is the description for Announcement ' . $i,
                'image' => 'announcement_' . $i . '.jpg',
                'schedule_at' => Carbon::now()->addDays($i),
                'sent' => false,
            ]);
        }
    }
}
