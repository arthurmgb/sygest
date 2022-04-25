<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'comissionado_id', 'periodo', 'valor', 'vencimento', 'status', 'pagas', 'is_test'];

    public function payments(){

        return $this->hasMany(Payment::class);

    }

}
