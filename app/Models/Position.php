<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{

    protected $table = 'Positions';
    protected $fillable = 
    [
        'PS_ID',
        'PS_Name', 
        'PS_Desc'
    ];

    public static function generatePositionNo()
    {
        $lastPosition = self::orderByDesc('id')->first();
    
        if (!$lastPosition) {
            $newNumber = 1;
        } else {
            $lastNumber = (int) substr($lastPosition->id, 3); 
            $newNumber = $lastNumber + 1;
        }
    
        return 'PS' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }


}
