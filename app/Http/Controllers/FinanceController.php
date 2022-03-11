<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Finance;
use App\Helper\ApiHelper;
use Carbon\Carbon;

class FinanceController extends Controller
{
    public function getFinanceDetails(Request $request){
        $finance = Finance::where('file_no',$request->volume_no)->get();
        
        $result = ApiHelper::success('Finance details loaded Successfully', $finance);
        return response()->json($result, 200);
    }

    public function update(Request $request){
        $ledger = Finance::where('id',$request->id);
        if(isset($request->Amount)){
            $ledger->update(["Amount" => $request->Amount]);
        }if(isset($request->Description)){
            $ledger->update(["Description" => $request->Description]);
        }if(isset($request->Receipt)){
            $ledger->update(["Receipt" => $request->Receipt]);
        }if(isset($request->file_no)){
            $ledger->update(["file_no" => $request->file_no]);
        }if(isset($request->member_no)){
            $ledger->update(["member_no" => $request->member_no]);
        }
        $result = ApiHelper::success('Details updated Successfully', $ledger);
        return response()->json($result, 200);
    }

    public function getLedgerDetails(Request $request){
        $ledger = Finance::where('id',$request->id)->get();
        
        $result = ApiHelper::success('Finance details loaded Successfully', $ledger);
        return response()->json($result, 200);
    }

    public function store(Request $request){
        foreach ($request->descriptionArray as $key => $value) {
            $ledger = new Finance();
            $ledger->plot_no = $request->plot_no;
            $ledger->file_no = $request->file_no;
            $ledger->member_no = $request->member_no;
            $ledger->Date = Carbon::parse($request->Date);
            $ledger->Description = $value['description'];
            $ledger->Amount = $value['amount'];
            $ledger->Receipt = $request->Receipt;
            $ledger->save();
        }
        $result = ApiHelper::success('Finance details saved Successfully', $ledger);
        return response()->json($result, 200);
    }
}
