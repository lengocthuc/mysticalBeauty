<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class SubCategoryController extends Controller
{
    public function index()
    {
        return view('admin.subCategories.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.subCategories.create');
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
                $category = new SubCategory([
                    'name'=>$request->get('name'),
                    'categoryId' => $request->get('categoryId')
                ]);
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
        return view('admin.subCategories.edit',[
            'subCategory'=>SubCategory::with('category')->find($id)
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
                $category = SubCategory::query()->findOrFail($id);
                $category->update([
                    'name'=>$request->get('name'),
                    'categoryId'=>$request->get('categoryId'),
                ]);
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
                SubCategory::destroy($id);
            });
            return \response()->json(['message'=>'Xóa thành công!']);
        }catch (\Exception){
            return \response()->json(['message'=>'Có lỗi xảy ra!'],500);
        }
    }



    public function getSubCategoryData(Request $request){
        $data = SubCategory::query()
            ->join('tblCategory','tblCategory.id','=','tblSubcategory.categoryId')
            ->where('tblSubcategory.name','like','%'.$request->all()['search']['value'].'%')
            ->select(['tblSubcategory.id','tblSubcategory.name','tblCategory.name as parentName']);
        return Datatables::of($data)
            ->addColumn('edit', function($object){
                $link = route('subCategories.edit',$object);
                return '<a href="'.$link.'" class="edit btn btn-primary btn-sm">sửa</a>';
            })
            ->addColumn('delete', function($object){
                return route('subCategories.delete',$object);
            })
            ->rawColumns(['edit'])
            ->make(true);
    }

    public function getSubCategory(Request $request){
        return response()->json([
            'results' => SubCategory::query()
                ->Where('name','like','%'.$request->get('q').'%')->get(),
        ]);
    }
}
