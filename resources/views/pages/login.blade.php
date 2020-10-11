@extends('layouts.app')

@section('content')
<div class="login-container" id="login-box">
		    
    <div class="text-center">
     <h2>Login</h2>
   </div>


   <form method="POST" action="{{ url('/login') }}">
        {{ csrf_field() }} {{-- without csrf field form wont submit --}}
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" class="form-control" placeholder="Enter name" autocomplete="off">
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control"  placeholder="Enter Password">
        </div>
        <button type="submit" name="login" class="btn btn-primary btn-block">Login</button>
   </form>

<div>
   {{-- <a href="forgotpswd_controller/show_forgot_pswd_page">Forgot Password?</a>  --}}
</div>
</div>

<div>
    <pre>
        <?php
           //print_r(session('admin'));
        ?>
    </pre>
    <!-- accessing single value from session-->
    {{-- {{ session('admin')['name'] }} --}}
</div>

@include('inc.footer')        
@endsection
    