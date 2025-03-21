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
        Schema::create('WO_DoneBy', function (Blueprint $table) {
            $table->string('WO_No', 30)->primary();
            $table->unsignedBigInteger('User_ID'); //Foreign Key

            // Foreign  Key
            $table->foreign('User_ID')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('WO_No')->references('WO_No')->on('Work_Orders')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('WO_DoneBy');

    }
};
