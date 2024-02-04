<?php

namespace App\Models;
use App\Models\Sale;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    use HasFactory;
    protected $table = 'buyers';
    protected $fillable = [
        'name',
        'no_telp',
        'address',
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class, 'buyer_id');
    }

}