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
        Schema::create('Logs', function (Blueprint $table) {
            $table->id('Logs_No')->primary();
            $table->enum('LOG_Type', ['BA', 'MR', 'WO']);
            $table->string('LOG_RefNo'); 
            $table->string('LOG_Status')->nullable();
            $table->unsignedBigInteger('LOG_User'); //Foreign Key
            $table->dateTime('LOG_Date');
            $table->string('LOG_Desc', 255);
            $table->foreign('LOG_User')->references('id')->on('users')->onDelete('cascade');
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Logs');
    }
};

