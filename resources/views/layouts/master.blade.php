<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.104.2">
    <title>Signin Template · Bootstrap v5.2</title>
    <link href="{{ asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
  </head>
  <body class="d-flex flex-column min-vh-100 text-center">
  @auth()                       
    <div class="container">
        <header class="d-flex flex-wrap justify-content-between py-3 mb-4 border-bottom">
            <a href="{{url('/')}}" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
                <span class="fs-4">Logo</span>
            </a>  
            <div class="dropdown text-end">
                <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle active" data-bs-toggle="dropdown" aria-expanded="false">Hi  {{ optional(auth()->user())->first_name}}            
                </a>
                <ul class="dropdown-menu text-small">
                <li><a class="dropdown-item" href="#">Edit Profile</a></li>
                <li><a class="dropdown-item" href="#">Download TMP</a></li> 
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="{{ url('/logout')}}">Sign out</a></li>
                </ul>
            </div>
        </header>      
    </div>
  @endauth
  @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif   

    @if(session()->has('message'))
        <div class="alert alert-{{ session('type') ?? 'success' }}">
            {{session('message')}}
        </div>
    @endif    

  @yield('content')  
    <footer class="footer mt-auto py-3 bg-body-tertiary">
      <div class="container">
        <span class="text-body-secondary"><p class="mt-5 mb-3 text-muted">&copy; 2024</p></span>
      </div>
    </footer>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
