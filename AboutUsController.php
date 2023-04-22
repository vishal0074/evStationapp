<?php

namespace App\Http\Controllers\EVStation;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\about_us;
use Redirect;

class AboutUsController extends Controller{
    
    public function index(){
          $users  = about_us::paginate();
        // dd($users);
        return view('about_list.list', compact('users'));
    }
    
     public function edit( Request $request,$id){
        $user_list = about_us::find($id);
        // dd($user_list);
        return view('about_list.edit', compact('user_list'));
    }  
    
    public function update(Request $request, $id){
    //   try{
          $validator = Validator::make($request->all(), [ 
            'id' => 'required',
            'title' =>'required',
            // 'image' =>'required',
            'description'=>'required',
        ]);
          if ($validator->fails()) {
            return Redirect::back()->withErrors($validator->errors());
         }
        $update = about_us::find($id);
        $update->id = $request->id;
        $update->title = $request->title;
        // $update->image =$request->image;
        $update->description = $request->description;
      
        // dd($update);
        $update->save();
        Session::flash('Success', 'Record updated successfully');
        return redirect('/about_us');
}

     public function destroy($id){
         $delete = about_us::find($id)->delete();
          Session::flash('Success', 'Record deleted successfully');
          return redirect('/about_us');
}

   public function findSearch(Request $request)
        {
         $search = $request->input('Search');
        $users = about_us::query()->where('id', 'LIKE', "%{$search}%")->orWhere('title', 'LIKE', "%{$search}%")->get(); 
        return view('about_list.search' ,compact('users'))->withDetails( $users )->withQuery( $search );
        }
        
        
    public function Search(Request $request)
        {
         $search = $request->input('Search');
        $users = about_us::query()->where('id', 'LIKE', "%{$search}%")->orWhere('title', 'LIKE', "%{$search}%")->get(); 
        return view( 'about_list.search' ,compact('users'))->withDetails ( $users )->withQuery ( $search );
             } 
}