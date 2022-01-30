<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Finance;
use App\Helper\ApiHelper;

class FinanceController extends Controller
{
    public function getFinanceDetails(Request $request){
        $finance = Finance::where('file_no',$request->volume_no)->get();
        
        $result = ApiHelper::success('Finance details loaded Successfully', $finance);
        return response()->json($result, 200);
    }
}
