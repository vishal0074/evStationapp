<?php

namespace App\Http\Controllers\EVStation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Session;
use App\Models\Admin;

class LoginController extends Controller
{
    
    protected $redirectTo = '/dashboard';
    
    public function guard()
    {
     return Auth::guard('webadmin');
    }
    
    public function index() {
        return view('/login');  
    } 
        
    //  public function __construct()
    //  {
    //      $this->middleware('auth');
    //  } 

    public function create(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
    
        $credentials = $request->only('email', 'password');
        if (Auth::guard('webadmin')->attempt($credentials)) {
            return redirect()->intended("/dashboard")->withSuccess('You have Successfully loggedin');
        }
        else{
            return redirect("/login")->withSuccess('Oppes! You have entered invalid credentials');
        }
    }
    
    public function dashboard() {
        return view('dashboard');
    }
    
    public function logout(){
        Auth::guard('webadmin')->logout();
        return Redirect('login');
    }
}

