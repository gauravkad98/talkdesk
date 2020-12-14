<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class talkdesk extends Controller
{
    //
    public function on_off(Request $request){
       // return auth()->user()->id;
        $status=$request['status'];

        $up_record= DB::update("update tbl_status set status='".$status."' where id=1");
        DB::table('tbl_log')->insert(array(
            "user_name"=> auth()->user()->id,
            "email"=>auth()->user()->email,
            "status_changed"=>$status
        ));
        return $status;

    }

    public function paginate(Request $request){
      //  $data = DB::select("select * from carrier_new where carrierCode='".$carrierCode."' or carrierName='".$carrerName."' or carrierWebsite='".$carrierWebsite."'");
        $users = DB::table('tbl_log')->paginate(10);

        return view('paginate', ['users' => $users]);
    }
}
