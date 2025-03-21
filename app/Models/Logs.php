<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    use HasFactory;
    protected $table = 'Logs';
    protected $primaryKey = 'Logs_No';
    public $timestamps = false;

    protected $fillable = [
        'Logs_No',
        'LOG_Type',
        'LOG_RefNo',
        'LOG_Status',
        'LOG_User',
        'LOG_Date',
        'LOG_Desc',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'LOG_User');
    }

    public static function generateLogsNo()
    {
        $lastLogs = self::orderByDesc('Logs_No')->first();
    
        if (!$lastLogs) {
            $newNumber = 1;
        } else {
            $lastNumber = (int) substr($lastLogs->Logs_No, 3); 
            $newNumber = $lastNumber + 1;
        }
    
        return 'LOG' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }
}
