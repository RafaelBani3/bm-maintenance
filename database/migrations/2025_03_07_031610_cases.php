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
     
        Schema::create('cases', function (Blueprint $table) {
            $table->string('Case_No', 30)->primary();
            $table->string('Case_Name', 255);
            $table->date('Case_Date');
            $table->unsignedBigInteger('CR_BY'); //Foreign Key
            $table->dateTime('CR_DT');
            $table->string('Cat_No',30); //Foreign Key
            $table->string('Scat_No', 30); // Foreign Key

            $table->string('Case_Chronology', 255);
            $table->string('Case_Outcome', 255);
            $table->string('Case_Suggest', 255);
            $table->string('Case_Action', 255);

            $table->enum('Case_Status', ['OPEN', 'SUBMIT', 'AP1', 'AP2', 'AP3', 'AP4', 'AP5', 'CLOSE', 'REJECT', 'INPROGRESS']);
            $table->enum('Case_IsReject', ['Y', 'N']);
            $table->enum('Case_RejGroup', ['AP1', 'AP2', 'AP3','AP4', 'AP5'])->nullable();
            $table->unsignedBigInteger('Case_RejBy')->nullable();; //Foreign Key
            $table->dateTime('Case_RejDate')->nullable();

            $table->string('Case_RMK1', 255)->nullable();
            $table->string('Case_RMK2', 255)->nullable();
            $table->string('Case_RMK3', 255)->nullable(); 
            $table->string('Case_RMK4', 255)->nullable(); 
            $table->string('Case_RMK5', 255)->nullable(); 

            $table->unsignedBigInteger('Case_AP1')->nullable(); // Foreign Key
            $table->unsignedBigInteger('Case_AP2' )->nullable(); // Foreign Key
            $table->unsignedBigInteger('Case_AP3')->nullable(); // Foreign Key
            $table->unsignedBigInteger('Case_AP4')->nullable(); // Foreign Key
            $table->unsignedBigInteger('Case_AP5')->nullable(); // Foreign Key

            $table->integer('Case_ApStep');
            $table->integer('Case_ApMaxStep');
            $table->integer('Case_Loc_Floor');

            $table->string('Case_Loc_Room', 50);
            $table->string('Case_Loc_Object', 50);
            $table->dateTime('Update_Date');
            
            $table->timestamps();

        // Foreign Key
            $table->foreign('CR_BY')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('Cat_No')->references('Cat_No')->on('cats')->onDelete('cascade');
            $table->foreign('Scat_No')->references('Scat_No')->on('Subcats')->onDelete('cascade');
            $table->foreign('Case_RejBy')->references('id')->on('users')->onDelete('cascade');
        
            $table->foreign('Case_AP1')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('Case_AP2')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('Case_AP3')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('Case_AP4')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('Case_AP5')->references('id')->on('users')->onDelete('cascade');

        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cases');

    }
};
