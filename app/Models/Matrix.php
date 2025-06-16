<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Matrix extends Model
{
    protected $table = 'Matrix';
    protected $primaryKey = 'Mat_No';
    public $incrementing = false;
    protected $fillable = ['Mat_No', 'Position', 'Mat_Type', 'Mat_Max', 'AP1', 'AP2', 'AP3', 'AP4', 'AP5'];
    public $timestamps = true;

    public function position()
    {
        return $this->belongsTo(Position::class, 'Position');
    }

    public function approver1()
    {
        return $this->belongsTo(User::class, 'AP1');
    }

    public function approver2()
    {
        return $this->belongsTo(User::class, 'AP2');
    }

    public function approver3()
    {
        return $this->belongsTo(User::class, 'AP3');
    }

    public function approver4()
    {
        return $this->belongsTo(User::class, 'AP4');
    }

    public function approver5()
    {
        return $this->belongsTo(User::class, 'AP5');
    }

    public function getIncrementMatrixNo()
    {
        $lastNumber = $this
        ->select(DB::raw("IFNULL(MAX(CAST(TRIM(LEADING '0' FROM SUBSTR(Mat_No, 1, 3)) AS UNSIGNED)), 0) AS max_n"))
        ->first()   
        ->max_n;
            
        return str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->Mat_No = $model->getIncrementMatrixNo();
        });
    }
}
