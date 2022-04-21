<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['contract_id', 'user_id', 'valor', 'valor_pago', 'vencimento', 'pagamento', 'status', 'status_contrato'];

    public function contract(){
        return $this->belongsTo(Contract::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
