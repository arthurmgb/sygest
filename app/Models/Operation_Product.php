<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operation_Product extends Model
{
    use HasFactory;

    protected $table = 'operation_products';

    protected $fillable = ['nome_produto', 'preco_unitario', 'quantidade_vendida', 'subtotal_vendido', 'operation_id'];
}
