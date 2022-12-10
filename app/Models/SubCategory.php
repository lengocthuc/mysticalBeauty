<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    protected $table = 'tblSubCategory';
    public $timestamps = false;
    protected $fillable = ['name','categoryId'];
    protected $primaryKey = 'id';

    public function products()
    {
        return $this->belongsToMany(Product::class, 'tblCategoryProduct','categoryId');
    }
    public function category(){
        return $this->belongsTo(Category::class,'categoryId');
    }
}
