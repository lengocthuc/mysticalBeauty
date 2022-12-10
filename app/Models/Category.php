<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'tblCategory';
    public $timestamps = false;
    protected $fillable = ['name'];
    public function subCategory(){
        return $this->hasMany(SubCategory::class,'categoryId');
    }
}
