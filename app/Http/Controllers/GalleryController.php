<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;
use App\Helper\ApiHelper;
use Illuminate\Support\Facades\Storage;
use Str;

class GalleryController extends Controller
{
    public function store(Request $request){
        $image_64 = $request->get('file'); 

        foreach ($image_64 as $key => $value) {
            $extension = explode('/', explode(':', substr($value, 0, strpos($value, ';')))[1])[1];   // .jpg .png .pdf
        
            $replace = substr($value, 0, strpos($value, ',')+1); 
        
            $image = str_replace($replace, '', $value); 
        
            $image = str_replace(' ', '+', $image); 
        
            $imageName = Str::random(10).'.'.$extension;
        
            // $value->move(public_path('images/'),$imageName.base64_decode($image));
            Storage::disk('public')->put($imageName, base64_decode($image));
        
            $gallery = new Gallery();
            $gallery->filename = $imageName;
            $gallery->save();
        }

        // return response()->json(
        //     [
        //         'status_code' => 200,
        //         'response' => 'success',
        //         'object' => $gantt,
        //     ]
        // );
        
        $result = ApiHelper::success('Gantt Chart Created Successfully', $gallery);
        return response()->json($result, 200);
    }

    public function showGallery(){
        $gallery= Gallery::all();
        $result = ApiHelper::success('Gallery Loaded Successfully', $gallery);
        return response()->json($result, 200);
    }
}