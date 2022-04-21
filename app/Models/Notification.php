<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'content', 'is_read'];

    //Relação um a muitos
    public function user(){
        return $this->belongsTo(User::class);
    }
}
