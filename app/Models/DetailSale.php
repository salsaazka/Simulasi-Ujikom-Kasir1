<?php

namespace App\Models;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailSale extends Model
{
    use HasFactory;
    protected $table = 'detail_sales';
    protected $fillable = [
         'sale_id',
         'product_id',
         'total_produk',
         'subtotal',
    ];
    
    public function sales()
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
