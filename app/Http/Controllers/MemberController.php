<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plot;
use App\Models\Member;
use App\Models\Finance;
use App\Helper\ApiHelper;

class MemberController extends Controller
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
        $plot = new Plot();
        $member = new Member();
        $ledger = new Finance();
        
        $plot->plot_no = $request->plot_no;
        $plot->member_no = isset($request->member_no) ? $request->member_no : null;
        $plot->file_no = isset($request->file_number) ? $request->file_number : null;
        // $plot->owner_no = $plotDetails->owner_no + 1;

        $member->member_no = isset($request->member_no) ? $request->member_no : null;
        $member->name = isset($request->name) ? $request->name : null;
        $member->relation = isset($request->relation) ? $request->relation : null;
        $member->address = isset($request->address)? $request->address : null;
        $member->cell = isset($request->cell) ? $request->cell : null;
        $member->phone = isset($request->phone) ? $request->phone : null;
        $member->email = isset($request->email) ? $request->email : null;

        $ledger->plot_no = $request->plot_no;
        $ledger->member_no = isset($request->member_no) ? $request->member_no : null;
        $ledger->file_no = isset($request->file_number) ? $request->file_number : null;
        $ledger->Date = isset($request->Date) ? $request->Date : null;
        $ledger->Description = isset($request->Description) ? $request->Description : null;
        $ledger->Amount = isset($request->Amount) ? $request->Amount : null;
        $ledger->Receipt = isset($request->Receipt) ? $request->Receipt : null;

        $plot->save();
        $member->save();
        $ledger->save();

        $result = ApiHelper::success('New member added Successfully', $plot);
        return response()->json($result, 200);
    }

    public function searchMemberNumber(Request $request){
        if (Member::where('member_no', $request->member_no)->exists()) {
            $result = ApiHelper::successMessage('Member number already exists');
            return response()->json($result, 201);
        }else{
            $result = ApiHelper::successMessage('No member number');
            return response()->json($result, 200);
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $member = Member::where('member_no',$request->member_no);
        if(isset($request->name)){
            $member->update(["name" => $request->name]);
        }if(isset($request->address)){
            $member->update(["address" => $request->address]);
        }if(isset($request->member_no)){
            $member->update(["member_no" => $request->member_no]);
        }if(isset($request->cell)){
            $member->update(["cell" => $request->cell]);
        }if(isset($request->phone)){
            $member->update(["phone" => $request->phone]);
        }if(isset($request->email)){
            $member->update(["email" => $request->email]);
        }if(isset($request->plot_no)){
            $member->update(["plot_no" => $request->plot_no]);
        }
        $result = ApiHelper::success('Member updated Successfully', $member);
        return response()->json($result, 200);
    }

    public function getMemberDetails(Request $request){
        $plots= Plot::join('member_table','plot_table.member_no','=','member_table.member_no')
        ->where('plot_table.member_no',$request->member_no)
        ->get();
        $result = ApiHelper::success('Member Loaded Successfully', $plots);
        return response()->json($result, 200);
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
}
