<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Subcats extends Model
{
    protected $primaryKey = 'Scat_No';
    public $incrementing = false; 
    protected $keyType = 'string'; 
    protected $table = 'Subcats';
        public $timestamps = true;


    protected $fillable = [
        'Scat_No',    
        'Cat_No', //Foreign Key
        'Scat_Name',
        'Scat_Desc',
    ];

    public function getIncrementCatNo()
    {
        $currentYear = date('Y');
        $currentMonth = date('m');

        $lastNumber = $this
        ->whereYear('created_at', $currentYear)
        ->whereMonth('created_at', $currentMonth)
        ->select(DB::raw("IFNULL(MAX(CAST(TRIM(LEADING '0' FROM SUBSTR(Scat_No, 1, 3)) AS UNSIGNED)), 0) AS max_n"))
        ->first()   
        ->max_n;
            
        return str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->Scat_No = $model->getIncrementCatNo();
        });
    }

    public function cases()
    {
        return $this->hasMany(Cases::class, 'Scat_ID', 'Scat_ID');
    }
    
    // Atur Cat_No -> Primary Key
    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($model) {
    //         $lastScatNo = static::orderBy('Scat_No', 'desc')->first();

    //         if ($lastScatNo) {
    //             $lastNumber = preg_replace('/[^0-9]/', '', $lastScatNo->Scat_No); // Ambil angka saja
    //             $number = intval($lastNumber) + 1;
    //         } else {
    //             $number = 1; 
    //         }

    //         $model->Scat_No = str_pad($number, 3, '0', STR_PAD_LEFT); 
    //     });
    // }
}
