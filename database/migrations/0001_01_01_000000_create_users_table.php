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
        Schema::create('departments', function (Blueprint $table) {
            $table->string('dept_no',30)->primary(); 
            $table->string('dept_name');  
            $table->string('dept_desc')->nullable(); 
            $table->string('dept_code', 10)->unique();
            $table->timestamps();
        });

        Schema::create('Positions', function (Blueprint $table) {
            $table->id();
            $table->string('PS_Name');
            $table->string('PS_Desc');
            $table->string('dept_no', 30)->nullable(); 

            $table->timestamps();

            // Foreign key constraint
            $table->foreign('dept_no')->references('dept_no')->on('departments')->onDelete('set null');
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
        Schema::dropIfExists('departments');
        Schema::dropIfExists('Positions');
        Schema::dropIfExists('users');
    }
};
