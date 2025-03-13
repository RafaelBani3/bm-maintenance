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

    // public static function generateImgNo()
    // {
    //     return 'IMG' . Str::random(10); // Bisa diubah sesuai format yang diinginkan
    // }
    public static function generateImgNo()
    {
        // Ambil IMG_No terakhir dari database
        $lastImg = self::orderByDesc('IMG_No')->first();
    
        // Jika belum ada data, mulai dari 001
        if (!$lastImg) {
            $newNumber = 1;
        } else {
            // Ambil angka dari IMG_No terakhir dan tambah 1
            $lastNumber = (int) substr($lastImg->IMG_No, 3); // Ambil angka setelah "IMG"
            $newNumber = $lastNumber + 1;
        }
    
        // Format dengan leading zeros (3 digit: 001, 002, dst.)
        return 'IMG' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }
    


    // Atur Cat_No -> Primary Key
    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($model) {
    //         $lastIMGNo = static::orderBy('IMG_No', 'desc')->first();

    //         if ($lastIMGNo) {
    //             $lastNumber = preg_replace('/[^0-9]/', '', $lastIMGNo->IMG_No); // Ambil angka saja
    //             $number = intval($lastNumber) + 1;
    //         } else {
    //             $number = 1; 
    //         }

    //         $model->IMG_No = str_pad($number, 3, '0', STR_PAD_LEFT); 
    //     });
    // }
}
