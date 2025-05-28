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
            $table->string('Position');
            $table->enum('Mat_Type', ['CR', 'MR', 'WO']);
            $table->integer('Mat_Max');
            $table->timestamps();

            $table->unsignedBigInteger('AP1')->nullable(); //Foreign Key users
            $table->unsignedBigInteger('AP2')->nullable(); //Foreign Key users
            $table->unsignedBigInteger('AP3')->nullable(); //Foreign Key users
            $table->unsignedBigInteger('AP4')->nullable(); //Foreign Key users
            $table->unsignedBigInteger('AP5')->nullable(); //Foreign Key users

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
