<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use DB;

class AuthController extends Controller
{
    //register
    public function showRegisterForm(){        
        return view('register');
    }
    public function prosessRegister(Request $request){  
        //validation
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => '',
            'industry' => 'required',
            'age' => 'required',
            'country' => 'required',
        ]);       
       
        $data = [
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => strtolower($request->input('email')),
            'password' => bcrypt($request->input('password')),
            'role' => '0',            
            'industry' => $request->input('industry'),            
            'age' => $request->input('age'),            
            'country' => $request->input('country'),
        ];
        try{
            $input = User::create($data);  
            $this->setSuccessfullyMessage('Registered successfully! Please verify your email.');   
            
            $input->sendEmailVerificationNotification();            
            //session()->flash('message','success');              
            return redirect()->route('verification.notice');

        }catch(Exeption $e){
            $this->setErrorMessage($e->getMessage());

            return redirect()->back();
        }

     }
    //login
    public function showLoginForm(){       
       
        return view('login'); 
    }
    public function processLogin(Request $request){

         //validation
         $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $credentials = $request->except(['_token']);

       // dd(auth()->attempt($credentials));
        if (auth()->attempt($credentials)){
            //return redirect()->route('/dashboard');
            return redirect('/dashboard');
             
        }            
        $this->setErrorMessage('Invalid credential'); 
        return redirect()->back();      
    }

    public function logout(){
        
        auth()->logout();

        $this->setSuccessfullyMessage('User has been logged-out.');
        return redirect()->route('login');
    }

    // mail verify --------------------------------
    public function verify(Request $request)
    {
        $user = User::find($request->route('id'));

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            event(new Verified($user));
        }
        $this->setSuccessfullyMessage('Email verified successfully!');   

        return redirect('login');
    }
    public function verificationShow()
    {
                  
            //return view('verification');

            if (Auth::user() && Auth::user()->hasVerifiedEmail()) {
                $this->setSuccessfullyMessage('Your email is already verified.');
                return redirect()->route('dashboard');
            }
    
            return view('verification');
        

    }
    public function resend(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            $this->setSuccessfullyMessage('Please log in to resend verification email.');
            return redirect()->route('login');
        }

        if ($user->hasVerifiedEmail()) {
            $this->setSuccessfullyMessage('Your email is already verified.');
            return redirect()->route('dashboard');
        }
    
        $user->sendEmailVerificationNotification();
        $this->setSuccessfullyMessage('Verification email sent!');
        return back();
    }

    // forget password -------------------------------------------------------
    // ForgotPasswordController.php
    public function showLinkRequestForm()
    {
        return view('passwords-email');
    }
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $response = Password::sendResetLink($request->only('email'));

        return $response == Password::RESET_LINK_SENT ? back()->with('message', __($response)) : back()->withErrors(['message' => __($response)]);
    }

    // ResetPasswordController.php
    public function showResetForm($token)
    {
        return view('passwords-reset', ['token' => $token]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
            'token' => 'required',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill(['password' => Hash::make($password)])->save();
            }
        );

        return $status == Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('message', __($status))
                    : back()->withErrors(['message' => [__($status)]]);
    }


    //for API login
    
    //login api
    public function processLoginApi(Request $request){
        
        //validation
        $this->validate($request, [
           'email' => 'required|email',
           'password' => 'required|min:6'
       ]);
       $credentials = $request->except(['_token']);
       if (auth()->attempt($credentials)){
            $paste = DB::table('users')->where('email', $request->email)->first(); 
            $paste->message = 'Username & Password';
            return response()->json($paste);
       } 
        
       return response()->json(['message' => 'Username & Password incorrect']);

   } 
   //register api
   public function prosessRegisterApi(Request $request){  

    //validation
    $validation = $this->validate($request, [
        'first_name' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:6',
        'role' => ''
    ]);     

    $data = [
        'first_name' => $request->input('first_name'),
        'email' => strtolower($request->input('email')),
        'password' => bcrypt($request->input('password')),
        'role' => strtolower("0"),         
        'last_name' => 'teswt', 
        'industry' => null,
        'age' => null,
        'country' => null
    ]; 

    
    
    $user = User::where('email', '=', $request->input('email'))->first();

    

    if ($user === null) {
    // user doesn't exist
    $result = User::create($data);
    

    return response()->json(['message' => 'User account created.']);
    }
    return response()->json(['message' => 'Email Alredy Exist']);
    
 }
    
}
