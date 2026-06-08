
@extends('layouts.master')  
<link href="{{ asset('assets/css/signin.css')}}" rel="stylesheet">  
@section('content')
<main class="form-signin w-100 m-auto">  
        
    <form action="{{ url('/forgot-password') }}" method="post">
        @csrf
      <img class="mb-4" src="assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">
      <h1 class="h3 mb-3 fw-normal">Forgot Password!</h1>

      <div class="form-floating mb-3">
        <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com">
        <label for="floatingInput">Email address</label>
      </div>
      <button class="w-100 btn btn-lg btn-primary" type="submit">Send Reset Link Email</button>
      <div class="col-auto fs-10 text-600"><span class="mb-0 undefined">or</span> <span><a href="{{url('/login')}}">Login</a></span></div>
    </form>
  </main> 
  
@endsection

 