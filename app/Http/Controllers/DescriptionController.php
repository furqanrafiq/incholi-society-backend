<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Description;
use App\Helper\ApiHelper;

class DescriptionController extends Controller
{
    public function getAllDescriptions(){
        $descriptions = Description::all();
        $result = ApiHelper::success('Descriptions Loaded Successfully', $descriptions );
        return response()->json($result, 200);
    }
}
