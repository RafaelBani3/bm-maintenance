<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cats extends Model
{
    protected $primaryKey = 'Cat_No';
    public $incrementing = false; 
    protected $keyType = 'string'; 
    protected $table = 'Cats';

    protected $fillable = [
        'Cat_No',    
        'Cat_Name',
        'Cat_Desc',
    ];

    public function getIncrementCatNo()
    {
        $currentYear = date('Y');
        $currentMonth = date('m');

        $lastNumber = $this
        ->whereYear('created_at', $currentYear)
        ->whereMonth('created_at', $currentMonth)
        ->select(DB::raw("IFNULL(MAX(CAST(TRIM(LEADING '0' FROM SUBSTR(Cat_No, 1, 3)) AS UNSIGNED)), 0) AS max_n"))
        ->first()   
        ->max_n;
            

        return str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->Cat_No = $model->getIncrementCatNo();
        });
    }

    public function cases()
    {
        return $this->hasMany(Cases::class, 'Cat_ID', 'Cat_ID');
    }


    // Atur Cat_No -> Primary Key
    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($model) {
    //         $lastCatNo = static::orderBy('Cat_No', 'desc')->first();

    //         if ($lastCatNo) {
    //             $lastNumber = preg_replace('/[^0-9]/', '', $lastCatNo->Cat_No); // Ambil angka saja
    //             $number = intval($lastNumber) + 1;
    //         } else {
    //             $number = 1; 
    //         }

    //         $model->Cat_No = str_pad($number, 3, '0', STR_PAD_LEFT); 
    //     });
    // }
}
