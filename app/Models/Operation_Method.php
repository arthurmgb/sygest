<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operation_Method extends Model
{
    use HasFactory;

    protected $table = 'operation_methods';

    protected $fillable = ['nome_fp', 'valor_pago', 'operation_id'];
}
