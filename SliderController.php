<?php

namespace App\Http\Controllers\EVStation;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\Slider;
use Redirect;

class SliderController extends Controller{
    
    public function index(){
          $users  = Slider::paginate();
        // dd($users);
        return view('slider_list.list', compact('users'));
    }
     
     public function edit( Request $request,$id){
        $user_list = Slider::find($id);
        // dd($user_list);
        return view('slider_list.edit', compact('user_list'));
    }
     public function update(Request $request, $id){
     $validator = Validator::make($request->all(), [ 
            'id' =>'required',
            'name' =>'required',
            // 'image' =>'required',
        ]);
        
         if ($validator->fails()) {
            return Redirect::back()->withErrors($validator->errors());
        }else{
            $image = $request->file('image');
            if(!empty($image)){
                $filename = uniqid() .time() . '.' . $image->extension();
                $path = $image->storeAs('/uploads/users', $filename);
                $destinationPath = public_path('/uploads/users');
                $image->move($destinationPath, $filename);
                $fileurl =  '/uploads/users/'.$filename;
            }
        
        $update = Slider::find($id);
        $update->id = $request->id;
        $update->name = $request->name;
        // $update->image= $request->image;
       
        // dd($update);
        $update->save();
        Session::flash('Success', 'Record updated successfully');
        return redirect('/slider');  
        }}
        
    public function destroy($id){
      $delete=Slider::find($id)->delete();
        Session::flash('success',' Student deleted  Successfully!!');
          return redirect('/slider');
    }   
   public function findSearch(Request $request)
        {
       $search = $request->input('Search');
        $users = Slider::query()->where('id', 'LIKE', "%{$search}%")->orWhere('name', 'LIKE', "%{$search}%")->get(); 
        return view ('slider_list.search' ,compact('users'))->withDetails ( $users )->withQuery ( $search );
        }  
        
        
    public function Search(Request $request)
        {
       $search = $request->input('Search');
        $users = Slider::query()->where('id', 'LIKE', "%{$search}%")->orWhere('name', 'LIKE', "%{$search}%")->get(); 
        return view ('slider_list.search' ,compact('users'))->withDetails ( $users )->withQuery ( $search );
        }  
}