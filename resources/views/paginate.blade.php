@extends('layouts.app')

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/xlsx.full.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/jszip.js"></script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><b>Log Data</b>
                    <img src="{{ asset('img/loading.gif') }}" style="display:none;float:right;" height="30px" id="success-loader"/> </span>
                    <span  style="float:right"><button id="btnExport" class="btn" style="background: orange;color:white;font-size:14px;"><img src="{{asset('img/export_to_excel.jpg')}}" height="25px;" /> Export All</button>
                    </div>

                <div class="card-body">


                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="container">
                        {{ $users->links() }}

                        <table class="table">
                            <tr>
                                <th>#Id</th>
                                <th>Email</th>
                                <th>status</th>
                            </tr>

                    @foreach ($users as $user)
                        <tr>
                            <td>
                                {{ $user->id }}
                            </td>

                            <td>
                                {{ $user->email }}
                            </td>

                            <td>
                                {{ $user->status_changed }}
                            </td>
                        </tr>
                        @endforeach
                        </table>
                    </div>

                <div style="float: right;">  {{ $users->links() }}   </div>

                {{-- {{$users->nextPageUrl()}} --}}
<!--                    <h5>Search Carrier</h5>

                        <table style="text-align: center;width:100%;border:1px;">
                            <tr>
                                <td>Carrier Code</td>
                                <td>Carrier Name</td>
                                <td>Carrier Website</td>
                                <td></td>
                            </tr>
                            <tr>

                                <td><input type="text" placeholder="carrier code"  id="carrier_code" /></td>
                                <td><input type="text" placeholder="carrier name"   id="carrier_name" /></td>
                                <td><input type="text" placeholder="carrier website"  id="website" /></td>
                                <td><input type="button" id="search" class="btn btn-primary btn-sm" value="search" onclick="updateCarrier()"/></td>
                            </tr>
                        </table>
                    </br>
                    <div id="edit-carrier">



                    </div>



                -->








                        <!-- Button trigger modal -->


                        <!-- Modal -->
                        <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Update Carrier</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="email">Carrier Code</label>
                                            <input type="text" class="form-control" id="up_carrier_code" readonly>
                                            <input type="hidden" class="form-control" id="up_id">
                                        </div>

                                        <div class="form-group">
                                            <label for="email">Carrier Name</label>
                                            <input type="text" class="form-control" id="up_carrier_name">

                                        </div>

                                        <div class="form-group">
                                            <label for="email">Carrier Website </label>
                                            <input type="text" class="form-control" id="up_carrier_website">
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Carrier Email </label>
                                            <input type="text" class="form-control" id="up_carrier_email">
                                        </div>

                                        <div class="form-group">
                                            <label for="email">Carrier Contact </label>
                                            <input type="text" class="form-control" id="up_carrier_contact">
                                        </div>

                                        <div class="form-group">
                                            <label for="email">Carrier Contact </label>
                                            <select  class="form-control" id="up_carrier_type">
                                                <option value="prepaid">Prepared</option>
                                                <option value="collect">Collect</option>
                                            </select>
                                        </div>


                                        <div class="error-block">
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" onclick="supdateRcord()">Save</button>

                                        <h6 style="color:green" class="success-msg" style="display:none;">Record updated.</h6>
                                        <h6 style="color:red" class="error-msg" style="display:none;">Error message.</h6>
                                    </div>

                                </div>
                            </div>
                        </div>



                </div>



            </div>

        </div>
    </div>
</div>

<div id="export_excel">

</div>



<script type="text/javascript">


