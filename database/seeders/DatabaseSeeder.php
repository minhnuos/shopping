<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345'),
            'is_admin' => 1
        ], [
            'name' => 'Nguyễn Văn Minh',
            'email' => 'vanminhhy99@gmail.com',
            'password' => Hash::make('12345'),
            'is_admin' => 0
        ], );
    }
}
