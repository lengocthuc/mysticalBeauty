<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class User extends Model
{
    use  HasFactory;
    protected $table = 'tblMember';
    protected $fillable = ['email','name','address','phoneNumber','password'];
    protected $hidden = ['id','password','isAdmin'];
    public $timestamps = false;

    public function cart(){
        return $this->hasOne(Cart::class,'memberId');
    }
    public function orders(){
        return $this->hasMany(Order::class,'memberId');
    }
}
