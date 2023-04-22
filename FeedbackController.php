<?php

namespace App\Http\Controllers\EVStation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Illuminate\Support\Facades\Input;
use Redirect;
use App\Models\feedback;

class FeedbackController extends Controller
{
    public function index() {
        
        $users  = feedback::paginate();
        // dd($users);
        return view('feedback_list.list', compact('users'));
    }
    
     public function edit( Request $request,$id){
 
        $user_list = feedback::find($id);
        // dd($user_list);
        return view('feedback_list.edit', compact('user_list'));
    }   
  public function update(Request $request, $id){
     $request->validate( [ 
            'name' =>'required',
            'email' =>'required',
            'phone' =>'required',
            'Country_code'=>'required',
            'message'=>'required',
        ]);
        $update = feedback::find($id);
        $update->name = $request->name;
        $update->email = $request->email;
        $update->phone = $request->phone;
        $update->Country_code = $request->Country_code;
        $update->message = $request->message;
        // dd($update);
        $update->save();
        Session::flash('Success', 'Record updated successfully');
        return redirect('/feedback_list');  
  }
   
  
   public function destroy($id){
    
      $delete=feedback::find($id)->delete();
        Session::flash('success',' Student deleted  Successfully!!');
          return redirect('/feedback_list');
     
    }
  
     public function findSearch(Request $request)
        {
         $search = $request->input('Search');
        $users = feedback::query()->where('name', 'LIKE', "%{$search}%")->orWhere('phone', 'LIKE', "%{$search}%")->get(); 
        return view ( 'feedback_list.search' ,compact('users'))->withDetails ( $users )->withQuery ( $search );
             }
             
             
       
     public function Search(Request $request)
        {
         $search = $request->input('Search');
        $users = feedback::query()->where('name', 'LIKE', "%{$search}%")->orWhere('phone', 'LIKE', "%{$search}%")->get(); 
        return view ( 'feedback_list.search' ,compact('users'))->withDetails ( $users )->withQuery ( $search );
             }      
  }
// }