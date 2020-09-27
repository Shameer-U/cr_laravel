<?php

namespace App\Http\Controllers;             

use Illuminate\Http\Request;
use App\Admin;
use DB;

class LoginController extends Controller
{
    public function loginPage(){
        return view('pages.login');
    }

    public function adminLogin(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);

        $username = $request->input('username');
        $password = $request->input('password');

        $admins = DB::table('admins')
                ->where('name', '=', $username)
                ->where('password', '=', $password)
                ->get();

        if (count($admins) === 1) {
            $admin = array(
                          'id' => $admins[0]->id,
                          'name' => $admins[0]->name,
                          'email' => $admins[0]->email,
                          'password' => $admins[0]->password,
                      );

            $request->session()->put('admin', $admin);

            return redirect('/')->with('success', 'Login successfull');
        } 
        else 
        {
            return redirect('/')->with('error', 'User does not exist');
        }
        
    }
}