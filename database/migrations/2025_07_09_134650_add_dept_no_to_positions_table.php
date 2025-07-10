<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    public function up()
    {
        // Schema::table('Positions', function (Blueprint $table) {
        //     $table->string('dept_no', 30)->after('PS_Desc')->nullable();

        //     $table->foreign('dept_no')
        //         ->references('dept_no')
        //         ->on('departments')
        //         ->onDelete('set null');
        // });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('Positions', function (Blueprint $table) {
        //     //
        // });
    }
};
