@extends('layouts.app')

@section('content')

<?php $statuses = ['pending','waiting for approval','approved','rejected','completed']; ?>
<div class="container">
    <div class="status-adjust">
        <button type="button" class="btn btn-danger to-delete-button" id="delete_button" data-toggle="modal" data-target="#deleteModal">Delete Permanently</button>
       
        <div class="status-section" >
               <div class="status-label">Status :</div>
                <div class="status-change-button-container">
                    <select class="form-control" id="status_change">   
                        @foreach($statuses as $status)
                            <option value="{{$status}}">{{$status}}</option>  
                        @endforeach  
                    </select>
                </div>
        </div>
        </div>   
    
    </div>


<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel">Confirm</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body text-center">
            Are you sure you want  to permanently delete this item ?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <a class="btn btn-danger" href="{{ url('complaint/'.$complaint->id.'/delete') }}">Delete</a>
        </div>
        </div>
    </div>
</div>

<div class="container mb-3 ">
    <div class="row">


    <div class="col-md-4">
        <div class="card" style="width:100%;">
            <div class="card-header">
                Time line
            </div>
            <ul class="list-group list-group-flush" id="timeline_ul">
                <li class="list-group-item">pending :<span id="pending_id"></span></li>
                <li class="list-group-item">waiting for approvel :<span id="waiting_approval_id"></span> </li>
                <li class="list-group-item">approved :<span id="approved_id"></span> </li>
                <li class="list-group-item">rejected :<span id="rejected_id"></span> </li>
                <li class="list-group-item">completed :<span id="completed_id"></span> </li>
            </ul>
        </div>
    </div>

    <div class="col-md-8">
            <div class="px-3" style="border:1px solid rgba(0, 0, 0, 0.125); background-color:rgba(0,0,0,.03);">

            <div><h2 class="py-3 text-center">Complaint Details</h2></div>

            <form class="py-3 px-3" method="POST" action="/complaint/{{$complaint->id}}/update_complaint"  enctype="multipart/form-data" >
                {{ csrf_field() }}

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Complaint No </label>
                    <div class="col-md-2">
                        <input type="text" readonly class="form-control-plaintext" name="complaint_no" id="complaint_no" disabled="disabled"  value="{{ $complaint->id }}" >
                        <input type="hidden" id="current_status_id" value="">
                    </div>   
                </div> 
                <div class="form-group">
                    <label>Customer Name</label>
                    <input class="form-control" type="text" id="name" name="name" value="{{ $complaint->customer_name }}" autocomplete="off" >
                    <span class="error_form" id="name_errmsg"></span>
                </div> 

                <div class="row">
                    <div class="col-md-6 form-group">
                         <label>Mobile No</label>
                         <input type="text" name="mobile_no" id="mobile_no" value={{ $complaint->mobile_no }} class="form-control" placeholder="Enter Phone" autocomplete="off"/>
                         <span class="error_form" id="mobile_no_errmsg"></span>
                     </div>
                     <div class="offset-md-2 col-md-4 form-group">
                        <label>Date</label>
                         <input type="text" name="date" id="date" value={{ $complaint->date }} class="form-control" autocomplete="off">
                         <span class="error_form" id="date_errmsg"></span>
                     </div>
                  </div> 

                <div class="form-group">
                    <label>Address</label>
                    <textarea type="textarea" name="address" id="address" class="form-control" placeholder="Enter Address" autocomplete="off">{{ $complaint->address }}</textarea>
                    <span class="error_form" id="address_errmsg"></span>
                </div> 
                <div class="form-group">
                    <label>Item Name</label>
                    <input type="text" name="item_name" id="item_name" value="{{ $complaint->item_name }}" class="form-control" autocomplete="off">
                    <span class="error_form" id="item_name_errmsg"></span>
                </div> 
                <div class="row">
                    <div class="col-md-6 form-group"> 
                        <label>Choose Image</label>
                        <input type="file" class="form-control" name="complaint_img" id="img" size="20">
                        <span class="error_form" id="img_errmsg"></span>
                    </div> 
                    <div class="offset-md-2 col-md-4 form-group">
                        <label> </label>
                        <img src="{{ URL::to('storage/complaint_images/'.$complaint->img) }}" alt="" id="img_tag" width="100px; height:100px;">
                    </div>
               </div>
                <div class="form-group">
                    <label>Complaint</label>
                    <textarea type="textarea"  name="complaint" id="complaint" class="form-control" placeholder="Enter Complaint" autocomplete="off">{{ $complaint->complaint }}</textarea>
                    <span class="error_form" id="complaint_errmsg"></span>
                </div> 
                
                <div class="form-group">
                    <label>Barcode (If Available)</label>
                    <input type="text" name="barcode" class="form-control" value="{{ $complaint->barcode }}" autocomplete="off">
                </div>
                <button type="submit" name="submit" id="update_complaint_btn" class="btn btn-success d-block mx-auto todisable" style="width:300px;">Save Changes</button>
                </form>

           </div>
        </div>    
    </div>
