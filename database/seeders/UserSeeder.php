<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert(
            [
                [
                    'name'=>"ramon",
                    'surname'=> "Sanchez",
                    'email'=>"ramon@ramon.com",
                    'password'=>bcrypt("Pedro123"),
                    'phone'=> "644234323",
                    'address'=> "C/ Pedro de lobeira 10",
                    'role_id'=> 2
                ],
                [
                    'name'=>"Luis",
                    'surname'=> "Diaz",
                    'email'=>"luis@luis.com",
                    'password'=>bcrypt("Mateo123"),
                    'phone'=> "644234323",
                    'address'=> "C/ Pedro de lobeira 10",
                    'role_id'=> 2
                ],
                [
                    'name'=>"Alberto",
                    'surname'=> "Fernandez",
                    'email'=>"alberto@alberto.com",
                    'password'=>bcrypt("Ruben123"),
                    'phone'=> "644234323",
                    'address'=> "C/ Isla de lobeira 1",
                    'role_id'=> 2
                ],
            ]
        );
    }
}
