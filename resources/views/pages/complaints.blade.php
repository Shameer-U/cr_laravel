@extends('layouts.app')

@section('content')

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

        <?php if(!empty($complaints)):
                 foreach( $complaints as $complaint): ?>
          <tr>
             <td><?php echo $complaint['complaint_no']; ?></td>
             <td><?php echo $complaint['customer_name']; ?></td>
             <td><img style="width:50px; height:50px;" src="<?php echo base_url() ?>assets/upload_images/<?php echo $complaint['img_name']; ?>" alt=""></td>
             <td><?php echo $complaint['mobile_no']; ?></td>
             <td><?php echo $complaint['date']; ?></td>
             <td><?php echo $complaint['address']; ?></td>
             <td><?php echo $complaint['status']; ?></td>
			  <td><a class="btn btn-info btn-sm" href="<?php echo base_url();?>complaint_controller/load_complaint_details/<?php echo $complaint['complaint_no']; ?>">view</a></td>
             
          </tr>
       <?php endforeach;
            endif;
         ?>
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