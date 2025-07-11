<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class technician extends Model
{
    protected $table = 'technician';
    protected $primaryKey = 'technician_id';
    public $incrementing = false;
    protected $keyType = 'string';
        public $timestamps = true;


    protected $fillable = [
        'technician_id',
        'technician_Name',
        'PS_ID'
    ];

    public function workOrders()
    {
        return $this->belongsToMany(WorkOrder::class, 'WO_DoneBy', 'technician_id', 'WO_No');
    }
    

    public function position()
    {
        return $this->belongsTo(Position::class, 'PS_ID');
    }

    public function getIncrementTechnicianNo()
    {
        $currentYear = date('Y');
        $currentMonth = date('m');

        $lastNumber = $this
        ->whereYear('created_at', $currentYear)
        ->whereMonth('created_at', $currentMonth)
        ->select(DB::raw("IFNULL(MAX(CAST(TRIM(LEADING '0' FROM SUBSTR(technician_id, 1, 3)) AS UNSIGNED)), 0) AS max_n"))
        ->first()   
        ->max_n;
            
        return 'Technician' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
    }


}
