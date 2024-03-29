<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Rafael',
            'email' => 'r4faelmf@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        DB::table('teams')->insert([
            'name' => 'Assessoria',
            'user_id' => 1, //Rafael
            'personal_team' => true,
        ]);

        DB::table('users')->insert([
            'name' => 'Nilka',
            'email' => 'nilkakelly.ufrn@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        DB::table('team_user')->insert([
            'team_id' => '1', //Assessoria
            'user_id' => 2, //Nilka
            'role' => 'admin',
        ]);

        DB::table('users')->update([
            'current_team_id' => 1
        ]);
    }
}
