<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Imgs extends Model
{
    protected $primaryKey = 'IMG_No';
    public $incrementing = false; 
    protected $keyType = 'string'; 
    protected $table = 'imgs';

    protected $fillable = [
        'IMG_No',    
        'IMG_Type',
        'IMG_RefNo',
        'IMG_Filename',
        'IMG_Realname',
    ];

    public static function generateImgNo()
    {
        $lastImg = self::orderByDesc('IMG_No')->first();
    
        if (!$lastImg) {
            $newNumber = 1;
        } else {
            $lastNumber = (int) substr($lastImg->IMG_No, 3); 
            $newNumber = $lastNumber + 1;
        }
    
        return 'IMG' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }
    
}
