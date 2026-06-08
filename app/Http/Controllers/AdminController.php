<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    //--login system
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }
    //admin dashboard
    public function dashboard(){
        return view('dashboard');
    }
}
