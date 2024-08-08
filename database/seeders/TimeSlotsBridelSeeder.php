<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TimeSlotBridel;

class TimeSlotsBridelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $timeSlots = [
            'Morning Slot',
            'Middle Slot',
            'Last Slot',
        ];

        foreach ($timeSlots as $slot) {
            TimeSlotBridel::create(['time_range' => $slot]);
        }
    }
}
