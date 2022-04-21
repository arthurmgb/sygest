<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;

    protected $fillable = ['payment_id', 'nome', 'documento', 'cidade', 'estado'];

    public function payment(){
        return $this->belongsTo(Payment::class);
    }

}
