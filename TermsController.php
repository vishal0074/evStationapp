<?php

namespace App\Http\Controllers\EVStation;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Illuminate\Support\Facades\Input;
use Redirect;
use App\Models\Term_condition;

class TermsController extends Controller
{
    public function index() {
        
        $users  = Term_condition::paginate();
        // dd($users);
        return view('terms_list.list', compact('users'));
    }
    
     public function edit( Request $request,$id){
 
        $user_list = Term_condition::find($id);
        // dd($user_list);
        return view('terms_list.edit', compact('user_list'));
    }   
   public function update(Request $request, $id){
     $validator = Validator::make($request->all(), [ 
            'terms_condition' =>'required',
            'privacy' =>'required',
            'policy' =>'required',
        ]);
        
         if ($validator->fails()) {
            return Redirect::back()->withErrors($validator->errors());
        }
        
        $update = Term_condition::find($id);
        $update->terms_condition = $request->terms_condition;
        $update->privacy = $request->privacy;
        $update->policy= $request->policy;
       
        // dd($update);
        $update->save();
        Session::flash('Success', 'Record updated successfully');
        return redirect('/terms');  
        }
  
   public function destroy($id){
    
      $delete=Term_condition::find($id)->delete();
        Session::flash('success',' Student deleted  Successfully!!');
          return redirect('/terms');
     
    }
    
     public function findabouts(Request $request)
        {
        $search = $request->input('Search');
        $users = Term_condition::query()->where('privacy', 'LIKE', "%{$search}%")->orWhere('policy', 'LIKE', "%{$search}%")->get(); 
        return view ( 'terms_list.search' ,compact('users'))->withDetails ( $users )->withQuery ( $search );
        }
        
         public function find(Request $request)
        {
        $search = $request->input('Search');
        $users = Term_condition::query()->where('privacy', 'LIKE', "%{$search}%")->orWhere('policy', 'LIKE', "%{$search}%")->get(); 
        return view ( 'terms_list.search' ,compact('users'))->withDetails ( $users )->withQuery ( $search );
        }
        
  }
