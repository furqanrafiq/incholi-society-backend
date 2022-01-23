<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plot;
use App\Models\Member;
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
        
        $plot->plot_no = $request->plot_no;
        $plot->member_no = isset($request->member_no) ? $request->member_no : null;
        $plot->file_no = isset($request->file_no) ? $request->file_no : null;
        // $plot->owner_no = $plotDetails->owner_no + 1;

        $member->member_no = isset($request->member_no) ? $request->member_no : null;
        $member->name = isset($request->name) ? $request->name : null;
        $member->relation = isset($request->relation) ? $request->relation : null;
        $member->address = isset($request->address)? $request->address : null;
        // $member->cell = isset($request->cell) ? $request->cell : null;
        // $member->phone = isset($request->phone) ? $request->phone : null;
        // $member->email = isset($request->email) ? $request->email : null;

        $plot->save();
        $member->save();

        $result = ApiHelper::success('New member added Successfully', $plot);
        return response()->json($result, 200);
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
