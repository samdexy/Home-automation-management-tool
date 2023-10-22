<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Device;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
        
        return view('wot', [
            'auth_user' => User::with('role')->where('id', '=', Auth::id())->get()
        ]);

    }


}
