<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Committee;
use Illuminate\Support\Facades\Storage;
use App\Helper\ApiHelper;
use Str;

class CommitteeController extends Controller
{

    public function addMember(Request $request){
        $committee = new Committee();
        
        $committee->name = $request->name;
        $committee->title = $request->title;
        $committee->description = $request->description;
        $image_64 = $request->get('picture'); 
        $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
    
        $replace = substr($image_64, 0, strpos($image_64, ',')+1); 
    
        $image = str_replace($replace, '', $image_64); 
    
        $image = str_replace(' ', '+', $image); 
    
        $imageName = Str::random(10).'.'.$extension;
    
        // $value->move(public_path('images/'),$imageName.base64_decode($image));
        Storage::disk('public')->put($imageName, base64_decode($image));
    
        $committee->picture = $imageName;
        $committee->save();

        $result = ApiHelper::success('New member added Successfully', $committee);
        return response()->json($result, 200);
    }

    public function getCommitteeMembers(){
        $committee= Committee::all();
        $result = ApiHelper::success('Gallery Loaded Successfully', $committee);
        return response()->json($result, 200);
    }

    public function deleteCommitteeMember(Request $request){
        $member = Committee::where('id',$request->id)->delete();

        $result = ApiHelper::success('Member deleted Successfully', $member);
        return response()->json($result, 200);
    }
}
