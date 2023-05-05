<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('services')->insert(
            [
                [
                    'id' => 1,
                    'duration' => "40min",
                    'price' => "40",
                    'description' => "Bathroom with the best products on the market",
                    'name' => "Bath"
                ],
                [
                    'id' => 2,
                    'duration' => "60min",
                    'price' => "80",
                    'description' => "We cut the nails in an efficient and calm way for your pet.",
                    'name' => "Nails Cutting"
                ],
                [
                    'id' => 3,
                    'duration' => "80min",
                    'price' => "120",
                    'description' => "We have the best haircutting              professionals, internationally recognized.",
                    'name' => "Haircut"
                ],
                [
                    'id' => 4,
                    'duration' => "30min",
                    'price' => "30",
                    'description' => "We know that the most important thing is your pet's teeth, that's why we take care of their oral hygiene.",
                    'name' => "Toothbrushing"
                ]
            ]
        );
    }
}
