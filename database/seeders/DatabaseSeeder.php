<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use function React\Promise\Timer\timeout;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $u = User::create([
            'name' => 'hijen',
            'uname' => 'hijen',
            'email' => 'hijen@gmail.com',
            'password' => Hash::make('00000000')

        ]);
        $u2 = User::create([
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

        $u->discussions()->create();
        $u->addContact($u2);
        $u2->addContact($u);
        $u->discussions()->first()->users()->attach($u2 , ['contact' => true]);
        $faker = Factory::create();
            $i = 1 ;
        while($i < 49) {
            $u2->discussions->first()->messages()->create(['content' => $i , 'user_id' => $u2->id]);
            $i++;
            sleep(1);
            $u->discussions->first()->messages()->create(['content' => $i , 'user_id' => $u->id]);
            $i++;
            sleep(1);
        }
        
        
    }
}
