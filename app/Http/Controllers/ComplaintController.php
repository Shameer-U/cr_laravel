<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Complaint;
use DB;

class ComplaintController extends Controller
{
    public function index(){
        $complaints = DB::table('complaints')->get();
        //$complaints = Complaint::orderBy('created_at','desc');
        return view('pages.complaints')->with('complaints', $complaints);
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

         //Create Post
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

        return response()->json(['status'=> 'success']);
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
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);

        
        //Update Post
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        if($request->hasFile('cover_image')){
            $post->cover_image = $fileNameToStore;
        }
        $post->save();

        return redirect('/posts')->with('success', 'Post Updated');
    }
}
