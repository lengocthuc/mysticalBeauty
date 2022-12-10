<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\SubCategory;
use http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use function MongoDB\BSON\toJSON;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.categories.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            DB::transaction(function () use ($request){
                $category = new Category(['name'=>$request->get('value')]);
                $category->save();
            });
            return \response()->json(['message'=>'Thêm thành công!']);
        }catch (\Exception){
            return \response()->json(['message'=>'Có lỗi xảy ra!'],500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.categories.edit',[
            'category'=>Category::query()->find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            DB::transaction(function () use ($request,$id){
                $category = Category::query()->findOrFail($id);
                $category->update(['name'=>$request->get('value')]);
            });
            return \response()->json(['message'=>'Sửa thành công!']);
        }catch (\Exception){
            return \response()->json(['message'=>'Có lỗi xảy ra!'],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            DB::transaction(function () use ($id){
                Category::destroy($id);
            });
            return \response()->json(['message'=>'Xóa thành công!']);
        }catch (\Exception){
            return \response()->json(['message'=>'Có lỗi xảy ra!'],500);
        }
    }



    public function getCategoryData(Request $request){
        $data = Category::query()
            ->where('name','like','%'.$request->all()['search']['value'].'%');
        return Datatables::of($data)
            ->addColumn('edit', function($object){
                $link = route('categories.edit',$object);
                return '<a href="'.$link.'" class="edit btn btn-primary btn-sm">sửa</a>';
            })
            ->addColumn('delete', function($object){
                return route('categories.delete',$object);
            })
            ->rawColumns(['edit'])
            ->make(true);
    }
    public function getCategory(Request $request){
        $categories = Category::query()->Where('name','like','%'.$request->get('q').'%')->get();
        return response()->json([
            'results' => $categories,
        ]);
    }
}
