<?php

namespace App\Models;
use App\Models\Sale;
use App\Models\DetailSale;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'name',
        'price',
        'stok',
    ];
    public function details()
    {
        return $this->hasMany(DetailSale::class, 'product_id');
    }

    public function sales()
    {
        return $this->hasMany(DetailSale::class, 'sale_id');
    }
}
