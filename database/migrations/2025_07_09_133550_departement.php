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
        // Schema::create('departments', function (Blueprint $table) {
        //     $table->string('dept_no',30)->primary(); 
        //     $table->string('dept_name');  
        //     $table->string('dept_desc')->nullable(); 
        //     $table->string('dept_code', 10)->unique();
        //     $table->timestamps();
        // });
    }

    public function down()
    {
        // Schema::dropIfExists('departments');
    }
};