function update_single_carrier(){
    $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

            $.ajax({
                    type:'post',
                    url:'{{route("user.getCarrierWithCarrierCode")}}',
                    data:{
                        id:$("#search_value").val()
                    },
                    success:function(data,status) {
                        // console.log(data);
                        $("#up_id").val(data['id']);
                        $("#up_carrier_name").val(data['carrier_name']);
                        $("#up_carrier_code").val(data['carrier_code']);
                        $("#up_carrier_website").val(data['carrier_website']);
                        $("#up_carrier_email").val(data['carrier_email']);
                        $("#up_carrier_contact").val(data['carrier_contact']);
                    }
        });
}

    function paginate(){
        $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                        type:'get',
                        url:'{{route("user.paginate")}}',
                        success:function(data,status) {
                            console.log(data);
                            $("#export_excel").html(data);
                        }
                });

    }

    $(function () {

                $("#btnExport").click(function () {
                    $("#btnExport").prop("disabled",true);
                    $("#success-loader").show();
                    $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                        type:'post',
                        url:'{{route("user.exportAllCarrier")}}',
                        success:function(data,status) {
                            // console.log(data);
                            $("#export_excel").html(data);
                            // $("#success-loader").hide();
                            // $("#success-message").show();
                            $("#agent_list_expo").table2excel({
                                    filename: "Carrier_Info.xls"
                            });
                            $("#btnExport").prop("disabled",false);
                            $("#success-loader").hide();
                        }
                });

            });
        });


        $("body").on("click", "#upload", function () {
            //Reference the FileUpload element.
            var fileUpload = $("#fileUpload")[0];

            //Validate whether File is valid Excel file.
            var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.xls|.xlsx)$/;
            if (regex.test(fileUpload.value.toLowerCase())) {
                if (typeof (FileReader) != "undefined") {
                    var reader = new FileReader();

                    //For Browsers other than IE.
                    if (reader.readAsBinaryString) {
                        reader.onload = function (e) {
                            ProcessExcel(e.target.result);
                        };
                        reader.readAsBinaryString(fileUpload.files[0]);
                    } else {
                        //For IE Browser.
                        reader.onload = function (e) {
                            var data = "";
                            var bytes = new Uint8Array(e.target.result);
                            for (var i = 0; i < bytes.byteLength; i++) {
                                data += String.fromCharCode(bytes[i]);
                            }
                            ProcessExcel(data);
                        };
                        reader.readAsArrayBuffer(fileUpload.files[0]);
                    }
                } else {
                    alert("This browser does not support HTML5.");
                }
            } else {
                alert("Please upload a valid Excel file.");
            }
        });
        function ProcessExcel(data) {
            //Read the Excel File data.
            var workbook = XLSX.read(data, {
                type: 'binary'
            });

            //Fetch the name of First Sheet.
            var firstSheet = workbook.SheetNames[0];

            //Read all rows from First Sheet into an JSON array.
            var excelRows = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[firstSheet]);
            // console.log(excelRows);
            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });


            // console.log( JSON.stringify(excelRows));
            $("#success-loader").show();
           $.ajax({
                    type:'post',
                    url:'{{route("user.addcarriers")}}',
                    data:{
                        data:JSON.stringify(excelRows)
                        // country:selectedCountry
                    },
                    success:function(data,status) {
                        $("#success-loader").hide();
                        $("#success-message").show();
                    }
           });
        };




    function updateCarrier(){
        $(".success-msg").hide();
        $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });


            // console.log( JSON.stringify(excelRows));
            // $("#success-loader").show();
            // console.log($("#carrier_code").val());
            $.ajax({
                    type:'post',
                    url:'{{route("user.updatecarriers")}}',
                    data:{
                        carrier_name:$("#carrier_name").val(),
                        carrier_code:$("#carrier_code").val(),
                        carrier_website:$("#website").val()
                    },
                    success:function(data,status) {
                        // console.log(data);
                        $("#edit-carrier").html(data);
                        window.location.reload();
                        // $("#success-loader").hide();
                        // $("#success-message").show();
                    }
        });
    }


    function editCarrier(a){
        $(".success-msg").hide();
        $(".error-msg").hide();
        // console.log(a.value);
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
                        // console.log(data);
                        $("#up_id").val(data['id']);
                        $("#up_carrier_name").val(data['carrier_name']);
                        $("#up_carrier_code").val(data['carrier_code']);
                        $("#up_carrier_website").val(data['carrier_website']);
                        $("#up_carrier_email").val(data['carrier_email']);
                        $("#up_carrier_contact").val(data['carrier_contact']);
                    }
        });
    }





    function delCarrier(a){
        $(".success-msg").hide();
        // console.log(a.value);
        $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                    $.ajax({
                            type:'post',
                            url:'{{route("user.delectCarrier")}}',
                            data:{
                                id:a.value
                            },
                            success:function(data,status) {
                                // console.log(data);
                                alert("Record Deleted");
                                window.location.reload();
                                $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });


                    // console.log( JSON.stringify(excelRows));
                    // $("#success-loader").show();
                    // console.log($("#carrier_code").val());
                    $.ajax({
                            type:'post',
                            url:'{{route("user.updatecarriers")}}',
                            data:{
                                carrier_name:$("#carrier_name").val(),
                                carrier_code:$("#carrier_code").val(),
                                carrier_website:$("#website").val()
                            },
                            success:function(data,status) {
                                // console.log(data);
                                $("#edit-carrier").html(data);
                                // $("#success-loader").hide();
                                // $("#success-message").show();
                            }
                });
                        // updateCarrier();
                    }
        });
    }

    function supdateRcord(){
        $(".error-msg").hide();
        $(".success-msg").hide();
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
                        carrier_contact:$("#up_carrier_contact").val(),
                        carrier_type:$("#up_carrier_type").val()
                    },
                    success:function(data,status) {
                        console.log();

                        // updateCarrier();
                        if(data["success"]=="true"){
                            $(".success-msg").show();
                            $(".error-msg").hide();
                            window.location.reload();
                        }else{
                            //fruits.toString();
                            $(".error-msg").show();
                            $(".success-msg").hide();
                            // var arr=JSON.parse(data);

                                var arr=JSON.parse(data["error"]);
                                var msg="";
                                for(var i=0;i<arr.length;i++){
                                    // console.log();
                                    msg+="<h5 style='color:red;'>"+arr[i]+"</h5>";
                                }
                            $(".error-block").html(msg);
                        }
                    }
        });
    }



    </script>

    @endsection




























