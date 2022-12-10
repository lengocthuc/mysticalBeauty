<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $table = 'tblImage';
    public $timestamps = false;
    public $fillable = ['productId','name'];
    public function product(){
        return $this->belongsTo(ProductDetail::class,);
    }
}
