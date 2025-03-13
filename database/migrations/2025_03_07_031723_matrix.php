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
        Schema::create('Matrix', function (Blueprint $table) {
            $table->unsignedBigInteger('Mat_No')->primary();
            $table->unsignedBigInteger('User_ID'); //Foreign Key
            
            $table->enum('Mat_Type', ['CR', 'MR', 'WO']);

            $table->unsignedBigInteger('AP1')->nullable(); //Foreign Key Users
            $table->unsignedBigInteger('AP2')->nullable(); //Foreign Key Users
            $table->unsignedBigInteger('AP3')->nullable(); //Foreign Key Users
            $table->unsignedBigInteger('AP4')->nullable(); //Foreign Key Users
            $table->unsignedBigInteger('AP5')->nullable(); //Foreign Key Users


            // Foreign  Key
            $table->foreign('User_ID')->references('id')->on('users')->onDelete('cascade');
        
            $table->foreign('AP1')->references('id')->on('users')->onDelete('set null');
            $table->foreign('AP2')->references('id')->on('users')->onDelete('set null');
            $table->foreign('AP3')->references('id')->on('users')->onDelete('set null');
            $table->foreign('AP4')->references('id')->on('users')->onDelete('set null');
            $table->foreign('AP5')->references('id')->on('users')->onDelete('set null');

        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Matrix');

    }
};
