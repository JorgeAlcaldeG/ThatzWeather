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

        for ($i=0; $i < 5; $i++) { 
            Top5Climas::create([
                'temp'=> '99',
                'cp'=> '00000',
                'ciudad'=> 'Sin información',
            ]);
        }
    }
}