</div>




@include('inc.footer') 

<script type="text/javascript" src="{{ URL::to('src/daterangepicker-master/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('src/daterangepicker-master/daterangepicker.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('src/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>

<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        }
    });

    var current_status = '<?php echo $complaint->status; ?>';
    $('#status_change').val(current_status);  

    show_time_line();
    hide_or_show_delete_button();


    $('#status_change').on('change', function() {
        var current_value = $(this).val().toLowerCase();
        var complaint_no = $('#complaint_no').val();
 
        $.ajax({
            method:'POST',
            url:'/complaint/change_status',
            data:{status:current_value, complaint_no:complaint_no},
            dataType:'JSON',
            success: function(result){ 
                console.log(result);
                $('#status_change').val(current_value); 
                show_time_line();
            },
            error:function(result){
                console.log(result);
                console.log(result.responseText);
                alert('could not get data from database');
            }
        });
       hide_or_show_delete_button();

    });


    function show_time_line(){
        var complaint_no = $('#complaint_no').val();
        $.ajax({
            method:'POST',
            url:'/complaint/show_time_line',
            data:{complaint_no:complaint_no},
            dataType:'JSON',
            success: function(result){ 
                $('#pending_id').text(result.pending);
                $('#waiting_approval_id').text(result.waiting_for_approval);
                $('#approved_id').text(result.approved);
                $('#rejected_id').html(result.rejected);//just showing that 'html' also can be used.
                $('#completed_id').html(result.completed);
            },
            error:function(result){
                console.log(result);
                console.log(result.responseText);
                alert('could not get data from database');
            }

        });
    }
    

    function hide_or_show_delete_button(){
        var status_value = $('#status_change').val();
        if(status_value == 'completed' || status_value == 'rejected'){
            $("#delete_button").show(); 
            $("#delete_button").prop("disabled", false);  
            $(".status-adjust").css("width", "500");
        }
        else{
            $("#delete_button").hide(); 
            $("#delete_button").prop("disabled", true); 
            $(".status-adjust").css("width", "300");
        }
    }

</script>

<!--Validation section-->
<script>
   
    
    $('input[name="date"]').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        locale: { format: 'DD/MM/YYYY'} ,
        minYear: 1901
    }, function (start, end, label) {
    });

   // var date = '<?php echo $complaint->date; ?>';
   // $('#date').val(date); 
    
    //disable operations at date field
    $('#date').keydown(function(){
        return false;
    });
    $('#date').bind('contextmenu',function(e){
         e.preventDefault();
    });
    
    
    
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

  /*  $('#img').on('input',function(){
        check_img();
    });*/

    $('#img').on('input',function(){
      //checking if there is any error on selected img
      var img_result = check_img_not_mandotory();
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
    
    
        function check_img_not_mandotory(){
            /* var img_name = $('#img').val();
                var extension = $('#img').val().split('.').pop().toLowerCase();  */
    
            var img_value  = $('#img').val();

            if(img_value != ''){//if file selected then it should of proper format
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
                    else{
                        display_error_msg('please select an image', '#img_errmsg' , '#img' );
                        error_img = true;
                    }  
                    
            }
            else{//if no fie selected then there should be no error.
                hide_error('#img_errmsg', '#img');
                error_img = false; 
            }

            return error_img;
        }
    
    
        //FOR UPDATING COMPLAINT
    
        $('#update_complaint_btn').click(function(e){
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
            error_img  = check_img_not_mandotory();
    
            if(error_name == true || error_mobile_no == true || error_address == true || 
                error_item_name == true || error_complaint == true ){
                    e.preventDefault();
                    e.stopPropagation();
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