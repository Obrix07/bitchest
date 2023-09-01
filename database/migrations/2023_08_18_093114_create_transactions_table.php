<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('cryptocurrency_id');
            $table->unsignedBigInteger('cryptovalues_id');
            $table->enum('type', ['buy', 'sell']);
            $table->decimal('quantity', 15, 8); 
            $table->timestamps();
        
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('cryptocurrency_id')->references('id')->on('cryptocurrencies');
            $table->foreign('cryptovalues_id')->references('id')->on('cryptovalues');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
