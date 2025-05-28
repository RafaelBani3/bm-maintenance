<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatReqChild extends Model
{
    use HasFactory;

    protected $table = 'Mat_Req_Child';
    public $incrementing = false;
    protected $primaryKey = null;
    protected $keyType = 'string';

    protected $fillable = [
        'MR_No',
        'MR_Line',
        'Item_Oty',
        'CR_ITEM_SATUAN',
        'CR_ITEM_CODE',
        'CR_ITEM_NAME',
        'Item_Code',
        'Item_Name',
        'Item_Stock',
        'UOM_Code',
        'UOM_Name',
        'Remark',
    ];

    // Relasi ke header
    public function matReq()
    {
        return $this->belongsTo(MatReq::class, 'MR_No', 'MR_No');
    }
}

