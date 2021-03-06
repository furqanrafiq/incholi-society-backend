<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plot;
use App\Models\Finance;
use App\Models\Member;
use App\Helper\ApiHelper;
use Carbon\Carbon;
use Validator;

class PlotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getAllPlots(){
        $plots= Plot::join('member_table','plot_table.member_no','=','member_table.member_no')
        ->where('owner_no','!=' , 'NPH')
        ->get();
        $result = ApiHelper::success('Plots Loaded Successfully', $plots);
        return response()->json($result, 200);
    }

    public function getAllNphHolders(){
        $plots= Plot::join('member_table','plot_table.member_no','=','member_table.member_no')
        // ->where('owner_no','==' ,'NPH')
        ->where('owner_no', 'like', '%' . 'NPH' . '%')
        ->get();
        $result = ApiHelper::success('Plots Loaded Successfully', $plots);
        return response()->json($result, 200);
    }

    public function getByPlotNo(Request $request){
        $plots= Plot::join('member_table','plot_table.member_no','=','member_table.member_no')
        ->where('plot_table.plot_no',$request->plot_no)
        ->orderBy('owner_no','desc')
        ->get();
        $result = ApiHelper::success('Plots Loaded Successfully', $plots);
        return response()->json($result, 200);
    }

    public function getByFileNo(Request $request){
        $plots= Plot::join('member_table','plot_table.member_no','=','member_table.member_no')
        ->where('plot_table.file_no',$request->file_no)
        ->orderBy('owner_no','desc')
        ->get();
        $result = ApiHelper::success('Plots Loaded Successfully', $plots);
        return response()->json($result, 200);
    }

    public function getByMemberNo(Request $request){
        $plots= Plot::join('member_table','plot_table.member_no','=','member_table.member_no')
        ->where('plot_table.member_no',$request->member_no)
        ->orderBy('owner_no','desc')
        ->get();
        $result = ApiHelper::success('Plots Loaded Successfully', $plots);
        return response()->json($result, 200);
    }
    
    public function getByMemberName(Request $request){
        $plots= Member::join('plot_table','member_table.member_no','=','plot_table.member_no')
        // where('name','LIKE','%'.$term.'%')
        ->where('name', 'LIKE', '%'.$request->name.'%')
        ->orderBy('owner_no','desc')
        ->get();
        $result = ApiHelper::success('Plots Loaded Successfully', $plots);
        return response()->json($result, 200);
    }

    public function addNewPlotMember(Request $request){
        // $validator = Validator::make($request->all(), [
        //     'member_no' => ['required', 'email', 'unique:plot_table'],
        // ]);
        // if ($validator->fails()) {
        //     $result = ApiHelper::validation_error('Membership number already exist', $validator->errors()->all());
        //     return response()->json($result, 422);
        // }
        $plotDetails = Plot::where('plot_no',$request->plot_no)->orderBy('owner_no','desc')->first();
        $plot = new Plot();
        $member = new Member();
        
        $plot->plot_no = $request->plot_no;
        $plot->member_no = isset($request->member_no) ? $request->member_no : null;
        $plot->file_no = isset($request->file_no) ? $request->file_no : null;
        $plot->owner_no = $plotDetails->owner_no + 1;

        $member->member_no = isset($request->member_no) ? $request->member_no : null;
        $member->name = isset($request->name) ? $request->name : null;
        $member->relation = isset($request->relation) ? $request->relation : null;
        $member->address = isset($request->address)? $request->address : null;
        $member->cell = isset($request->cell) ? $request->cell : null;
        $member->phone = isset($request->mobile) ? $request->mobile : null;
        $member->email = isset($request->email) ? $request->email : null;
        $member->cnic = isset($request->cnic) ? $request->cnic : null;

        foreach ($request->descriptionArray as $key => $value) {
            $ledger = new Finance();
            $ledger->plot_no = $request->plot_no;
            $ledger->member_no = isset($request->member_no) ? $request->member_no : null;
            $ledger->file_no = isset($request->file_no) ? $request->file_no : null;
            $ledger->Date = isset($request->Date) ? Carbon::parse($request->Date) : null;
            $ledger->Description = isset($value['description']) ? $value['description'] : null;
            $ledger->Amount = isset($value['amount']) ? $value['amount'] : null;
            $ledger->Receipt = isset($request->Receipt) ? $request->Receipt : null;
            $ledger->save();
        }

        $plot->save();
        $member->save();

        $result = ApiHelper::success('New member added Successfully', $plot);
        return response()->json($result, 200);
    }

    public function getCurrentOwner(Request $request){
        $plotDetails;
        $financeDetails;
        if(isset($request->plot_no)){
            $memberDetails = Plot::join('member_table','plot_table.member_no','=','member_table.member_no')
            ->where('plot_table.plot_no',$request->plot_no)
            ->orderBy('owner_no','desc')
            ->first();
            // return $memberDetails;
            if($memberDetails == null){
                $result = ApiHelper::success('No Plot found', $plotDetails);
                return response()->json($result, 400);
            }
            $financeDetails = Finance::where('file_no',$memberDetails->file_no)->get();
        }else{
            $memberDetails = Plot::join('member_table','plot_table.member_no','=','member_table.member_no')
            ->where('plot_table.file_no',$request->file_no)
            ->orderBy('owner_no','desc')
            ->first();
            if($memberDetails == null){
                $result = ApiHelper::success('No Plot found', $plotDetails);
                return response()->json($result, 400);
            }
            $financeDetails = Finance::where('file_no',$request->file_no)->get();
        }
        $plotDetails['financeDetails'] = $financeDetails;
        $plotDetails['memberDetails'] = $memberDetails;
        $result = ApiHelper::success('Details loaded Successfully', $plotDetails);
        return response()->json($result, 200);
    }

    public function msi(Request $request){
        if($request->has('plot_no') && $request->plot_no != ''){
            $plots = Plot::join('member_table','plot_table.member_no','=','member_table.member_no')
            ->where('plot_table.plot_no',$request->plot_no)
            ->orderBy('owner_no','desc')
            ->first();

            $financeDetails = Finance::where('plot_no',$request->plot_no)->get();
            $plots['financeDetails'] = $financeDetails;
            $result = ApiHelper::success('Details loaded Successfully', $plots);
            return response()->json($result, 200);
        }
        if($request->has('member_no') && $request->member_no != ''){
            $plots= Plot::join('member_table','plot_table.member_no','=','member_table.member_no')
            ->where('plot_table.member_no',$request->member_no)
            ->orderBy('owner_no','desc')
            ->first();

            $financeDetails = Finance::where('member_no',$request->member_no)->get();
            $plots['financeDetails'] = $financeDetails;
            $result = ApiHelper::success('Details loaded Successfully', $plots);
            return response()->json($result, 200);
        }
        if($request->has('file_no') && $request->file_no != ''){
            $plots = Plot::join('member_table','plot_table.member_no','=','member_table.member_no')
            ->where('plot_table.file_no',$request->file_no)
            ->orderBy('owner_no','desc')
            ->first();

            $financeDetails = Finance::where('file_no',$request->file_no)->get();
            $plots['financeDetails'] = $financeDetails;
            $result = ApiHelper::success('Details loaded Successfully', $plots);
            return response()->json($result, 200);
        }
        // if($request->has('plot_no') && $request->has('file_no')){
        //     $plots= Plot::join('member_table','plot_table.member_no','=','member_table.member_no')
        //     ->where('plot_table.plot_no',$request->plot_no)
        //     ->orderBy('owner_no','desc')
        //     ->get();

        //     $financeDetails = Finance::where($request->file_no)->get();
        //     $plots['financeDetails'] = $financeDetails;
        //     $result = ApiHelper::success('Details loaded Successfully', $plots);
        //     return response()->json($result, 200);              
        // }
    }

}
