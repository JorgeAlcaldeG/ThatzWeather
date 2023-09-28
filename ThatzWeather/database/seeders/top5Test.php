<?php

namespace Database\Seeders;
use App\Models\Top5Climas;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class top5Test extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Top5Climas::create([
            'temp'=> '15',
            'cp'=> '08907',
            'ciudad'=> 'Barcelona',
        ]);
        Top5Climas::create([
            'temp'=> '25',
            'cp'=> '08906',
            'ciudad'=> 'Madrid',
        ]);
        Top5Climas::create([
            'temp'=> '-15',
            'cp'=> '08721',
            'ciudad'=> 'Almería',
        ]);
        Top5Climas::create([
            'temp'=> '-2',
            'cp'=> '08621',
            'ciudad'=> 'Lleida',
        ]);
        Top5Climas::create([
            'temp'=> '22',
            'cp'=> '05621',
            'ciudad'=> 'Salamanca',
        ]);
    }
}
