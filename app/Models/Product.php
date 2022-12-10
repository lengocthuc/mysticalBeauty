<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'tblProduct';
    public $timestamps = false;
    protected $fillable = ['name','price','description'];
    protected $primaryKey = 'id';


    public function productDetail()
    {
        return $this->hasMany(ProductDetail::class,'productId')->with('images');
    }
    public function categories()
    {
        return $this->belongsToMany(SubCategory::class, 'tblCategoryProduct','productId');
    }
}
