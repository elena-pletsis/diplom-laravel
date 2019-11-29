<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('full_name'); 
            $table->string('email');
            $table->string('phone');  
            $table->string('address'); 
            $table->unsignedBigInteger('status_id');
            $table->string('currency')->default('UAH');
            $table->text('note')->nullable();
            $table->float('total_sum');
            $table->float('sum_to_pay');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('status_id')->references('id')->on('statuses');            
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
        Schema::dropIfExists('orders');
    }
}
