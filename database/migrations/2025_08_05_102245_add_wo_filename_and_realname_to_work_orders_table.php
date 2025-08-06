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
        Schema::table('Work_Orders', function (Blueprint $table) {
            $table->string('WO_Realname')->nullable()->after('WO_Narative');
            $table->string('WO_Filename')->nullable()->after('WO_Realname');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('Work_Orders', function (Blueprint $table) {
            $table->dropColumn(['WO_Realname', 'WO_Filename']);
        });
    }
};
