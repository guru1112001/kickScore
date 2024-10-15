<?php

namespace Database\Seeders;

use App\Models\FanPhoto;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FanPhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = ['draft', 'approved', 'rejected'];

        for ($i = 1; $i <= 5; $i++) {
            FanPhoto::create([
                'user_id' => rand(1, 10),  // Assuming user IDs range from 1 to 10
                'image' => 'fan_photo_' . $i . '.jpg',
                'caption' => 'This is the caption for fan photo ' . $i,
                'acknowledge' => true,  // Always true
                'status' => $statuses[array_rand($statuses)],
            ]);
        }
    }
}
