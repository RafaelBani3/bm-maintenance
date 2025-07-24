<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration

{
    /**
     * Run the migrations.
     */
     public function up(): void
    {
        DB::statement("ALTER TABLE material_requests MODIFY COLUMN MR_Status ENUM('OPEN','SUBMIT','AP1','AP2','AP3','AP4','AP5','CLOSE','REJECT','INPROGRESS','DONE','SAVE_DRAFT') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE material_requests MODIFY COLUMN MR_Status ENUM('OPEN','SUBMIT','AP1','AP2','AP3','AP4','AP5','CLOSE','REJECT','INPROGRESS','DONE','SAVE_DRAFT') NOT NULL");
    }
};
