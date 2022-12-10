<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index(){
        $cart = Cart::with('productDetail.product')
            ->where('memberId',session('user')['id'])
            ->first();
        return view('landing.cart.index',[
            'details' => $cart->productDetail
        ]);
    }
    public function delete(Request $request){
        trY{
            DB::begintransaction();
            $cart = Cart::with('productDetail')
                ->where('memberId',session('user')['id'])
                ->firstOrFail();
            $cart->productDetail()->detach($request->get('productId'));
            $cart->load('productDetail.product');
            DB::commit();
            return response()->json([
               'message'=>'Xóa thành công!',
                'total_price' => $cart->productDetail->reduce(function ($total,$item){
                    return $total += $item->pivot->quantity * $item->product->price;
                },0)
            ]);
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'message'=>'Có lỗi xảy ra!'
            ],500);
        }
    }
    public function updateQuantity(Request $request){
        trY{
            DB::begintransaction();
            $cart = Cart::with('productDetail')
                ->where('memberId',session('user')['id'])
                ->firstOrFail();
            if($request->get('productId')  && $request->get('quantity')){
                $cart->productDetail()->updateExistingPivot($request->get('productId'),[
                    'quantity'=>$request->get('quantity')
                ]);
                $cart->load('productDetail.product');
                $detail = $cart->productDetail->find($request->get('productId'));
            }
            else{
                throw new \Exception();
            }
            DB::commit();
            return response()->json([
                'message'=>'Thành công!',
                'product_price'=> $detail->pivot->quantity*$detail->product->price,
                'total_price' => $cart->productDetail->reduce(function ($total,$item){
                    return $total += $item->pivot->quantity * $item->product->price;
                },0)
            ]);
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'message'=>'Có lỗi xảy ra!'
            ],500);
        }
    }
}
