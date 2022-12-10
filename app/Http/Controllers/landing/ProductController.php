<?php

namespace App\Http\Controllers\landing;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;

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

    public function addToCart(Request $request){
        try{
            DB::beginTransaction();
            $cart = Cart::with('productDetail')->where('memberId',session('user')['id'])->first();
            if($cart == null){
                $cart = Cart::query()->create([
                    'memberId' => session('user')['id'],
                    'createAt' => date('Y-m-d')
                ]);
            }
            if(!ProductDetail::query()->where('id',$request->get('product'))->exists()){
                throw new Exception();
            }
            $detail = $cart->productDetail->find($request->get('product'));
            if($detail){
                $cart->productDetail()->updateExistingPivot($request->get('product'),[
                    'quantity'=>$detail->pivot->quantity + $request->get('quantity')
                ]);
            }
            else{
                $cart->productDetail()->attach($request->get('product'),[
                    'quantity' => $request->get('quantity'),
                    'createAt' => date('Y-m-d')
                ]);
            }
            DB::commit();
            return response()->json([
                'message'=>'Thêm thành công!'
            ]);
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'message'=>'Có lỗi xảy ra!'
            ],500);
        }
    }
    public function buyNow(Request $request){
        try{
            DB::beginTransaction();
            $cart = Cart::with('productDetail')->where('memberId',session('user')['id'])->first();
            if($cart == null){
                $cart = Cart::query()->create([
                    'memberId' => session('user')['id'],
                    'createAt' => date('Y-m-d')
                ]);
            }
            if(!ProductDetail::query()->where('id',$request->get('color'))->exists()){
                dd($request->all());
                throw new \Exception();
            }
            $detail = $cart->productDetail->find($request->get('color'));
            if($detail){
                $cart->productDetail()->updateExistingPivot($request->get('color'),[
                    'quantity'=>$detail->pivot->quantity + $request->get('quantity')
                ]);
            }
            else{
                $cart->productDetail()->attach($request->get('color'),[
                    'quantity' => $request->get('quantity'),
                    'createAt' => date('Y-m-d')
                ]);
            }
            DB::commit();
            return redirect()->route('cart.index');
        }catch (\Exception $e){
            DB::rollBack();
            dd($e);
            return redirect()->back();
        }
    }
}
