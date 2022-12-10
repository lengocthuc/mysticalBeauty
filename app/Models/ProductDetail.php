<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use HasFactory;
    protected $table = 'tblproductdetail';
    public $timestamps = false;
    public $fillable = ['color','quantity'];
    public function product()
    {
        return $this->belongsTo(Product::class,'productId','id');
    }
    public function images(){
        return $this->hasMany(Image::class,'productId');
    }
    public function carts(){
        return $this->belongsToMany(Cart::class,'tblCartDetail','cartId');
    }
    public function orders(){
        return $this->belongsToMany(Order::class,'tblOrderItem','orderId');
    }
}
