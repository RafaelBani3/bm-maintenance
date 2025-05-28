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
        Schema::create('Subcats', function (Blueprint $table) {
            $table->string('Scat_No',30)->primary();
            $table->string('Cat_No',30); // Foreign Key
            $table->string('Scat_Name', 255);
            $table->string('Scat_Desc', 255)->nullable();
            $table->timestamps();

            // Foreign key
            $table->foreign('Cat_No')->references('Cat_No')->on('Cats')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Subcats');

    }
};
