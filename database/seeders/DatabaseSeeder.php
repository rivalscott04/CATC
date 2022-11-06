<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $user = new User();
        $user->nama = ucwords(strtolower("super"));
        $user->kampus = "Mataram";
        $user->tema = "Proctored";
        $user->no_peserta ="0";
        $user->no_hp ="0";
        $user->email = "admin@if.id";
        $user->AZ = 0;
        $user->DP = 0;
        $user->AI = 0;
        $user->level = 0;
        $user->password = bcrypt("@Admin123");
        $user->save();
    }
}
