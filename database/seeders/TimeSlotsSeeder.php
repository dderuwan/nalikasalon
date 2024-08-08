<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TimeSlot;

class TimeSlotsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $timeSlots = [
            '08:00-08:45 AM',
            '09:00-09:45 AM',
            '10:00-10:45 AM',
            '11:00-11:40 AM',
            '12:00-12:45 AM',
            '01:00-01:45 AM',
            '02:00-02:45 AM',
            '03:00-03:45 PM',
            '04:00-04:45 PM',
            '05:00-05:45 PM',
        ];

        foreach ($timeSlots as $slot) {
            TimeSlot::create(['time_range' => $slot]);
        }
    }
}
