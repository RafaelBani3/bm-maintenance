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
        Schema::create('WO_DoneBy', function (Blueprint $table) {
            // $table->bigIncrements('WO_DoneBy_No'); 
            $table->string('WO_No', 30);
            $table->string('technician_id', 20);

            $table->timestamps();
            $table->primary(['WO_No', 'technician_id']); 

            // Foreign  Key
            $table->foreign('technician_id')->references('technician_id')->on('technician')->onDelete('cascade');
            $table->foreign('WO_No')->references('WO_No')->on('Work_Orders')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('WO_DoneBy');

    }
};
