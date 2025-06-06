<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ConcertbookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $concerts = [
            [
                'title' => 'Rock Festival 2025',
                'start_time' => Carbon::now()->addDays(5),
            ],
            [
                'title' => 'Classical Night',
                'start_time' => Carbon::now()->addDays(10),
            ],
        ];

        foreach ($concerts as $concert) {
            $concertId = DB::table('concerts')->insertGetId([
                'title' => $concert['title'],
                'start_time' => $concert['start_time'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $seatTypes = [
                ['name' => 'VIP', 'total_quantity' => 20, 'price' => 150.00],
                ['name' => 'Thường', 'total_quantity' => 50, 'price' => 75.00],
                ['name' => 'Đứng', 'total_quantity' => 100, 'price' => 30.00],
            ];

            foreach ($seatTypes as $seat) {
                DB::table('seat_types')->insert([
                    'concert_id' => $concertId,
                    'name' => $seat['name'],
                    'total_quantity' => $seat['total_quantity'],
                    'price' => $seat['price'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}


