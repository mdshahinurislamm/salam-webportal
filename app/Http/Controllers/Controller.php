<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{    
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //validation message
    public function setSuccessfullyMessage($message){
        session()->flash('message', $message);
        session()->flash('type','success');
    }
    public function setErrorMessage($message){
        session()->flash('message', $message);
        session()->flash('type','danger');
    }
}
