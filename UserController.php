<?php

namespace App\Http\Controllers\EVStation;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Redirect;
use App\Models\User;

class UserController extends Controller
{
    public function index() {
       
        
        $users  = User::paginate(5);
        // dd($users);
        return view('user_list.list', compact('users'));
    }
        
    public function create(Request $request){
        //
    }
    
    public function store(Request $request){
        //
    }

    public function show($id){
        //
    }
    
    public function edit( Request $request,$id){
        $user_list = User::find($id);
        // dd($user_list);
        return view('user_list.edit', compact('user_list'));
    }   
    
    
    public function update(Request $request, $id){
    //   try{
        //   $validator = Validator::make($request->all(), [ 
        //     'name' => 'required',
        //     'email' =>'required',
        //     'phone' =>'required',
        //     'country_code'=>'required',
        //     'user_type' =>'required',
        //      'profile_image'=>'required',
        //     'profile_status'=>'required',
           
        // ]);
        //   if ($validator->fails()) {
        //     return Redirect::back()->withErrors($validator->errors());
        //  }
        // //  else{
        //      if($request->hasFile('profile_image')){
        //     if(!empty($image)){
        //         $filename = uniqid() .time() . '.' . $image->extension();
        //         $path = $image->storeAs('/public/users', $filename);
        //         $destinationPath = public_path('/public/users');
        //         $image->move($destinationPath, $filename);
        //         $fileurl =  '/public/users/'.$filename;
        //     }
       
        $update = User::find($id);
        $update->name = $request->name;
        $update->email = $request->email;
        $update->phone = $request->phone;
        $update->country_code = $request->country_code;
        $update->user_type = $request->user_type;
        // $update->$request->file->fileurl;
        $update->profile_status = $request->profile_status;
      
        // dd($update);
        $update->save();
        Session::flash('Success', 'Record updated successfully');
        return redirect('/user_list');

    //   catch(\Exception $e){
    //       Session::flash('error', $e->getMessage());
    //     return redirect()->back();
          
      }
    //   }
        // }
         function destroy($id){
         $delete = User::find($id)->delete();
          Session::flash('Success', 'Record deleted successfully');
          return redirect('/user_list');
  }
  
   public function findSearch(Request $request)
        {
        $search = $request->input('Search');
        $users = User::query()->where('name', 'LIKE', "%{$search}%")->orWhere('phone', 'LIKE', "%{$search}%")->get(); 
        return view( 'user_list.search' ,compact('users'))->withDetails ( $users )->withQuery ( $search );
            
             }
            
        public function Search(Request $request)
        {
        $search = $request->input('Search');
        $users = User::query()->where('name', 'LIKE', "%{$search}%")->orWhere('phone', 'LIKE', "%{$search}%")->get(); 
        return view( 'user_list.search' ,compact('users'))->withDetails ( $users )->withQuery ( $search );
            
             }     
   }