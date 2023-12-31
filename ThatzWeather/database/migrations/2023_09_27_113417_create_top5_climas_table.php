<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Top5Climas;

class CreateTop5ClimasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('top5_climas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('temp');
            $table->string('cp');
            $table->string('ciudad');
            $table->timestamps();
        });
        for ($i=0; $i < 5; $i++) { 
            Top5Climas::create([
                'temp'=> '99',
                'cp'=> '00000',
                'ciudad'=> 'Sin información',
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('top5_climas');
    }
}
