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
}
