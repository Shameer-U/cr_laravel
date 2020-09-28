@extends('layouts.app')

@section('content')

<?php
 // echo '<pre>'; 
 // print_r($complaints);
 // echo '<pre>';
?>

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

        
        @foreach( $complaints as $complaint)
          <tr>
             <td> {{ $complaint->complaint_no  }}</td>
             <td>{{$complaint->customer_name }}</td>
             <td><img style="width:50px; height:50px;" src="{{-- URL::to('storage/cover_images/'.$post->cover_image)--}}" alt=""></td>
             <td>{{ $complaint->mobile_number  }}</td>
             <td>{{ $complaint->date  }}</td>
             <td>{{ $complaint->address  }}</td>
             <td>{{$complaint->status  }}</td>
			  <td><a class="btn btn-info btn-sm" href="/complaints/{{$complaint->id}}/edit">view</a></td>
             
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


 @include('inc.footer') 
<script type="text/javascript" src="{{ URL::to('src/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>

<script>
$(document).ready(function() {
    $('#dataTable').DataTable( {  } );
 });
</script>

@endsection