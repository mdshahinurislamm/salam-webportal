<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use DB;
use Illuminate\Support\Facades\Mail;

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
            'age' => 'required',
            'country' => 'required',
        ]);       
       
        $data = [
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => strtolower($request->input('email')),
            'password' => bcrypt($request->input('password')),
            'role' => '0',         
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

            // 3. Check Email Verification Status
            if (auth()->user()->email_verified_at === null) {
                
                // Capture the user instance before logging them out
                $user = auth()->user(); 
                
                // Log them back out immediately
                auth()->logout();
                
                // Set your error message
                $this->setErrorMessage('Your email address is not verified.'); 

                // FIX: Call the notification method on the user model object
                $user->sendEmailVerificationNotification();            
                
                // Redirect to the notice page
                return redirect()->route('verification.notice');  
            }
            
            // 4. Success: Regenerate session to protect against hijacking
            $request->session()->regenerate();
            
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

        $user = DB::table('users')->where('email', $request->email)->first(); 
        if (!$user->is_verified) {
            return response()->json([
                'success' => false,
                'message' => 'Please verify your email first'
            ]);
        }

       $credentials = $request->except(['_token']);
       if (auth()->attempt($credentials)){  
            
            // Generate the Sanctum plain-text token
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;          
            $user->access_token = $token;
            $user->token_type = 'Bearer';
            $user->message = 'Login successful';

            return response()->json($user);
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

        $otp = rand(100000, 999999);
        $otp = 1234;

        $data = [
            'first_name' => $request->input('first_name'),
            'email' => strtolower($request->input('email')),
            'password' => bcrypt($request->input('password')),
            'role' => '0',         
            'last_name' => '',
            'age' => $request->input('age'),
            'country' => $request->input('country'),
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(10),
        ];  
        //    return response()->json(['message' => $data['email']]);    
        
        $user = User::where('email', '=', $request->input('email'))->first();    

        if ($user === null) {

        // Send OTP by email
        Mail::raw("Your OTP is: $otp", function ($message) use ($data) {
            $message->to($data['email'])
                    ->subject('Email Verification OTP');
        });

        // user doesn't exist
        $result = User::create($data);  
        // return response()->json(['message' => 'User account created.']);    
        return response()->json(array_merge($result->toArray(), [
            'message' => 'User account created.'
        ]));
        
        }
        return response()->json(['message' => 'Email Alredy Exist']);   
        
    }
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required'
        ]);

        $user = User::where('email', $request->email)
                    ->where('otp', $request->otp)
                    ->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid OTP'
            ]);
        }

        if (now()->greaterThan($user->otp_expires_at)) {
            return response()->json([
                'success' => false,
                'message' => 'OTP expired'
            ]);
        }

        User::where('id', $user->id)->update([
            'is_verified' => true,
            'email_verified_at' => now(),
            'otp' => null,
            'otp_expires_at' => null,
        ]);
        // $user->markEmailAsVerified();

        return response()->json([
            'success' => true,
            'message' => 'Email verified successfully'
        ]);
    }

    // forget pass 
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ], 404);
        }

        $otp = rand(100000, 999999);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => $otp,
                'created_at' => now()
            ]
        );

        Mail::raw("Your password reset OTP is: {$otp}", function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Password Reset OTP');
        });

        return response()->json([
            'status' => true,
            'message' => 'OTP sent successfully'
        ]);
    }
    public function verifyResetOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required'
        ]);

        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->otp)
            ->first();

        if (!$record) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid OTP'
            ]);
        }

        if (now()->diffInMinutes($record->created_at) > 5) {
            return response()->json([
                'status' => false,
                'message' => 'OTP expired'
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'OTP verified'
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required',
            'password' => 'required|min:6|confirmed'
        ]);

        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->otp)
            ->first();

        if (!$record) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid OTP'
            ]);
        }

        User::where('email', $request->email)
            ->update([
                'password' => Hash::make($request->password)
            ]);

        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        return response()->json([
            'status' => true,
            'message' => 'Password reset successfully'
        ]);
    }
    
}
