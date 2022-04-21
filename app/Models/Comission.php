<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comission extends Model
{
    use HasFactory;

    protected $fillable = ['comissionado_id', 'contract_id', 'valor', 'previsao', 'pagamento', 'status', 'status_contrato'];

    //Relação um a muitos
    public function user(){
        return $this->belongsTo(User::class, 'comissionado_id', 'id');
    }

    public function contract(){
        return $this->belongsTo(Contract::class);
    }
    
}
