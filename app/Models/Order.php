<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'tblOrder';
    protected $fillable = ['id','memberId','status','totalAmount','discount','shipCost','address','createAt'];
    public $timestamps = false;
    public $incrementing = false;
    public function user(){
        return $this->belongsTo(User::class,'memberId','id');
    }
    public function productDetail(){
        return $this->belongsToMany(ProductDetail::class,'tblOrderItem','orderId','productId')
            ->withPivot('price','quantity');
    }
}
