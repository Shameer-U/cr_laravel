<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        {{-- <title>{{config('app.name', 'LSAPP')}}</title>   --}}
        <title>CR</title> 
        {{-- <link rel="stylesheet" href="{{asset('css/app.css')}}"> --}}

        <!--my custom files -->
         <!--one way of loading files from public folder -->
        <link rel="stylesheet" href="{{asset('src/css/bootstrap.min.css')}}">

        <!-- daterange CSS -->
        <link rel="stylesheet" href="{{ URL::to('src/daterangepicker-master/daterangepicker.css') }}">
        <!-- -->
        <link rel="stylesheet" href="{{ URL::to('src/DataTables-1.10.18/css/jquery.dataTables.min.css') }}">
        <!--another way of loading files from public folder -->
        <link rel="stylesheet" href="{{ URL::to('src/css/main.css')}}">

        

    </head>
    <body>
        @include('inc.navbar')
        <div class="container mt-2">
            @include('inc.messages')
            @yield('content')
        </div>

        {{--@include('inc.footer')--}}  
    </body>
</html>
