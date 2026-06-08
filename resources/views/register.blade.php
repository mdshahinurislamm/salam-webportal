
@extends('layouts.master')  
<link href="{{ asset('assets/css/signin.css')}}" rel="stylesheet">  
@section('content')

<main class="form-signin w-100 m-auto">  
        
    <form action="{{ url('/register') }}" method="post">
        @csrf
      <img class="mb-4" src="assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">
      <h1 class="h3 mb-3 fw-normal">Register!</h1>

      <div class="form-floating">
      <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus placeholder="First Name">
        @error('first_name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        <!-- <input type="text" name="first_name" class="form-control" id="floatingInput" placeholder="First Name"> -->
        <label for="floatingInput">First Name</label>
      </div>
      <div class="form-floating">
        <input type="text" name="last_name" class="form-control" id="floatingPassword" placeholder="Last Name">
        <label for="floatingPassword">Last Name</label>
      </div>
      <div class="form-floating">
        <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com">
        <label for="floatingInput">Email address</label>
      </div>
      <div class="form-floating">
        <input type="text" name="industry" class="form-control" id="floatingInput" placeholder="Industry">
        <label for="floatingInput">Industry</label>
      </div>    
      <div class="form-floating">
        <input type="text" name="age" class="form-control" id="floatingInput" placeholder="Age">
        <label for="floatingInput">Age</label>
      </div>    
      <div class="form-floating">
        <input type="text" name="country" class="form-control" id="floatingInput" placeholder="Country">
        <label for="floatingInput">Country</label>
      </div>
      <div class="form-floating">
        <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
        <label for="floatingPassword">Password</label>
      </div>
      <div class="form-floating">
        <input type="password" name="password_confirmation" class="form-control" id="floatingPassword" placeholder="Repeat Password">
        <label for="floatingPassword">Repeat Password</label>
      </div>

      <div class="checkbox mb-3 mt-3">
        <label>
          <input type="checkbox" value="remember-me"> Remember me
        </label>
      </div>
      <button class="w-100 btn btn-lg btn-primary" type="submit">Sign Up</button>
      <div class="col-auto fs-10 text-600"><span class="mb-0 undefined">or</span> <span><a href="{{url('/login')}}">Login</a></span></div>
    </form>
  </main> 
  
@endsection

 