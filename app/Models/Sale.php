<?php

namespace App\Models;
use App\Models\Buyer;
use App\Models\Product;
use App\Models\DetailSale;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $table = 'sales';
    protected $fillable =  [
        'buyer_id',
        'product_id',
        'quantity',
        'total_price',
    ];

    public function buyer()
    {
        return $this->belongsTo(Buyer::class, 'buyer_id');
    }

    public function details()
    {
        return $this->hasMany(DetailSale::class, 'sale_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    
}
