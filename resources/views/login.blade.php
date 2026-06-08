
@extends('layouts.master')
<link href="{{ asset('assets/css/signin.css')}}" rel="stylesheet">
@section('content')
  <main class="form-signin w-100 m-auto">
  <img class="mb-4" src="assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">
      <h1 class="h3 mb-3 fw-normal">Please sign in</h1>    

    <form action="{{ url('/login') }}" method="post">
        @csrf
      <div class="form-floating">
        <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com">
        <label for="floatingInput">Email address</label>
      </div>
      <div class="form-floating">
        <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
        <label for="floatingPassword">Password</label>
      </div>

      <div class="checkbox mb-3">
        <label>
          <input type="checkbox" value="remember-me"> Remember me
        </label>
      </div>
      <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
      <div class="col-auto fs-10 text-600"><span class="mb-0 undefined">or</span> <span><a href="register">Create an account</a></span></div>
      <div class="col-auto fs-10 text-600"><span class="mb-0 undefined">or</span> <span><a href="{{url('/forgot-password')}}">Forgot Password</a></span></div>
    </form>
  </main>    
  @endsection