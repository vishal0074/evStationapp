<?php

namespace App\Http\Controllers\EVStation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Session;
use Redirect;
use App\Models\User;
use Carbon\Carbon;

class ProviderController extends Controller
{
    public function index() {
    
        $users  = User::paginate();
        // dd($users);
        return view('provider_list.list', compact('users'));
   }
   
   public function view() {

        return view('provider_list.add');
   }
   
     public function edit( Request $request,$id){
 
        $user_list = User::find($id);
        // dd($user_list);
        return view('provider_list.edit', compact('user_list'));
    } 
    
    
    public function findSearch(Request $request){
       $search = $request->input('Search');
        $users = User::query()->where('name', 'LIKE', "%{$search}%")->orWhere('user_type', 'LIKE', "%{$search}%")->get(); 
        return view ( 'provider_list.search' ,compact('users'))->withDetails ( $users )->withQuery ( $search );
    }
    
    
     
    public function Search(Request $request){
       $search = $request->input('Search');
        $users = User::query()->where('name', 'LIKE', "%{$search}%")->orWhere('user_type', 'LIKE', "%{$search}%")->get(); 
        return view ( 'provider_list.search' ,compact('users'))->withDetails ( $users )->withQuery ( $search );
    }
    
    
    // store data 
    public function store(Request $request){
        
        $validator = Validator::make($request->all(), [ 
            'name' => 'required',
            'email' => 'required',
            'phone' =>'required',
            'user_type' => 'required'
        ]);
        // dd($validator);
        if($validator->fails()) {
            return Redirect::back()->withErrors($validator->errors());
        }else{
            $users = new User();
            // $users->created_by = Auth::user()->id;
            $users->name = $request->name;
            $users->email = $request->email;
            $users->phone = $request->phone;
            $users->user_type = $request->user_type;
            $users->country_code ="1";
            $users->verification_time = Carbon::now();
            //   dd($users);
            $users->save();
            return redirect()->route('provider_list')->with('success','User created successfully.');
            }
        }
    }
