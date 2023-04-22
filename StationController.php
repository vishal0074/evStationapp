<?php

namespace App\Http\Controllers\EVStation;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Redirect;
use DB;
use App\Models\Station;
use Carbon\Carbon;

class StationController extends Controller
{
    public function index() {
        
        $users  = Station::paginate(5);
        // dd($users);
        return view('station_list.list', compact('users'));
    }
    
  public function view() {
        return view('station_list.add');
   }
    
     public function edit( Request $request,$id){
        $user_list = Station::find($id);
        // dd($user_list);
        return view('station_list.edit', compact('user_list'));
    }   
  public function update(Request $request, $id){
    //   try{
        //  $validator = Validator::make($request->all(), [ 
        //     'provider_id' => 'required',
        //     'station_name' =>'required',
        //     'charging_station_type' =>'required',
        //     // 'charging_station_status'=>'required',
        //     'station_longitude' =>'required',
        //     'station_latitude'=>    'required',
        //     'station_open_time'=>'required',
        //     'station_close_time'=>'required',
        //     'station_description'=>'required',
        //     'delete_request' =>'required'
        //     //  'station_image' =>'required'
        // ]);
        // if ($validator->fails()) {
        //     return Redirect::back()->withErrors($validator->errors());
        // }
        // else{
             $image = $request->file('station_image');
            if(!empty($image)){
                $filename = uniqid() .time() . '.' . $image->extension();
                $path = $image->storeAs('/upload/users/', $filename);
                $destinationPath = public_path('/upload/users/');
                $image->move($destinationPath, $filename);
                $fileurl2 = '/upload/users/'.$filename;
            }
        
        $update = Station::find($id);
        $update->provider_id = $request->provider_id;
        $update->station_name = $request->station_name;
        $update->charging_station_type = $request->charging_station_type;
        // $update->charging_station_status = $request->charging_station_status;
        $update->station_longitude = $request->station_longitude;
        $update->station_latitude = $request->station_latitude;
        $update->station_open_time = $request->station_open_time;
        $update->station_close_time = $request->station_close_time;
        $update->station_description = $request->station_description;
        $update->delete_request =$request->delete_request;
        //  $update->station_image = $fileurl2;
        // dd($update);
        $update->save();
        Session::flash('Success', 'Record updated successfully');
        return redirect('/station_list');  
  }
//  }
  
  public  function destroy($id){
      $delete=Station::find($id)->delete();
        Session::flash('success',' Student deleted  Successfully!!');
          return redirect('/station_list');
    }
    
    
    public function delete_request(Request $request,$id){
        $users = Station::where('delete_request','like','%1%')->find($id);
        // dd($users);
        return view('station_list.list');
        
    }
 
  public function findSearch(Request $request)
        {
         $search = $request->input('Search');
        $users = Station::query()->where('provider_id', 'LIKE', "%{$search}%")->orWhere('station_name', 'LIKE', "%{$search}%")->get(); 
        return view( 'station_list.search' ,compact('users'))->withDetails ( $users )->withQuery ( $search );
             } 
             
     
       public function Search(Request $request)
        {
         $search = $request->input('Search');
        $users = Station::query()->where('provider_id', 'LIKE', "%{$search}%")->orWhere('station_name', 'LIKE', "%{$search}%")->get(); 
        return view( 'station_list.search' ,compact('users'))->withDetails ( $users )->withQuery ( $search );
             } 
     

         public function store(Request $request)
             {
    //     $validator = Validator::make($request->all(), [ 
    //         'provider id' =>'required',
    //         'station_name' => 'required',
    //         'charging_station_type' => 'required',
    //          'charging_station_status' => 'required',
    //          'station_longitude' =>'required',
    //          'station_latitude'=>'required',
    //         'station_open_time'=>'required',
    //         'station_close_time'=>'required',
    //         'station_description'=>'required',
    //          'station_image' =>'required',
    //         'delete_request'=>'required'
    //   ]);
    //       dd($validator);
    //         if ($validator->fails()) {
    //       return Redirect::back()->withErrors($validator->errors());
    //      }
        //   else{
             $image = $request->file('station_image');
            if(!empty($image)){
                $filename = uniqid() .time() . '.' . $image->extension();
                $path = $image->storeAs('/uploads/users/', $filename);
                $destinationPath = public_path('/uploads/users');
                $image->move($destinationPath, $filename);
                $fileurl =  $image;      
                }
            
            $users = new Station();
             $users->provider_id = $request->provider_id;
             $users->station_name = $request->station_name;
             $users->charging_station_type = $request->charging_station_type;
             $users->charging_station_status = $request->charging_station_status;
             $users->station_longitude = $request->station_longitude;
             $users->station_latitude =$request->station_latitude;
             $users->address = $request->address;
            $users->station_image =$fileurl;
            $users->station_open_time = $request->station_open_time;
             $users->station_close_time = $request->station_close_time;
             $users->station_description =$request->station_description;
             $users->delete_request = $request->delete_request;
            //   dd($users);
            
              $users->save();
               return redirect('/station_list')->with('success','User created successfully.');
 }
   }