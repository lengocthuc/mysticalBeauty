<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $featuredProducts = Product::with('productDetail.images')->get()->take(6);
        return view('landing.index',[
            'featuredProducts' => $featuredProducts,
        ]);
    }

    public function dashboard(){
        return view('admin.index',[
            'customers'=>User::query()->where('isAdmin','false')->count(),
            'products'=>Product::query()->count(),
            'orders'=>Order::query()->count()
        ]);
    }
}
