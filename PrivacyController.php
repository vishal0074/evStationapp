<?php

namespace App\Http\Controllers\EVStation;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Redirect;
use App\Models\Privacy;

class PrivacyController extends Controller{
    public function index(){
        $users  = Privacy::paginate();
        // dd($users);
        return view('privacy_list.list', compact('users'));
   }
   
   public function edit(Request $request,$id)
   {
       $user_list =Privacy::find($id);
        // dd($user_list);
        return view('privacy_list.edit', compact('user_list'));
   }
   
  public function update(Request $request, $id){
    //   try{
          $validator = Validator::make($request->all(), [ 
            'id' => 'required',
            'description'=>'required'
        ]);
          if ($validator->fails()) {
            return Redirect::back()->withErrors($validator->errors());
         }
        $update = Privacy::find($id);
        $update->id = $request->id;
        $update->description = $request->description;
      
        // dd($update);
        $update->save();
        Session::flash('Success', 'Record updated successfully');
        return redirect('/privacy');
  }
        public function destroy($id){
            $delete=Privacy::find($id)->delete();
            return redirect('/privacy');
        }
        
      public function findsearch(Request $request)
        {
          $search = $request->input('Search');
        $users = Privacy::query()->where('id', 'LIKE', "%{$search}%")->orWhere('description', 'LIKE', "%{$search}%")->get(); 
        return view ( 'privacy_list.search' ,compact('users'))->withDetails ( $users )->withQuery ( $search );
        }
        
           
      public function search(Request $request)
        {
          $search = $request->input('Search');
        $users = Privacy::query()->where('id', 'LIKE', "%{$search}%")->orWhere('description', 'LIKE', "%{$search}%")->get(); 
        return view ( 'privacy_list.search' ,compact('users'))->withDetails ( $users )->withQuery ( $search );
        }
        
        
        
}
