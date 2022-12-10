<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'tblCart';
    public $timestamps = false;
    protected $fillable = ['memberId','createAt'];
    protected $primaryKey = 'id';
    public function productDetail(){
        return $this->belongsToMany(productDetail::class,'tblCartDetail','cartId','productId')
            ->withPivot('quantity','createAt');
    }
}
