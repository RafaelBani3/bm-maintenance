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
        Schema::create('Mat_Req', function (Blueprint $table) {
            $table->string('MR_No', 30)->primary();
            $table->string('Case_No', 30); //Foreign Key
            $table->string('WO_No', 30); //Foreign Key
            $table->dateTime('MR_Date');
            $table->unsignedBigInteger('CR_BY'); //Foreign Key  
            $table->dateTime('CR_DT');  

            $table->string('MR_Allotment', 255);
            $table->enum('MR_IsUrgent', ['Y', 'N']); 
            $table->enum('MR_Status', ['OPEN','SUBMIT','AP1','AP2','AP3','AP4','AP5','CLOSE','REJECT','INPROGRESS','DONE']);
            $table->enum('MR_IsReject', ['Y', 'N']); 
            $table->enum('MR_RejGroup', ['AP1', 'AP2' ,'AP3', 'AP4', 'AP5'])->nullable();
            $table->unsignedBigInteger('MR_RejBy')->nullable(); //Foreign Key users
            $table->dateTime('MR_RejDate')->nullable(); 

            $table->string('MR_RMK1',255)->nullable(); 
            $table->string('MR_RMK2',255)->nullable(); 
            $table->string('MR_RMK3',255)->nullable(); 
            $table->string('MR_RMK4',255)->nullable(); 
            $table->string('MR_RMK5',255)->nullable(); 
            
            $table->unsignedBigInteger('MR_AP1')->nullable(); //Foreign Key users
            $table->unsignedBigInteger('MR_AP2')->nullable(); //Foreign Key users
            $table->unsignedBigInteger('MR_AP3')->nullable(); //Foreign Key users
            $table->unsignedBigInteger('MR_AP4')->nullable(); //Foreign Key users
            $table->unsignedBigInteger('MR_AP5')->nullable(); //Foreign Key users

            
            $table->integer('MR_APStep')->nullable(); 
            $table->integer('MR_APMaxStep')->nullable(); 
            $table->dateTime('Update_Date')->nullable(); 
            $table->timestamps();

             // Foreign Key
            $table->foreign('Case_No')->references('Case_No')->on('cases')->onDelete('cascade');
            $table->foreign('WO_No')->references('WO_No')->on('Work_Orders')->onDelete('cascade');
            $table->foreign('CR_BY')->references('id')->on('users')->onDelete('cascade');
            
            $table->foreign('MR_RejBy')->references('id')->on('users')->onDelete('set null');

            $table->foreign('MR_AP1')->references('id')->on('users')->onDelete('set null');
            $table->foreign('MR_AP2')->references('id')->on('users')->onDelete('set null');
            $table->foreign('MR_AP3')->references('id')->on('users')->onDelete('set null');
            $table->foreign('MR_AP4')->references('id')->on('users')->onDelete('set null');
            $table->foreign('MR_AP5')->references('id')->on('users')->onDelete('set null');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Mat_Req');

    }
};
