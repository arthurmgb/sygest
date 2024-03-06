<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = ['data', 'descricao', 'tipo', 'category_id', 'method_id', 'client_id', 'total', 'qtd_parcelas', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function method()
    {
        return $this->belongsTo(Method::class);
    }

    public function parcel()
    {
        return $this->hasMany(Bill_Parcel::class);
    }
}
