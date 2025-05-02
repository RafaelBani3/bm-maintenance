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
        Schema::create('material', function (Blueprint $table) {
            $table->string('Material_No', 20)->primary();
            $table->string('Material_Name', 50);
            $table->string('Material_Stock', 100);
            $table->string('Material_Unit', 10);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('material');
    }
};
