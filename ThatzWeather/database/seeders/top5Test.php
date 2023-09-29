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
            'temp'=> '23',
            'cp'=> '36161',
            'ciudad'=> 'Pontevedra',
        ]);
        Top5Climas::create([
            'temp'=> '-5',
            'cp'=> '04004',
            'ciudad'=> 'Almería',
        ]);
        Top5Climas::create([
            'temp'=> '26',
            'cp'=> '25199',
            'ciudad'=> 'Lleida',
        ]);
        Top5Climas::create([
            'temp'=> '22',
            'cp'=> '37008',
            'ciudad'=> 'Salamanca',
        ]);
    }
}
