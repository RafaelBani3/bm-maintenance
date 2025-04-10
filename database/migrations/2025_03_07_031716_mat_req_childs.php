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
        Schema::create('Mat_Req_Child', function (Blueprint $table) {
                $table->string('MR_No', 300);
                $table->integer('MR_Line');
                $table->integer('Item_Oty'); 

                $table->string('Item_Code', 255)->nullable();
                $table->string('Item_Name', 255)->nullable();
                $table->integer('Item_Stock')->nullable();

                $table->string('UOM_Code', 30);
                $table->string('UOM_Name',255);
                $table->string('Remark',255);
                $table->timestamps();

                // Definisikan Composite Primary Key
                $table->primary(['MR_No', 'MR_Line']);

                // Foreign Key Constraints
                $table->foreign('MR_No')->references('MR_No')->on('mat_req')->onDelete('cascade');
                
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Mat_Req_Child');

    }
};
