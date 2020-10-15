@extends('layouts.app')

@section('content')

<h1 class="my-3 text-center">Complaints</h1>

<div class="row">
    <div class="col-md-9">
        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#create_complaint_modal">
            Create New Complaint
        </button>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <select class="form-control" id="status_change_btn">
                  <?php 
                    $all_status =['all','pending','waiting for approval', 'approved','rejected', 'completed']; 
                    $status_value = str_replace(' ', '_', $current_status); //adding underscore
                  ?>
                   <option value="{{ $status_value }}">{{ $current_status }}</option>
                   @foreach($all_status as $status)
                     @if($status != $current_status)
                       <?php $status_value = str_replace(' ', '_',$status);  ?>
                      <option value="{{ $status_value }}">{{ $status }}</option>
                   @endif
                   @endforeach
            </select>
        </div>
    </div>
</div>

<?php
 // echo '<pre>'; 
 // print_r($complaints);
 // echo '<pre>';
?>

<div class="card card-body">
   <table id="dataTable" class="display mt-2" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Customer Name</th>
                <th>Img</th>
                <th>Mobile No</th>
                <th>Date</th>
                <th>Address</th>
                <th>Status</th>
				<th>action</th>>
            </tr>
        </thead>
        <tbody>

        <?php $i = 0; ?>
        @foreach( $complaints as $complaint)
          <?php $i++; ?>
          <tr>
             <td>{{$i}}</td>
             <td>{{$complaint->customer_name }}</td>
             <td><img style="width:50px; height:50px;" src="{{ asset('storage/complaint_images/'.$complaint->img) }}" alt=""></td>
             <td>{{ $complaint->mobile_no }}</td>
             <td>{{ $complaint->date  }}</td>
             <td>{{ $complaint->address  }}</td>
             <td>{{$complaint->status  }}</td>
			  <td><a class="btn btn-info btn-sm" href="/complaint/{{$complaint->id}}/edit">view</a></td>
             
          </tr>
          @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>No</th>
                <th>Customer Name</th>
                <th>Img</th>
                <th>Mobile No</th>
                <th>Extn.</th>
                <th>Date</th>
                <th>Address</th>
				<th>action</th>
            </tr>
        </tfoot>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="create_complaint_modal" tabindex="-1" role="dialog" aria-labelledby="complaintModalLabel" aria-hidden="true">
    <!--increased width with .modal-lg -->
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="complaintModalLabel">New Complaint</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
         <form class="px-4 py-3" id="create_complaint_form" method="POST" action="complaint_controller/register_new_complaint" enctype="multipart/form-data" >
                
                 <div class="modal-body">
                     {{ csrf_field() }}
                      <div class="form-group">
                          <label>Customer Name</label>
                          <input type="text" name="name" id="name" class="form-control" placeholder="Enter Customer Name" autocomplete="off">
                          <span class="error_form" id="name_errmsg"></span>
                      </div> 
                      
                    <div class="row">
                      <div class="col-md-6 form-group">
                           <label>Mobile No</label>
                           <input type="text" name="mobile_no" id="mobile_no" class="form-control" placeholder="Enter Phone" autocomplete="off"/>
                           <span class="error_form" id="mobile_no_errmsg"></span>
                       </div>
                       <div class="offset-md-2 col-md-4 form-group">
                          <label>Date</label>
                           <input type="text" name="date" id="date" value={{date('d/m/Y')}} class="form-control" autocomplete="off" disabled>
                           <span class="error_form" id="date_errmsg"></span>
                       </div>
                    </div> 
  
                      <div class="form-group">
                          <label>Address</label>
                          <textarea type="textarea" name="address" id="address" class="form-control" placeholder="Enter Address" autocomplete="off"></textarea>
                          <span class="error_form" id="address_errmsg"></span>
                      </div> 
                      <div class="form-group">
                          <label>Item Name</label>
                          <input type="text" name="item_name" id="item_name" class="form-control" placeholder="Enter Item Name" autocomplete="off">
                          <span class="error_form" id="item_name_errmsg"></span>
                      </div>
                      <div class="row">
                            <div class="col-md-6 form-group"> 
                                <label>Choose Image</label>
                                <input type="file" class="form-control" name="userfile" id="img" size="20">
                                <span class="error_form" id="img_errmsg"></span>
                            </div> 
                            <div class="offset-md-2 col-md-4 form-group">
                                <label> </label>
                                <img src="" alt="" id="img_tag" width="100px; height:100px;">
                            </div>
                       </div> 
                      <div class="form-group">
                          <label>Complaint</label>
                          <textarea type="textarea" name="complaint" id="complaint" class="form-control" placeholder="Enter Complaint" autocomplete="off"></textarea>
                          <span class="error_form" id="complaint_errmsg"></span>
                      </div> 
                      
                      <div class="form-group">
                          <label>Barcode (If Available)</label>
                          <input type="text" name="barcode" id="barcode" class="form-control" placeholder="Enter Barcode" autocomplete="off">
                          <span class="error_form" id="barcode_errmsg"></span>
                      </div>  
                   </div> 
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="submit" id="create_complaint_modal_btn" class="btn btn-success">Save</button>
                  </div>
              </form>
          </div>
      </div>
      </div>



 @include('inc.footer') 

