@extends('layouts.app')

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/xlsx.full.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/jszip.js"></script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">

                <div class="card-header"><b>Talkdesk Override Switch</b>    <span style="float: right;"><?php
                    date_default_timezone_set('US/Eastern');

					//date_default_timezone_set('Asia/Kolkata');
                    echo date_default_timezone_get();
                    $t=time();
                    echo "</br>";
					echo "Date : ".(date("Y-m-d",$t));
					echo "</br>";
					echo "Time ". date("h:i:sa");
					echo "</br>";
                    ?> </span></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if($posts[0]->status=="on")
                    @endif
                        Current Status : {{$posts[0]->status}}
                    </br>
                    <button class="btn btn-success btn-sm" id="on" onclick="updateCarrier('on')">On</button>




                        <button class="btn btn-danger btn-sm" id="off" onclick="updateCarrier('off')" >Off</button>
                        @if($posts[0]->status=="off")
                        @endif



                        <!-- Button trigger modal -->



                </div>



            </div>
        </div>
    </div>
</div>










<script type="text/javascript">





function updateCarrier(val){

    $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            console.log(val);

        var status=val;

        // console.log( JSON.stringify(excelRows));
        // $("#success-loader").show();

        $.ajax({
                type:'post',
                url:'{{route("talkdesk.on_off_status_update")}}',
                data:{
                    status:status
                },
                success:function(data,status) {
                    console.log(data);
                    if(data=="on"){
                        $("#on").hide();
                        $("#off").show();
                    }else{

                        $("#on").show();
                        $("#off").hide();

                    }
                    location.reload();
                    //$("#edit-carrier").html(data);
                    // $("#success-loader").hide();
                    // $("#success-message").show();
                }
    });
}


function editCarrier(a){
    $(".success-msg").hide();
    console.log(a.value);
    $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        $.ajax({
                type:'post',
                url:'{{route("user.getCarrier")}}',
                data:{
                    id:a.value
                },
                success:function(data,status) {
                    console.log(data);
                    $("#up_id").val(data['id']);
                    $("#up_carrier_name").val(data['carrier_name']);
                    $("#up_carrier_code").val(data['carrier_code']);
                    $("#up_carrier_website").val(data['carrier_website']);
                    $("#up_carrier_email").val(data['carrier_email']);
                    $("#up_carrier_contact").val(data['carrier_contact']);
                }
    });
}


function supdateRcord(){
    $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        $.ajax({
                type:'post',
                url:'{{route("user.updateCarrier")}}',
                data:{
                    id: $("#up_id").val(),
                    carrier_name:$("#up_carrier_name").val(),
                    carrier_code:$("#up_carrier_code").val(),
                    carrier_website:$("#up_carrier_website").val(),
                    carrier_email:$("#up_carrier_email").val(),
                    carrier_contact:$("#up_carrier_contact").val()
                },
                success:function(data,status) {
                    console.log(data);
                    updateCarrier();

                    $(".success-msg").show();
                }
    });
}

</script>

@endsection
