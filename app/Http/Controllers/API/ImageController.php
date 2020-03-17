<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\FileUpload;
use Intervention\Image\ImageManagerStatic as Image;

class ImageController extends Controller
{
    public function store(Request $request)
    {
        $imageName = $request->get('image');
        if($imageName)
        {
           $name = time().'.' . explode('/', explode(':', substr($imageName, 0, strpos($imageName, ';')))[1])[1];
           Image::make($request->get('image'))->save(public_path('images/').$name);
           
           $image= new FileUpload();
           $image->image_name = $name;
           $image->save();
    
           return response()->json(['success' => 'You have successfully uploaded an image'], 200);
        }
    }
}