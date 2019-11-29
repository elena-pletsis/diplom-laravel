<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNpwarehousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('npwarehouses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('DescriptionRu', 255);
            $table->string('CityRef', 255); //город            
            
            $table->foreign('CityRef')->references('Ref')->on('npcities'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('npwarehouses');
    }
}
