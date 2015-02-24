<?php namespace App\Http\Controllers;

use Auth;

class HomeController extends Controller
{
  public function showIndex()
  {
    if (Auth::check())
    {
      return view('home');
    }

    return view('auth.login');
  }
}
