<?php

namespace App\Http\Controllers\landing;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        $products = Product::query()
            ->join('tblImage','tblProduct.id','=','tblImage.productId')
            ->select('tblProduct.name','price','tblImage.name as img')->get();
        return view('landing.product.index',[
            'products' => $products,
        ]);
    }
    public function show($id){
        $product = Product::with(['productDetail','categories'])->find($id);
        if($product != null){
            return view('landing.products.show',[
                'product' => $product,
                'details' => $product->productDetail,
                'categories' => $product->categories,
            ]);
        }
        else{
            return redirect()->back();
        }
    }
}
