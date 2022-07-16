<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Secret extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'descricao', 'login', 'senha'];

     //Relação um a muitos
    public function user(){
        return $this->belongsTo(User::class);
    }
    
}
