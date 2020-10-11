<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Complaint;
use DB;
use Session;

class ComplaintController extends Controller
{
    function __construct()
    {
       //session is not working inside construct
       $this->check_login();
    }

    public function check_login(){
        $qwe = Session::get('admin');
        if( empty($qwe) ){
            return redirect('/')->send();
        }
    }


    public function complaints($status = 'all'){  
        $status = str_replace('_', ' ', $status);//removing underscore
        if($status != 'all'){
            $complaints = DB::table('complaints')
            ->where('status', $status)
            ->get();
        }
        else{
            $complaints = DB::table('complaints')
            ->get();
        }
                       
        //$complaints = Complaint::orderBy('created_at','desc');
       // return view('pages.complaints')->with('complaints', $complaints);
       return view('pages.complaints', ['complaints'=>$complaints, 'current_status' =>$status]);
    }

    public function createComplaint(Request $request){

        //Handle File Upload
        if($request->hasFile('complaint_img')){
            //Get filename with the extension
            $filenameWithExt = $request->file('complaint_img')->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //Get just ext
            $extension = $request->file('complaint_img')->getClientOriginalExtension();
            //Filename to store
            $fileNameToStore = $filename.'_'.date('YmdHis').'.'.$extension;
            //Upload Image
            $path = $request->file('complaint_img')->storeAs('public/complaint_images', $fileNameToStore);
        }
        else{
            $fileNameToStore = 'noimage.jpg';
        }

         //Create Complaint
         $complaint = new Complaint;
         $complaint->customer_name = $request->input('name');
         $complaint->mobile_no = $request->input('mobile_no');
         $complaint->date = $request->input('date');
         $complaint->address = $request->input('address');
         $complaint->item_name = $request->input('item_name');
         $complaint->img = $fileNameToStore;
         $complaint->complaint = $request->input('complaint');
         $complaint->barcode = $request->input('barcode');
         $complaint->status = 'pending';
         $complaint->save();

         $inserted_complaint = DB::table('complaints')
                ->latest()
                ->first();

         $result = DB::table('status_track')
            ->insert(
                ['complaint_no' => $inserted_complaint->id , 'pending' => date('d-m-Y')]
            );

        return response()->json(['status'=> $result]);
    }


    public function editComplaint($id){
        $complaint = Complaint::find($id);

        //one method of returning data
        //return view('pages.editcomplaint', ['complaint' => $complaint]);

        //same method with a little change
         $data['complaint'] = $complaint;
         return view('pages.editcomplaint', $data);
    }

    public function changeStatus(Request $request){
        $status = $request->input('status');
        $id = $request->input('complaint_no');

        $complaint = Complaint::find($id);
        $complaint->status = $status;
        $complaint->save();

        if($status == 'waiting for approval'){
            $status = 'waiting_for_approval';
        }


        $result = DB::table('status_track')
        ->updateOrInsert(
            ['complaint_no' => $id],
            [$status => date('d-m-Y')]
        );

        return response()->json($result);
    }

    public function showTimeLine(Request $request){
        $complaint_no = $request->input('complaint_no');

        $result = DB::table('status_track')->where('complaint_no', $complaint_no)->first();
        return response()->json($result); 
    }

    public function updateComplaint(Request $request, $id)
    {
         //Handle File Upload
         if($request->hasFile('complaint_img')){
            //Get filename with the extension
            $filenameWithExt = $request->file('complaint_img')->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //Get just ext
            $extension = $request->file('complaint_img')->getClientOriginalExtension();
            //Filename to store
            $fileNameToStore = $filename.'_'.date('YmdHis').'.'.$extension;
            //Upload Image
            $path = $request->file('complaint_img')->storeAs('public/complaint_images', $fileNameToStore);
        }

        
        //Update Complaint
        $complaint = Complaint::find($id);
        $complaint->customer_name = $request->input('name');
        $complaint->mobile_no = $request->input('mobile_no');
        $complaint->date = $request->input('date');
        $complaint->address = $request->input('address');
        $complaint->item_name = $request->input('item_name');

        if($request->hasFile('complaint_img')){
            //Delete Old Image
            Storage::delete('/public/complaint_images/'.$complaint->img);

            $complaint->img = $fileNameToStore;
        }

        $complaint->complaint = $request->input('complaint');
        $complaint->barcode = $request->input('barcode');
        //$complaint->status = 'pending';
        $complaint->save();

        return redirect('/complaints')->with('success', 'Complaint Updated');
    }

    public function deleteComplaint($id){
        $complaint = DB::table('complaints')->where('id', $id)->first();
        $result = DB::table('complaints')->where('id', $id)->delete();

        if($result){
            //Delete Old Image
            Storage::delete('/public/complaint_images/'.$complaint->img);

             DB::table('status_track')->where('complaint_no', $id)->delete();
        }

        if($result){
           return redirect('/complaints')->with('success', 'Complaint Deleted');
        }
        else{
            return redirect('complaint/'.$id.'/edit')->with('error', 'Could Not Deleted');
        }
    }
}
