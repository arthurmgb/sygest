<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comission_Receipt extends Model
{
    use HasFactory;

    protected $table = 'comission_receipts';

    protected $fillable = ['comission_id', 'nome', 'chave_pix', 'banco'];

    public function comission(){
        return $this->belongsTo(Comission::class);
    }
}
