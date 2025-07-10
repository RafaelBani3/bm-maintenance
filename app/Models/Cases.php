<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Cases extends Model
{
    protected $primaryKey = 'Case_No';
    public $incrementing = false; 
    protected $keyType = 'string'; 
    protected $table = 'cases';
    public $timestamps = true;


    protected $fillable = [
        'Case_No',    
        'Case_Name',
        'Case_Date',
        'CR_BY',
        'CR_DT',
        'Cat_No', //Foreign Key
        'Scat_No', //Foreign Key

        'Case_Chronology',
        'Case_Outcome',
        'Case_Suggest',
        'Case_Action',

        'Case_Status',
        'Case_IsReject',
        'Case_RejGroup',
        'Case_RejBy', //Foreign  Key
        'Case_RejDate',

        'Case_RMK1',
        'Case_RMK2',
        'Case_RMK3',
        'Case_RMK4',
        'Case_RMK5',

        'Case_AP1',
        'Case_AP2',
        'Case_AP3',
        'Case_AP4',
        'Case_AP5',

        'Case_ApStep',
        'Case_ApMaxStep',
        'Case_Loc_Floor',

        'Case_Loc_Room',
        'Case_Loc_Object',
        'Update_Date',
        'created_at',
        'updated_at',
    ];

    // public function getIncrementCaseNo()
    // {
    //     $currentMonth = date('n'); 
    //     $currentYear = date('Y'); 

    //     $monthRoman = [
    //         1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
    //         7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
    //     ];
    //     $romanMonth = $monthRoman[$currentMonth];

            
    //     $lastNumber = $this
    //     ->whereYear('created_at', $currentYear)
    //     ->whereMonth('created_at', $currentMonth)
    //     ->select(DB::raw("IFNULL(MAX(CAST(TRIM(LEADING '0' FROM SUBSTR(Case_No, 1, 3)) AS UNSIGNED)), 0) AS max_n"))
    //     ->first()
    //     ->max_n;

    //     $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

    //     return "$newNumber/BMGT/ENG-BAK/$romanMonth/$currentYear";
    // }

   public function getIncrementCaseNo()
    {
        $currentMonth = date('n');
        $currentYear = date('Y');

        $monthRoman = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];
        $romanMonth = $monthRoman[$currentMonth];

        $userId = Auth::id();
        $positionId = User::find($userId)?->PS_ID;

        $deptCode = optional(
            Position::with('department')->find($positionId)
        )->department->dept_code ?? 'XXX';

        // Generate nomor urut
        $lastNumber = $this
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->select(DB::raw("IFNULL(MAX(CAST(TRIM(LEADING '0' FROM SUBSTR(Case_No, 1, 3)) AS UNSIGNED)), 0) AS max_n"))
            ->first()
            ->max_n;

        $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

        return "$newNumber/BMGT/{$deptCode}-BAK/$romanMonth/$currentYear";
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->Case_No = $model->getIncrementCaseNo();
        });
    }
    
    public function images()
    {
        return $this->hasMany(Imgs::class, 'IMG_RefNo', 'Case_No');
    }
 
    public function category()
    {
        return $this->belongsTo(Cats::class, 'Cat_No', 'Cat_No'); 
    }

    public function subCategory()
    {
        return $this->belongsTo(Subcats::class, 'Scat_No', 'Scat_No'); 
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'CR_BY', 'id');
    }

    public function approver1()
    {
        return $this->belongsTo(User::class, 'Case_AP1', 'id'); 
    }

    public function approver2()
    {
        return $this->belongsTo(User::class, 'Case_AP2', 'id'); 
    }

    public function workOrder()
    {
        return $this->hasOne(WorkOrder::class, 'Case_No', 'Case_No');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'CR_BY');
    }

}
