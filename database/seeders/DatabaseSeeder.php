<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
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
        User::create([
            'name' => 'hijen',
            'uname' => 'hijen',
            'email' => 'hijen@gmail.com',
            'password' => Hash::make('00000000')

        ]);
        User::create([
            'name' => 'hiba',
            'uname' => 'hiba',
            'email' => 'hiba@gmail.com',
            'password' => Hash::make('00000000')

        ]);
        User::create([
            'name' => 'hajed',
            'uname' => 'hajed',
            'email' => 'hajed@gmail.com',
            'password' => Hash::make('00000000')

        ]);
        User::create([
            'name' => 'aymen',
            'uname' => 'aymen',
            'email' => 'aymen@gmail.com',
            'password' => Hash::make('00000000')

        ]);


        
    }
}
