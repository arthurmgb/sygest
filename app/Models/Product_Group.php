<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_Group extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'descricao', 'status'];

    protected $table = 'product_groups';

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
