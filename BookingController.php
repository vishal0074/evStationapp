<?php

namespace App\Http\Controllers\EVStation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Redirect;
use App\Models\BookingSlot;
use App\Models\Station;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{

    
   /* public function index() {
        $booking  = BookingSlot::paginate(5);
        $users = Station::all();
        // dd($users);
        return view('booking_slot.list', compact('users','booking'));
    }*/

    public function index()
    {
        try{
        $stations = DB::table('booking_slots')
        ->leftjoin('stations', 'booking_slots.station_id', '=', 'stations.id')
        ->leftjoin('users', 'booking_slots.user_id', '=', 'users.id')
        ->select('booking_slots.id',  'users.name as user_id', /*'booking_slots.user_id', 'booking_slots.station_id',*/ 'stations.station_name as station_id', 'booking_slots.provider_id','booking_slots.date', 'booking_slots.start_time', 'booking_slots.end_time', 'booking_slots.charger_id', 'booking_slots.status', 'booking_slots.vehicle_number',)
        ->get();
        return view('booking_slot.list', compact('stations'));
        
        } catch (\Throwable $th) {
            return response()->json([
            'status' => 'false',
            'message' => $th->getMessage()
            ], 500);
        }
    }
   


    
     public function edit( Request $request,$id){
 
        $user_list = BookingSlot::find($id);
        // dd($user_list);
        return view('booking_slot.edit', compact('user_list'));
    }   
  public function update(Request $request, $id){
     $request->validate( [ 
            'date' =>'required',
            'start_time' =>'required',
            'end_time' =>'required',
            'charger_id'=>'required',
            'status'=>'required',
            'vehicle_number'=>'required'
        ]);
        $update = BookingSlot::find($id);
        $update->date = $request->date;
        $update->start_time = $request->start_time;
        $update->end_time = $request->end_time;
        $update->charger_id = $request->charger_id;
        $update->status = $request->status;
        $update->vehicle_number=$request->vehicle_number;
        // dd($update);
        $update->save();
        Session::flash('Success', 'Record updated successfully');
        return redirect('/booking_slot');  
  }
   
  
  public function destroy($id){
    
      $delete=BookingSlot::find($id)->delete();
        Session::flash('success',' booking deleted  Successfully!!');
          return redirect('/booking_slot');
     
    }
   public function findSearch(Request $request)
        {
         $search = $request->input('Search');
        $users = BookingSlot::query()->where('charger_id', 'LIKE', "%{$search}%")->orWhere('status', 'LIKE', "%{$search}%")->get(); 
        return view('booking_slot.search' ,compact('users'))->withDetails( $users )->withQuery( $search );
             }
  
  
    public function Search(Request $request)
        {
         $search = $request->input('Search');
        $users = BookingSlot::query()->where('charger_id', 'LIKE', "%{$search}%")->orWhere('status', 'LIKE', "%{$search}%")->get(); 
        return view( 'booking_slot.search' ,compact('users'))->withDetails ( $users )->withQuery ( $search );
             } 

}