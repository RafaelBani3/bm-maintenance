<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MatReq extends Model
{
    use HasFactory;

    protected $table = 'mat_req';
    protected $primaryKey = 'MR_No';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'MR_No',
        'Case_No',
        'WO_No',
        'MR_Date',
        'CR_BY',
        'CR_DT',
        'MR_Allotment',
        'MR_IsUrgent',
        'MR_Status',
        'MR_IsReject',
        'MR_RejGroup',
        'MR_RejBy',
        'MR_RejDate',
        'MR_RMK1',
        'MR_RMK2',
        'MR_RMK3',
        'MR_RMK4',
        'MR_RMK5',
        'MR_AP1',
        'MR_AP2',
        'MR_AP3',
        'MR_AP4',
        'MR_AP5',
        'MR_APStep',
        'MR_APMaxStep',
        'Update_Date',
    ];

    // Relasi ke child
    public function children()
    {
        return $this->hasMany(MatReqChild::class, 'MR_No', 'MR_No');
    }

    // Relasi ke case
    public function case()
    {
        return $this->belongsTo(Cases::class, 'Case_No', 'Case_No');
    }

    // Relasi ke work order
    public function workOrder()
    {
        return $this->belongsTo(WorkOrder::class, 'WO_No', 'WO_No');
    }

    // Relasi ke user pembuat
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'CR_BY');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'PS_ID');
    }

    public static function generateMRNo()
    {
        $currentMonth = date('n');
        $currentYear = date('Y');
    
        $monthRoman = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];
    
        $romanMonth = $monthRoman[$currentMonth];
    
        $lastNumber = DB::table('mat_req')
            ->whereYear('CR_DT', $currentYear)
            ->whereMonth('CR_DT', $currentMonth)
            ->select(DB::raw("IFNULL(MAX(CAST(TRIM(LEADING '0' FROM SUBSTR(MR_No, 1, 3)) AS UNSIGNED)), 0) AS max_n"))
            ->first()
            ->max_n;
    
        $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
    
        return "$newNumber/MR/$romanMonth/$currentYear";
    }

}



