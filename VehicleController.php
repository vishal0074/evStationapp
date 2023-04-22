<?php

namespace App\Http\Controllers\EVStation;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\Vehicle;
use Redirect;

class VehicleController extends Controller{
    
    public function index(){
          $users  = Vehicle::paginate();
        // dd($users);
        return view('vehicle_list.list', compact('users'));
    }
    
     public function edit( Request $request,$id){
        $user_list = Vehicle::find($id);
        // dd($user_list);
        return view('vehicle_list.edit', compact('user_list'));
    }  
    
    public function update(Request $request, $id){
    //   try{
          $validator = Validator::make($request->all(), [ 
            'id' => 'required',
            'company_name' =>'required',
            'car_model' =>'required',
            'vehicle_number'=>'required',
        ]);
          if ($validator->fails()) {
            return Redirect::back()->withErrors($validator->errors());
         }
        $update = Vehicle::find($id);
        $update-> id = $request->id;
        $update->company_name = $request->company_name;
        $update->car_model =$request->car_model;
        $update->vehicle_number = $request->vehicle_number;
      
        // dd($update);
        $update->save();
        Session::flash('Success', 'Record updated successfully');
        return redirect('/vehicle');
}

     public function destroy($id){
         $delete = Vehicle::find($id)->delete();
          Session::flash('Success', 'Record deleted successfully');
          return redirect('/vehicle');
}

   public function findSearch(Request $request)
        {
        $search = $request->input('Search');
        $users = Vehicle::query()->where('company_name', 'LIKE', "%{$search}%")->orWhere('car_model', 'LIKE', "%{$search}%")->get(); 
        return view('vehicle_list.search' ,compact('users'))->withDetails( $users )->withQuery( $search );
        }
        
        
        
   public function Search(Request $request)
        {
        $search = $request->input('Search');
        $users = Vehicle::query()->where('company_name', 'LIKE', "%{$search}%")->orWhere('car_model', 'LIKE', "%{$search}%")->get(); 
        return view('vehicle_list.search' ,compact('users'))->withDetails( $users )->withQuery( $search );
        }
        
        
}