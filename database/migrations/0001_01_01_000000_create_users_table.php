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
        Schema::create('Positions', function (Blueprint $table) {
            $table->id();
            $table->string('PS_Name');
            $table->string('PS_Desc');
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('Fullname');
            $table->string('Username');
            $table->string('Password');
            $table->rememberToken();
            $table->dateTime('CR_DT');  
            $table->unsignedBigInteger('PS_ID');

            // Foreign Key
            $table->foreign('PS_ID')->references('id')->on('Positions')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('Positions');
    }
};
