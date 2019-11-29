<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNpcitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('npcities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('Ref', 255)->unique(); //город            
            $table->string('DescriptionRu', 255);
            $table->string('Area', 255); //область
            $table->string('SettlementTypeDescriptionRu', 255)->default('н/п'); //город / село

            $table->foreign('Area')->references('Ref')->on('npareas'); 
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
        Schema::dropIfExists('npcities');
    }
}
