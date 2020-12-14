<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class Carrier extends Controller
{
    //

    public function addCarriers(Request $request ){
        // dd($request['data']);

        $table="<h5 style='color:red;text-align:center;'>Error Table</h5>";
        $table.="<button onclick='export_error()' class='btn btn-primary btn-danger btn-sm' style='float:right'>Export</button>";
        $table.="<table class='table' id='op_error_table'>";
        $table.="<tr>";
        $table.="<td>Code</td>";
        $table.="<td>Name</td>";
        $table.="<td>Website</td>";
        $table.="<td>Email</td>";
        $table.="<td>Phone No</td>";
        $table.="<td>Carrier Type</td>";
        $table.="<td>Error</td>";
        $table.="</tr>";
        $main_error_flag=false;
        $temp_error_flag=false;
        // foreach(json_decode($request['data'],true) as $d){
        //     print_r($d['carrierCode']);
        // }
        // return;
        foreach(json_decode($request['data'],true) as $d){
            // dd($d["carrierName"]);
            $carrier_code="";
            $carrier_name="";
            $website="";
            $carrierType="";
            $email="";
            $phone="";
            $error="";
            // set_error_handler('my_error_handler');

            if(isset($d['carrierCode'])==1){
                if(is_numeric(@$d['carrierCode'])!=1){
                    $carrier_code=@$d['carrierCode'];
                    $temp_error_flag=true;
                    $error.="Carrier Code Error.";
                }
            }else{
                $temp_error_flag=true;
                $error.="Carrier Code Error.";

            }

            if(isset($d['carrierName'])==1){

            }else{
                $temp_error_flag=true;
                $error.="Carrier name Error.";
            }

            if(isset($d['carrierWebsite'])==1){
                // if (filter_var($d['carrierWebsite'], FILTER_VALIDATE_URL)) {
                //     // echo("$url is a valid URL");
                // } else {
                //     // echo("$url is not a valid URL");
                //     $temp_error_flag=true;
                //     $error.="Carrier website Error.";
                // }

            }

            if(isset($d['carrier_type'])!=1){

                $temp_error_flag=true;
                $error.="Carrier type Error.";
            }


            if(isset($d['carrierEmail'])==1){
                if (filter_var($d['carrierEmail'], FILTER_VALIDATE_EMAIL)) {
                    // echo("$url is a valid URL");
                } else {
                    // echo("$url is not a valid URL");
                    $temp_error_flag=true;
                    $error.="Carrier email Error.";
                }

            }

            $carrier_code=@$d['carrierCode'];
            $carrier_name=@$d['carrierName'];
            $website=@$d['carrierWebsite'];
            $email=@$d['carrierEmail'];
            $phone=@$d['carrierContactNo'];
            $carrierType=@$d['carrier_type'];


            // if($temp_error_flag==true){
            //     $main_error_flag=true;
            //     $table.="<tr>";
            //         $table.="<td>".$carrier_code."</td>";
            //         $table.="<td>".$carrier_name."</td>";
            //         $table.="<td>".$website."</td>";
            //         $table.="<td>".$email."</td>";
            //         $table.="<td>".$phone."</td>";
            //         $table.="<td  style='color:red;'>".$error."</td>";
            //     $table.="</tr>";
            // }
            if($temp_error_flag==true){
                $main_error_flag=true;
                $table.="<tr>";
                    $table.="<td>".$carrier_code."</td>";
                    $table.="<td>".$carrier_name."</td>";
                    $table.="<td>".$website."</td>";
                    $table.="<td>".$email."</td>";
                    $table.="<td>".$phone."</td>";
                    $table.="<td>".$carrierType."</td>";
                    $table.="<td  style='color:red;'>".$error."</td>";
                $table.="</tr>";

            }else{
                if(DB::table('carrier_new')->insert($d)==1){
                    // return response()->json(['success' => 'true']);
                }else{
                    $table.="<tr>";
                    $table.="<td>".$carrier_code."</td>";
                    $table.="<td>".$carrier_name."</td>";
                    $table.="<td>".$website."</td>";
                    $table.="<td>".$email."</td>";
                    $table.="<td>".$phone."</td>";
                    $table.="<td>".$carrierType."</td>";
                    $table.="<td  style='color:red;'>".$error."</td>";
                $table.="</tr>";

                }

            }

            $temp_error_flag=false;

        }
        $table.="</table>";
        $request['data']=json_decode($request['data'],true);
        //foreach($request['data'] as $d){
            //print_r($d);


            // echo $request['data'];
            // return;


        //}
        if($main_error_flag==true){
            return response()->json(['success' => 'false',"table"=>$table]);
        }else{
            return response()->json(['success' => 'true']);
        }
        // <button type="button" class="btn btn-primary btn-lg" data-toggle="modal"  data-target="#modelId">
    }


    public function getCarrierDetails(Request $request){
        // return $users->items(20);

        $carrierCode=$request['carrier_code'];
        $carrerName=$request['carrier_name'];
        $carrierWebsite=$request['carrier_website'];

        $data = DB::select("select * from carrier_new where carrierCode='".$carrierCode."' or carrierName='".$carrerName."' or carrierWebsite='".$carrierWebsite."'");
        // $data = DB::select("select * from carrier where carrierCode='".$carrierCode."'");
        // echo "select * from carrier carrierCode='".$carrierCode."'";

        $table="<table id='agent_list' style='width:100%' class='table' >";
        //$body.="<tr>";
        $table.="<tr style='font-weight:bold;'>";
        $table.="<td>Code</td>";
        $table.="<td>Name</td>";
        $table.="<td>Website</td>";
        $table.="<td>Contact No</td>";
        $table.="<td>Email</td>";
        $table.="<td></td>";

        $table.="</tr>";

        foreach($data as $d){
            // print_r($d);
            $table.="<tr>";
                $table.="<td>";
                $table.=$d->carrierCode;
                $table.="</td>";

                $table.="<td>";
                $table.=$d->carrierName;
                $table.="</td>";

                $table.="<td>";
                $table.=$d->carrierWebsite;
                $table.="</td>";

                $table.="<td>";
                $table.=$d->carrierContactNo;
                $table.="</td>";

                $table.="<td>";
                $table.=$d->carrierEmail;
                $table.="</td>";


                $table.="<td>";
                    $table.='<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" value="'.$d->id.'" onclick="editCarrier(this)" data-target="#modelId">Edit</button>';
                    $table.=' <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" value="'.$d->id.'" onclick="delCarrier(this)" >Del</button>';
                $table.="</td>";


            $table.="</tr>";

        }

        $table.="</table>";

        return $table;
    }


    public function exportAllCarrier(Request $request){

        $data = DB::select("select * from carrier_new");
        // $data = DB::select("select * from carrier where carrierCode='".$carrierCode."'");
        // echo "select * from carrier carrierCode='".$carrierCode."'";

        $table="<table id='agent_list_expo' style='width:100%;display:none;' class='table' >";
        //$body.="<tr>";
        $table.="<tr style='font-weight:bold;'>";
        $table.="<td>carrierCode</td>";
        $table.="<td>carrierName</td>";
        $table.="<td>carrierWebsite</td>";
        $table.="<td>carrierContactNo</td>";
        $table.="<td>carrierEmail</td>";
        $table.="<td>carrier_type</td>";
        $table.="</tr>";

        foreach($data as $d){
            // print_r($d);
            $table.="<tr>";
                $table.="<td>";
                $table.=$d->carrierCode;
                $table.="</td>";

                $table.="<td>";
                $table.=$d->carrierName;
                $table.="</td>";

                $table.="<td>";
                $table.=$d->carrierWebsite;
                $table.="</td>";

                $table.="<td>";
                $table.=$d->carrierContactNo;
                $table.="</td>";

                $table.="<td>";
                $table.=$d->carrierEmail;
                $table.="</td>";

                $table.="<td>";
                $table.=$d->carrier_type;
                $table.="</td>";
            $table.="</tr>";

        }

        $table.="</table>";

       return $table;


    }

    public function getCarrier(Request $request){
        $data = DB::select("select * from carrier_new where id='".$request['id']."'");
        foreach($data as $d){
            return response()->json(['carrier_code' => $d->carrierCode,'carrier_name' => $d->carrierName,'carrier_website' => $d->carrierWebsite,"carrier_contact"=>$d->carrierContactNo,"carrier_email"=>$d->carrierEmail,"carrier_type"=>$d->carrier_type]);

        }
    }


    public function getCarrierWithCarrierCode(Request $request){
        $data = DB::select("select * from carrier_new where carrierCode='".$request['id']."'");
        foreach($data as $d){
            return response()->json(['carrier_code' => $d->carrierCode,'carrier_name' => $d->carrierName,'carrier_website' => $d->carrierWebsite,"carrier_contact"=>$d->carrierContactNo,"carrier_email"=>$d->carrierEmail,"carrier_type"=>$d->carrier_type]);

        }
    }

    public function delectCarrier(Request $request){
        $data = DB::select("delete from carrier_new where id='".$request['id']."'");


    }
    public function updateCarrier(Request $request){
    // dd($_POST);
        $carrier_name=@$request['carrier_name'];
        $carrier_website=@$request['carrier_website'];
        $carrier_email=@$request['carrier_email'];
        $carrier_contact=@$request['carrier_contact'];
        $carrier_type=@$request['carrier_type'];
        // echo "asdf";
        $error=["","",""];
        $temp_error_flag=false;


        if(isset($carrier_name)==1){

        }else{
            $temp_error_flag=true;
            $error[0]="Carrier name Error.";
        }

        if(isset($carrier_website)==1){
            if (filter_var($carrier_website, FILTER_VALIDATE_URL)) {
                // echo("$url is a valid URL");
            } else {
                // echo("$url is not a valid URL")
                $error[1]="Carrier website Error.";
                $temp_error_flag=true;
            }
        }


        if(isset($carrier_email)==1){
            if (filter_var($carrier_email, FILTER_VALIDATE_EMAIL)) {
                // echo("$url is a valid URL");
            } else {
                // echo("$url is not a valid URL")
                $error[2]="Carrier emal Error.";
                $temp_error_flag=true;
            }
        }

        if($temp_error_flag==true){
            return response()->json(['success' => 'false',"error"=>json_encode($error,true)]);
        }else{
            $up_record= DB::update("update carrier_new set carrierName=?,carrierWebsite=?,carrierEmail=?,carrierContactNo=?,carrier_type=? where carrierCode=?",[$carrier_name,$carrier_website,$carrier_email,$carrier_contact,$carrier_type,$request['carrier_code']]);
            // if($up_record>0){
                return response()->json(['success' => 'true']);
            // }
        }



        // foreach($data as $d){
        //     return response()->json(['carrier_code' => $d->carrierCode,'carrier_name' => $d->carrierName,'carrier_website' => $d->carrierWebsite]);
        // }

    }



    public function paginate(Request $request){

        // dd($_POST);
        $users = DB::table('carrier_new')->paginate(10);

        return view('paginate', ['users' => $users]);
            // foreach($data as $d){
            //     return response()->json(['carrier_code' => $d->carrierCode,'carrier_name' => $d->carrierName,'carrier_website' => $d->carrierWebsite]);
            // }

        }

        public function addSingleCarrier(Request $request){
        // dd(array(
        //     "carrierCode"=> $request['carrier_code'],
        //     "carrierName"=>$request['carrier_name'],
        //     "carrierWebsite"=>$request['carrier_website'],
        //     "carrierContactNo"=>$request['carrier_contact'],
        //     "carrierEmail"=>$request['carrier_email'],
        //     "carrier_type"=>$request['carrier_type']
        // ));
            DB::table('carrier_new')->insert(array(
                "carrierCode"=> $request['carrier_code'],
                "carrierName"=>$request['carrier_name'],
                "carrierWebsite"=>$request['carrier_website'],
                "carrierContactNo"=>$request['carrier_contact'],
                "carrierEmail"=>$request['carrier_email'],
                "carrier_type"=>$request['carrier_type']
            ));
            return response()->json(['success' => 'true']);
        }

        public function  dropCarrier(Request $request){
            DB::table('carrier_new')->truncate();
            return response()->json(['success' => 'true']);
        }


}
