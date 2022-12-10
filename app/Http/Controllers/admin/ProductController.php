<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Nette\NotImplementedException;
use Spatie\FlareClient\Http\Exceptions\NotFound;
use Yajra\DataTables\DataTables;
class ProductController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('admin.products.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try{
            DB::transaction(function () use ($request) {
                $product = new Product($request->get('product'));
                $product->save();
                $reqDetails = $request->get('details');
                $details = [];
                $images = [];
                foreach ($reqDetails as $detail){
                    array_push($details,new ProductDetail([
                        'color' => $detail['color'],
                        'quantity' => $detail['quantity'],
                    ]));
                    array_push($images,$detail['urls']);
                }
                $productDetail = $product->productDetail()->saveMany($details);
                foreach ($productDetail as $key => $item){
                    //dd($images[$key]);
                    $item->images()->createMany($images[$key]);
                }
                if($request->has('categories')){
                    $categories = $request->get('categories');
                    $product->categories()->attach($categories);
                }
                else{
                    throw new NotImplementedException();
                }
            });
            return response()->json([
                'message'=>'Thêm thành công!'
            ],200);
        }catch (\Exception $e){
            return response()->json([
                'message'=>'có lỗi xảy ra!'
            ],500);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $product = Product::with(['productDetail','categories'])->find($id);
        if($product != null){
            return view('admin.products.show',[
                'product' => $product,
                'details' => $product->productDetail,
                'categories' => $product->categories,
            ]);
        }
        else{
            return route('admin.products.index');
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $product = Product::with(['productDetail','categories'])->find($id);
        if($product != null){
            return view('admin.products.edit',[
                'product' => $product,
                'details' => $product->productDetail,
                'categories' => $product->categories,
            ]);
        }
        else{
            return abort(404);
        }
    }


    public function update(Request $request, $id)
    {
        try{
            DB::transaction(function () use ($request,$id) {
                $product = Product::with(['productDetail'])->find($id);
                $product->update($request->get('product'));
                $reqDetails = $request->get('details');
                $details = [];
                $images = [];
                foreach ($reqDetails as $detail){
                    array_push($details,new ProductDetail([
                        'color' => $detail['color'],
                        'quantity' => $detail['quantity'],
                    ]));
                    array_push($images,$detail['urls']);
                }
                $oldDetails = $product->productDetail;
                foreach ($oldDetails as $detail){
                    $oldImages[] = $detail->images->map(function ($value){
                        return $value->only('name');
                    });
                }
                $product->productDetail()->delete();
                $productDetails = $product->productDetail()->saveMany($details);
                foreach ($productDetails as $key => $item){
                    if($images[$key][0]['name'] == null){
                        $item->images()->createMany($oldImages[$key]);
                    }
                    else{
                        $item->images()->createMany($images[$key]);
                    }
                }
                if($request->has('categories')){
                    $categories = $request->get('categories');
                    $product->categories()->sync($categories);
                }
                else{
                    throw new NotImplementedException();
                }
            });
            return response()->json([
                'message'=> 'Sửa thành công'
            ]);
        }catch (\Exception $e){
            return response()->json([
                'message'=> 'có lỗi xảy ra!'
            ],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy($id)
    {
        try{
            DB::transaction(function () use ($id){
                Product::destroy($id);
            });
            return response()->json([
                'message' => 'Xoá thành công!'
            ]);
        }catch (\Exception){
            return response()->json([
                'message' => 'Xoá thất bại!'
            ],500);
        }
    }

    public function getProduct(Request $request){
        $data = Product::query()
            ->where('name','like','%'.$request->all()['search']['value'].'%');
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('edit', function($object){
                $link = route('products.edit',$object);
                return '<a href="'.$link.'" class="edit btn btn-primary btn-sm">sửa</a>';
            })
            ->addColumn('show', function($object){
                $link = route('products.show',$object);
                return '<a href="'.$link.'" class="edit btn btn-secondary btn-sm">xem</a>';
            })
            ->addColumn('delete', function($object){
                return route('products.destroy',$object);
            })
            ->rawColumns(['edit','show'])
            ->make(true);
    }
}
