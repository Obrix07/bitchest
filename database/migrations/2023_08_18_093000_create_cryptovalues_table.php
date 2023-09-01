<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cryptovalues', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cryptocurrency_id');
            $table->decimal('value', 15, 8); 
            $table->date('value_date');

            $table->foreign('cryptocurrency_id')->references('id')->on('cryptocurrencies');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cryptovalues');
    }
};