<script type="text/javascript" src="{{ URL::to('src/daterangepicker-master/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('src/daterangepicker-master/daterangepicker.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('src/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>

<script>
$(document).ready(function() { // to load after everything else has loaded
    $('#dataTable').DataTable({  });
 });
</script>

<script>

    $('#status_change_btn').on('change', function() {
       var status_value = $(this).val();
       window.location = '/complaints/'+status_value;
   });
</script>

<script>
   
/*
$(function () {
    $('input[name="date"]').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        locale: { format: 'DD/MM/YYYY'} ,
        minYear: 1901
    }, function (start, end, label) {
    });
});

//disable operations at date field
$('#date').keydown(function(){
    return false;
});
$('#date').bind('contextmenu',function(e){
     e.preventDefault();
});
*/


var error_msg;
var error_span_id;
var error_input_field;

var error_name;
var error_mobile_no;
var error_address;
var error_item_name;
var error_complaint;
var error_img;

$('#name_errmsg').hide();
$('#mobile_no_errmsg').hide();
$('#date_errmsg').hide();
$('#address_errmsg').hide();
$('#item_name_errmsg').hide();
$('#complaint_errmsg').hide();
$('#img_errmsg').hide();


$('#name').on('input',function(){
    check_name(); 
});
$('#mobile_no').on('input',function(){
    check_mobile_no();
});
$('#address').on('input',function(){
    check_address(); 
});
$('#item_name').on('input',function(){
    check_item_name(); 
});
$('#complaint').on('input',function(){
    check_complaint(); 
});
/*$('#img').on('input',function(){
    check_img();
});*/

$('#img').on('input',function(){
      //checking if there is any error on selected img
      var img_result = check_img();
      var img_tag = '#img_tag';
      if(img_result == false){//means no error, set img
            //set image
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function imageIsLoaded(e) {
                                  $(img_tag).attr('src', e.target.result);
                                };
                reader.readAsDataURL(this.files[0]);
            }
      }
      else{
        $(img_tag).attr('src', '');
      }

      //hide_error('#img_errmsg', '#img');
        
    });

function check_name(){
    var name = $('#name').val();
  
    if(name != '' ){
        hide_error('#name_errmsg', '#name');
        error_name = false;
    }
    else{
        display_error_msg('Invalid name', '#name_errmsg', '#name');
        error_name = true; 
    }
}

 function check_mobile_no(){
        var mobile_no = $('#mobile_no').val();
        var mobile_no_length = $('#mobile_no').val().length;
        var pattern = new RegExp("^([0-9]+)$");

        if(pattern.test(mobile_no) && mobile_no_length == 10){
            hide_error('#mobile_no_errmsg', '#mobile_no');
            error_mobile_no = false;
        }
        else if(!pattern.test(mobile_no)){
            display_error_msg('Invalid mobile no', '#mobile_no_errmsg', '#mobile_no');
            error_mobile_no = true;
        }
        else if(mobile_no_length < 10){
            display_error_msg('10 digits required', '#mobile_no_errmsg', '#mobile_no');
            error_mobile_no = true;
        }
        else if(mobile_no_length > 10){
           display_error_msg('Typed More than 10 digits', '#mobile_no_errmsg', '#mobile_no');
           error_mobile_no = true;
        }

    }


    function check_address(){
        var address = $('#address').val();
        var address_length = $('#address').val().length;
  
        if(address != '' && address_length < 255 ){
            hide_error('#address_errmsg', '#address');
            error_address = false;
        }
        else if(address_length >= 255){
            display_error_msg('Too much characters', '#address_errmsg', '#address');
            error_address = true;  
        }
        else{
            display_error_msg('Invalid address', '#address_errmsg', '#address');
            error_address = true;
        }

     }
    
    
    function check_item_name(){
            var item_name = $('#item_name').val();
      
            if(item_name !='' ){
                hide_error('#item_name_errmsg', '#item_name');
                error_item_name = false;  
            }
            else {
                display_error_msg('Invalid Item name', '#item_name_errmsg', '#item_name');
                error_item_name = true; 
            }
    }

    function check_complaint(){
        var complaint = $('#complaint').val();
    
        if(complaint != ''){
            hide_error('#complaint_errmsg', '#complaint');
            error_complaint = false;   
        }
        else{
            display_error_msg('Invalid complaint', '#complaint_errmsg', '#complaint');
            error_complaint = true; 
        }
    }


    function check_img(){
        /* var img_name = $('#img').val();
            var extension = $('#img').val().split('.').pop().toLowerCase();  */

        var img_value  = $('#img').val();

        if(img_value != ''){
            // var img  = $('#img')[0].files[0];
            // console.log(img);
                var img_name  = $('#img')[0].files[0].name;
                var extension = img_name.substr((img_name.lastIndexOf('.') + 1)).toLowerCase();

                if(img_name != '' && extension != ''){  

                        if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1){   
                            display_error_msg('file format not supported', '#img_errmsg' , '#img' );
                            error_img = true;
                            // $('#img').val('');    
                        }
                        else{
                            var imgSize = $('#img')[0].files[0].size;
                            var  sizeInKB = imgSize/1024;
                        
                            if(sizeInKB > 2048){
                                display_error_msg('file size should be less than 1 MB', '#img_errmsg' , '#img' );
                                error_img = true;
                            }
                            else{
                                hide_error('#img_errmsg', '#img');
                                error_img = false; 
                            }  
                        }  

                }
                else if(img_name != '' &&  extension == ''){
                    display_error_msg('please provide extension', '#img_errmsg' , '#img' );
                    error_img = true;
                }
                else if(img_name == ''){
                    display_error_msg('please select an image', '#img_errmsg' , '#img' );
                    error_img = true;
                }  
                
        }
        else{
            display_error_msg('please select an image', '#img_errmsg' , '#img' );
            error_img = true;
        }

        return error_img;
    }



