<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class material extends Model
{
    protected $table = 'material';
    protected $primaryKey = 'Material_No';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'Material_No',
        'Material_Name',
        'Material_Stock',
        'Material_Unit',
    ];

    public function getIncrementTechnicianNo()
    {
        $currentYear = date('Y');
        $currentMonth = date('m');

        $lastNumber = $this
        ->whereYear('created_at', $currentYear)
        ->whereMonth('created_at', $currentMonth)
        ->select(columns: DB::raw("IFNULL(MAX(CAST(TRIM(LEADING '0' FROM SUBSTR(Material_No, 1, 3)) AS UNSIGNED)), 0) AS max_n"))
        ->first()   
        ->max_n;
            
        return 'Mat' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
    }
}
