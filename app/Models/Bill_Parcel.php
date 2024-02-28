<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill_Parcel extends Model
{
    use HasFactory;

    protected $table = 'bill_parcels';

    protected $fillable = ['bill_id', 'user_id', 'status', 'data_vencimento', 'data_baixa', 'n_parcela', 'total'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }
}
