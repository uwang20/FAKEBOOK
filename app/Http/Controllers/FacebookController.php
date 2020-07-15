<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FacebookController extends Controller
{
  public function mainDomain(){
    if(Auth::check()){
      return view('user.home');
    }
    else{
      return view('auth.facebook');
    }
  }

}