//FOR CREATING COMPLAINT

$('#create_complaint_modal_btn').click(function(e){
    e.preventDefault();
    e.stopPropagation();

    $.ajaxSetup({
        headers: {
            //'X-CSRF-TOKEN': $('input[name="_token"]').val() /*this works*/
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

   // console.log( $('input[name="_token"]').val());

    error_name         = true;
    error_mobile_no    = true;
    error_address      = true;
    error_item_name    = true;
    error_complaint    = true;
    error_img          = true;
    
    check_name();
    check_mobile_no();
    check_address(); 
    check_item_name(); 
    check_complaint();
    error_img  = check_img();

    if(error_name == false && error_mobile_no == false && error_address == false && 
        error_item_name == false && error_complaint == false && error_img == false){  

        var cust_name = $('#name').val();
        var mobile_no = $('#mobile_no').val();
        var date = $('#date').val();
        var address = $('#address').val();
        var itemname = $('#item_name').val();
        var complaint = $('#complaint').val();
        var barcode = $('#barcode').val();


       // var fd = new FormData("#create_complaint_form");
        
        var fd = new FormData();
        var img  = $('#img')[0].files[0];
        fd.append('complaint_img', img);
        fd.append('name', cust_name);
        fd.append('mobile_no', mobile_no);
        fd.append('date', date);
        fd.append('address', address);
        fd.append('item_name', itemname);
        fd.append('complaint', complaint);
        fd.append('barcode', barcode);

        
        $.ajax({
            url:'/complaint/create',
            method:'POST',
            data: fd,
            contentType: false,
            cache: false,
            processData:false,
            dataType:'JSON',
            beforeSend: function() {
                $('#create_complaint_modal_btn').prop('disabled', true);
            },
            success: function(result){
                console.log(result);

                if(result.status == true){
                    //to redirect to complaint section
                    window.location = '/complaints';
                }
                $('#create_complaint_modal_btn').prop('disabled', false);
            },
            error:function(result){
                console.log(result);
                console.log(result.responseText);
                $('#create_complaint_modal_btn').prop('disabled', false);
                alert('could not get data from database');
            }

        });  
    }
});



$('#create_complaint_modal').on('hidden.bs.modal', function(){
    $('#create_complaint_form')[0].reset();

    hide_error('#name_errmsg', '#name');
    hide_error('#mobile_no_errmsg', '#mobile_no');
    hide_error('#address_errmsg', '#address');
    hide_error('#item_name_errmsg', '#item_name');
    hide_error('#complaint_errmsg', '#complaint');
    hide_error('#img_errmsg', '#img');
    $('#img_tag').attr('src', '');
});


function hide_error(error_span_id, error_input_field){
    $(error_span_id).hide();
    $(error_input_field).css("border", "1px solid #ced4da");
}

function display_error_msg(error_msg, error_span_id, error_input_field){
    $(error_span_id).html(error_msg);
    $(error_span_id).show();
    $(error_span_id).css("color", "#F90A0A");
    $(error_input_field).css("border", "2px solid #F90A0A");
}
</script>

@endsection