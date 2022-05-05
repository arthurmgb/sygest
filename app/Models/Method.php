<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Method extends Model
{
    use HasFactory;

    protected $fillable = ['descricao', 'status', 'user_id'];

    public function operations(){

        return $this->hasMany(Operation::class);

    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
