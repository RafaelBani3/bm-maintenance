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
        Schema::create('Notification', function (Blueprint $table) {
            $table->id('Notif_No')->primary();
            $table->enum('Notif_Type', ['BA', 'MR', 'WO'])->nullable();
            $table->string('Reference_No', 30);
            $table->string('Notif_Title', 255);
            $table->string('Notif_Text', 255);
            $table->enum('Notif_IsRead', ['Y', 'N']);
            $table->unsignedBigInteger('Notif_From'); 
            $table->unsignedBigInteger('Notif_To'); 
            $table->dateTime('Notif_Date');
            $table->timestamps();

            // Foreign Key
            $table->foreign('Notif_From')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('Notif_To')->references('id')->on('users')->onDelete('cascade');
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Notification');
    }
};
