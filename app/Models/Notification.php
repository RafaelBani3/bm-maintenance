<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'Notification';
    protected $primaryKey = 'Notif_No';
    public $timestamps = false; 

    protected $fillable = [
        'Notif_No',
        'Notif_Title',
        'Notif_Text',
        'Notif_IsRead',
        'Notif_From',
        'Notif_To',
        'Notif_Date',
        'Notif_Type',
    ];

    /**
     * Relasi ke User yang mengirim notifikasi.
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'Notif_From');
    }

    /**
     * Relasi ke User yang menerima notifikasi.
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'Notif_To');
    }
}
