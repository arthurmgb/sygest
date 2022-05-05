<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    use HasFactory;

    protected $fillable = ['descricao', 'total', 'tipo', 'category_id', 'operator_id', 'especie', 'method_id', 'user_id'];

    //Relação um a muitos
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function operator(){
        return $this->belongsTo(Operator::class);
    }
    public function method(){
        return $this->belongsTo(Method::class);
    }

}
