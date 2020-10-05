@extends('layouts.app')

@section('content')

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

                <form class="py-3 px-3" method="POST" action=""  enctype="multipart/form-data" >

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Complaint No </label>
                    <div class="col-md-2">
                        <input type="text" readonly class="form-control-plaintext" name="complaint_no" id="complaint_no" disabled="disabled"  value="{{$complaint->id}}" >
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
                    <input type="text" name="item_name" id="item_name" value="{{ $complaint->address }}" class="form-control" autocomplete="off">
                    <span class="error_form" id="item_name_errmsg"></span>
                </div> 
                <div class="form-group">
                    <label>Choose Image</label>
                    <input type="file" class="form-control" name="myfile" id="img" size="20" >
                    <span class="error_form" id="img_errmsg"></span>
                </div> 
                <div class="form-group">
                    <label>Complaint</label>
                    <textarea type="textarea"  name="complaint" id="complaint" value="{{ $complaint->address }}" class="form-control" placeholder="Enter Complaint" autocomplete="off"></textarea>
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
@endsection

<script type="text/javascript" src="{{ URL::to('src/daterangepicker-master/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('src/daterangepicker-master/daterangepicker.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('src/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>