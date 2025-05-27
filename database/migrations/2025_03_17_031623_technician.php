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
        Schema::create('technician', function (Blueprint $table) {
            $table->string('technician_id',20)->primary();
            $table->string('technician_Name',50);
            $table->timestamps();
        });
<<<<<<< HEAD
=======

        
>>>>>>> ff25b43 (Update)
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('technician');
    }
};
