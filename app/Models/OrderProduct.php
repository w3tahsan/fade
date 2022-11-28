<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    function rel_to_customer(){
        return $this->belongsTo(CustomerLogin::class, 'customer_id');
    }
    function rel_to_product(){
        return $this->belongsTo(Product::class, 'product_id');
    }
}
