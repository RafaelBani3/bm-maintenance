<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    protected $primaryKey = 'dept_no';
    public $timestamps = true;
    protected $table = 'departments';
    public $incrementing = false;
    protected $keyType = 'string';


    protected $fillable = [
       'dept_no',
       'dept_name',
       'dept_desc',
       'dept_code'
    ];

    public function positions()
    {
        return $this->hasMany(Position::class, 'dept_no');
    }

    // 🔢 Generate Dept_No secara otomatis
    public static function generateDeptNo()
    {
        $last = self::where('dept_no', 'like', 'DEPT%')
            ->orderByRaw("CAST(SUBSTRING(dept_no, 5) AS UNSIGNED) DESC")
            ->first();

        if (!$last) {
            $newNumber = 1;
        } else {
            $lastNumber = (int) substr($last->dept_no, 4);
            $newNumber = $lastNumber + 1;
        }

        return 'DEPT' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }


       protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->dept_no = $model->generateDeptNo();
        });
    }

}
