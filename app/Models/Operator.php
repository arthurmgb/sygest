<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operator extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'user_id'];

    //Relação um a muitos
    public function user(){
        return $this->belongsTo(User::class);
    }
}
