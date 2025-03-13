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
        Schema::create('imgs', function (Blueprint $table) {
            $table->string('IMG_No',20)->primary();
            $table->enum('IMG_Type', ['BA','WO']);
            $table->string('IMG_RefNo');
            $table->string('IMG_Filename');
            $table->string('IMG_Realname');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imgs');

    }
};
