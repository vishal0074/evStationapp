<?php

namespace App\Http\Controllers\EVStation;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\contact_us;
use Redirect;

class ContactUsController extends Controller{
    
    public function index(){
          $users  = contact_us::paginate();
        // dd($users);
        return view('contact_list.list', compact('users'));
    }
    
     public function edit( Request $request,$id){
        $user_list = contact_us::find($id);
        // dd($user_list);
        return view('contact_list.edit', compact('user_list'));
    }  
    
     public function update(Request $request, $id){
    //   try{
          $validator = Validator::make($request->all(), [ 
            'id' => 'required',
            'title' =>'required',
            'image' =>'required',
            'address'=>'required',
            'contact' =>'required',
            'email' =>'required'
        ]);
          if ($validator->fails()) {
            return Redirect::back()->withErrors($validator->errors());
         }
        $update = contact_us::find($id);
        $update->id = $request->id;
        $update->title = $request->title;
        $update->image =$request->image;
        $update->address = $request->address;
        $update->contact= $request->contact;
        $update->email =$request->email;      
        // dd($update);
        $update->save();
        Session::flash('Success', 'Record updated successfully');
        return redirect('/contact_us');
     }  
        public function destroy($id){
         $delete = contact_us::find($id)->delete();
          Session::flash('Success', 'Record deleted successfully');
          return redirect('/contact_us');
        }
        
        
      public function find(Request $request)
        {
        $search = $request->input('Search');
        $users = contact_us::query()->where('address', 'LIKE', "%{$search}%")->orWhere('contact', 'LIKE', "%{$search}%")->get(); 
        return view ( 'contact_list.search' ,compact('users'))->withDetails ( $users )->withQuery ( $search );
 
        } 
 
  public function findSearch(Request $request)
        {
        $search = $request->input('Search');
        $users = contact_us::query()->where('address', 'LIKE', "%{$search}%")->orWhere('Contact', 'LIKE', "%{$search}%")->get(); 
        return view ( 'contact_list.search' ,compact('users'))->withDetails ( $users )->withQuery ( $search );
 

        }   
}