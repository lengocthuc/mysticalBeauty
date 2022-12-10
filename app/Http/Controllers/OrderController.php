<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(){
        $cart = Cart::with('productDetail.product')
            ->where('memberId',session('user')['id'])
            ->first();
        return view('landing.order.index',[
            'details' => $cart->productDetail
        ]);
    }

    public function order(Request $request){
        try{
            DB::begintransaction();
            $cart = Cart::with('productDetail')
                ->where('memberId',session('user')['id'])
                ->firstOrFail();
            if($cart->productDetail->count()<=0){
                throw new \Exception();
            }
            $member = session('user');
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $ID = session('user')['email'] . date('d:m:Y H:i:s');
            $order = new Order([
                'id'=>substr(strtoupper(sha1($ID)),0,15),
                'memberId' => session('user')['id'],
                'totalAmount'=> $cart->productDetail->reduce(function ($total,$item){
                    return $total += $item->pivot->quantity * $item->product->price;
                },0),
                'shipCost' => 30000,
                'address'=> $request->get('address') ?: session('user')['address'] ,
                'createAt'=> date('Y-m-d'),
            ]);
            $member->orders()->save($order);
            foreach($cart->productDetail as $product) {
                $order->productDetail()->attach($product->id,[
                    'price'=>$product->product->price,
                    'quantity'=>$product->pivot->quantity
                ]);
            };
            $member->load('orders.productDetail');
            $cart->productDetail()->sync([]);
            DB::commit();
            $request->session()->flash('ordered',[
                'message'=>'Đặt hàng thành công',
                'status' => 'success'
            ]);
            return redirect()->route('home-page');
        }catch (\Exception $ex){
            DB::rollBack();
            session()->flash('order-fail',[
                'message'=>'Có lỗi xảy ra',
                'status' => 'danger'
            ]);
            return redirect()->route('order.index');
        }
    }

    public function getOrderByStatus($status,$page=1,$size=15){
        $order = Order::query()->where('status',$status)->skip(($page-1)*$size)->take($size)->get();
        return view('admin.orders.index',[
            'orders'=>$order,
            'total'=>Order::query()->count(),
            'size'=>$size,
            'current_page'=>$page,
            'status'=>$status
        ]);
    }
    public function confirm($id,Request $request){
        try{
            DB::begintransaction();
            $order = Order::query()->where('id',$id)->firstOrFail();
            if($order->status == 'PENDING') $status = 'PROCESSING';
            if($order->status == 'PROCESSING') $status = 'DELIVERING';
            $order->update([
                'status'=>$status
            ]);
            DB::commit();
            return redirect()->route('order.getByStatus',$request->get('status'));
        }catch (\Exception){
            DB::rollBack();
            return redirect()->route('order.getByStatus',$request->get('status'));
        }
    }
    public function cancel($id,Request $request){
        try{
            DB::begintransaction();
            $order = Order::query()->where('id',$id)->firstOrFail();
            $order->update([
                'status'=>'CANCELLED'
            ]);
            DB::commit();
            return redirect()->route('order.getByStatus',$request->get('status'));
        }catch (\Exception){
            DB::rollBack();
            return redirect()->route('order.getByStatus',$request->get('status'));
        }
    }
}
