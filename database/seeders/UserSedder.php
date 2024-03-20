<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSedder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Ludgerdus',
            'email' => 'Ludgerdusl@gmail.com',
            'password' => password_hash('12345678', PASSWORD_DEFAULT)
        ]);
    }
}
