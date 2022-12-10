<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImageValidation;
use Illuminate\Support\Str;


class ImageController extends Controller
{
    public function storeImage(ImageValidation $request) {
        if($request->hasfile('img'))
        {
            foreach($request->file('img') as $file)
            {
                $name = (string) Str::uuid().'.'.$file->extension();
                $file->move(public_path().'/files/', $name);
                $data[] = ['name'=>$name];
            }
            return response()->json([
                'tab' => $request->get('tab'),
                'urls' => (object)$data,
            ]);
        }
    }
}
