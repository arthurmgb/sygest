<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['descricao', 'preco', 'estoque', 'estoque_minimo', 'status', 'user_id', 'product_group_id'];

    
    public function operations()
    {

        return $this->hasMany(Operation::class);
    }

    public function group()
    {
        return $this->belongsTo(Product_Group::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
