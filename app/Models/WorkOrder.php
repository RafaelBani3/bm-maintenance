<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WorkOrder extends Model
{
    protected $primaryKey = 'WO_No';
    public $incrementing = false; 
    protected $keyType = 'string'; 
    protected $table = 'Work_Orders';
    
    protected $fillable = [
        'WO_No', 'Case_No', 'WOC_No', 'CR_BY', 'CR_DT',
        'WO_Start', 'WO_End', 'WO_Status', 'WO_Narative',
        'WO_NeedMat', 'WO_MR', 'WO_IsComplete', 'WO_CompDate',
        'WO_CompBy', 'WO_IsReject', 'WO_RejGroup', 'WO_RejBy',
        'WO_RejDate', 'WO_RMK1', 'WO_RMK2', 'WO_RMK3',
        'WO_RMK4', 'WO_RMK5', 'WO_AP1', 'WO_AP2', 'WO_AP3',
        'WO_AP4', 'WO_AP5', 'WO_APStep', 'WO_APMaxStep', 'Update_Date'
    ];

    public function case()
    {
        return $this->belongsTo(Cases::class, 'Case_No', 'Case_No');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'CR_BY');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'CR_BY', 'id');
    }

    public function completedBy()
    {
        return $this->belongsTo(User::class, 'WO_CompBy');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'CR_BY', 'id');
    }

    public function technicians()
    {
        return $this->belongsToMany(User::class, 'WO_DoneBy', 'WO_No', 'technician_id');
    }


    public function position()
    {
        return $this->belongsTo(Position::class, 'PS_ID');
    }

    public function materialRequest()
    {
        return $this->hasOne(MatReq::class, 'WO_No', 'WO_No');
    }


    public function wo_done_by()
    {
        return $this->belongsTo(User::class, 'WO_CompBy', 'id');
    }

    public function matReqs()
    {
        return $this->hasMany(MatReq::class, 'WO_No', 'WO_No');
    }
    
    public function completer() {
        return $this->belongsTo(User::class, 'WO_CompBy');
    }

    public function getIncrementWONo()
    {
        $currentMonth = date('n');
        $currentYear = date('Y');
    
        $monthRoman = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];
    
        $romanMonth = $monthRoman[$currentMonth];
    
        $lastNumber = DB::table($this->getTable())
            ->whereYear('CR_DT', $currentYear)
            ->whereMonth('CR_DT', $currentMonth)
            ->select(DB::raw("IFNULL(MAX(CAST(TRIM(LEADING '0' FROM SUBSTR(WO_No, 1, 3)) AS UNSIGNED)), 0) AS max_n"))
            ->first()
            ->max_n;
    
        $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
    
        return "$newNumber/WO/$romanMonth/$currentYear";
    }

    public function getIncrementWOCNo()
    {
        $currentMonth = date('n'); 
        $currentYear = date('Y'); 

        $monthRoman = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];
        $romanMonth = $monthRoman[$currentMonth];

        $lastNumber = $this
        ->whereYear('CR_DT', $currentYear)
        ->whereMonth('CR_DT', $currentMonth)
        ->select(DB::raw("IFNULL(MAX(CAST(TRIM(LEADING '0' FROM SUBSTR(WOC_No, 1, 3)) AS UNSIGNED)), 0) AS max_n"))
        ->first()
        ->max_n;

        $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

        return "$newNumber/BMGT/ENG-BAP/$romanMonth/$currentYear";
    }

    // App\Models\WorkOrder.php
    public function materialRequests()
    {
        return $this->hasMany(MatReq::class, 'WO_No', 'WO_No');
    }

    public function approver1()
    {
        return $this->belongsTo(User::class, 'WO_AP1', 'id'); 
    }

    public function approver2()
    {
        return $this->belongsTo(User::class, 'WO_AP2', 'id'); 
    }

}