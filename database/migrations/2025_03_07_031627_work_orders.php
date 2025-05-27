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
        Schema::create('Work_Orders', function (Blueprint $table) {
            $table->string('WO_No', 30)->primary();
            $table->string('Case_No', 30); //Foreign Key
            $table->string('WOC_No', 30)->nullable(); 
            $table->unsignedBigInteger('CR_BY'); //Foreign Key
            $table->dateTime('CR_DT');

            $table->dateTime('WO_Start'); 
            $table->dateTime('WO_End'); 
            $table->enum('WO_Status', ['OPEN', 'INPROGRESS', 'OPEN_COMPLETION', 'SUBMIT','SUBMIT_COMPLETION', 'AP1', 'AP2' ,'AP3', 'AP4', 'CLOSE', 'DONE']);
            // $table->string('WO_DoneBy'); //Foreign Key 

            $table->string('WO_Narative', 255);
            $table->enum('WO_NeedMat', ['Y', 'N']);

            $table->unsignedBigInteger('WO_MR'); 
            $table->enum('WO_IsComplete', ['Y','N']);
            $table->dateTime('WO_CompDate')->nullable(); 
            $table->unsignedBigInteger('WO_CompBy')->nullable(); //Foreign Key Users
            $table->enum('WO_IsReject', ['Y','N'])->nullable();
            $table->enum('WO_RejGroup', ['AP1', 'AP2' ,'AP3', 'AP4', 'AP5'])->nullable();
            $table->unsignedBigInteger('WO_RejBy')->nullable(); //Foreign Key Users
            $table->dateTime('WO_RejDate')->nullable(); 

            $table->string('WO_RMK1',255)->nullable(); 
            $table->string('WO_RMK2',255)->nullable(); 
            $table->string('WO_RMK3',255)->nullable(); 
            $table->string('WO_RMK4',255)->nullable(); 
            $table->string('WO_RMK5',255)->nullable(); 
            
            $table->unsignedBigInteger('WO_AP1')->nullable(); //Foreign Key Users
            $table->unsignedBigInteger('WO_AP2')->nullable(); //Foreign Key Users
            $table->unsignedBigInteger('WO_AP3')->nullable(); //Foreign Key Users
            $table->unsignedBigInteger('WO_AP4')->nullable(); //Foreign Key Users
            $table->unsignedBigInteger('WO_AP5')->nullable(); //Foreign Key Users

            $table->integer('WO_APStep')->nullable(); 
            $table->integer('WO_APMaxStep')->nullable(); 
            $table->dateTime('Update_Date')->nullable(); 
            $table->timestamps();

            // Foreign Key
            $table->foreign('Case_No')->references('Case_No')->on('cases')->onDelete('cascade');
            $table->foreign('CR_BY')->references('id')->on('users')->onDelete('cascade');

            // $table->foreign('WO_DoneBy')->references('id')->on('users')->onDelete('cascade');
            
            $table->foreign('WO_MR')->references('id')->on('users')->onDelete('cascade');

            $table->foreign('WO_CompBy')->references('id')->on('users')->onDelete('set null');
            $table->foreign('WO_RejBy')->references('id')->on('users')->onDelete('set null');

            $table->foreign('WO_AP1')->references('id')->on('users')->onDelete('set null');
            $table->foreign('WO_AP2')->references('id')->on('users')->onDelete('set null');
            $table->foreign('WO_AP3')->references('id')->on('users')->onDelete('set null');
            $table->foreign('WO_AP4')->references('id')->on('users')->onDelete('set null');
            $table->foreign('WO_AP5')->references('id')->on('users')->onDelete('set null');
        
        });

  
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Work_Orders');
    }
};
