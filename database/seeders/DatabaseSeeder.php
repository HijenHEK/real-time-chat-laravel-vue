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
        $u1 = User::create([
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
        $u3 = User::create([
            'name' => 'hajed',
            'uname' => 'hajed',
            'email' => 'hajed@gmail.com',
            'password' => Hash::make('00000000')

        ]);
        $u4 = User::create([
            'name' => 'aymen',
            'uname' => 'aymen',
            'email' => 'aymen@gmail.com',
            'password' => Hash::make('00000000')

        ]);
        
        // $u1->discussions()->create();
        // $u1->addContact($u2);
        // $u2->addContact($u1);
        // $u1->discussions()->first()->users()->attach($u2 , ['contact' => true]);
        $faker = Factory::create();
        //     $i = 1 ;
        // for($l = 1 ; $l < 3 ; $l++) {
            $l = 1 ;
            for($j = 2 ; $j < 5 ; $j++) {
                
            $d = ${'u'.$l}->discussions()->create();
            ${'u'.$l}->addContact(${'u'.$j});
            ${'u'.$j}->addContact(${'u'.$l});
            $d->users()->attach(${'u'.$j} , ['contact' => true]);
                $i = 1 ;
                while($i < 49) {
                    $d->messages()->create(['content' => $faker->sentence() , 'user_id' => ${'u'.$j}->id]);
                    $i++;
                    sleep(1);
                    $d->messages()->create(['content' => $faker->sentence() , 'user_id' => ${'u'.$l}->id]);
                    $i++;
                    sleep(1);
                }
            }
        // }
    }
}
