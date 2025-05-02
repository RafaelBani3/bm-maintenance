<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WoDoneBy extends Model
{
    protected $keyType = 'string'; 
    protected $table = 'wo_doneby';
    public $timestamps = false; 
    
    protected $fillable = [ 
        'WO_No',
        'technician_id'
    ];
}
