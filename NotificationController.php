<?php

namespace App\Http\Controllers\EVStation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Session;
use Redirect;
use App\Models\Notification;
use Carbon\Carbon;

class NotificationController extends Controller
{
    public function index() {
        
        $users  = Notification::paginate();
        // dd($users);
        return view('notification_list.list1', compact('users'));
    }
    
     public function edit( Request $request,$id){
        $user_list = Notification::find($id);
        // dd($user_list);
        return view('notification_list.edit', compact('user_list'));
    }  
    
  public function update(Request $request, $id){
//   $validator = Validator::make($request->all(), [ 
//             // 'id' =>'required',
//             'user_id' =>'required',
//             'station_id'=>'required',
//             'image'=>'required',
//             'time'=>'required',
//             'slot_id'=>'required',
//             'charger_id'=>'required',
//             'notification_read'=>'required',
//             'title' =>'required',
//             'description'=>'required',
//             'notification_type' =>'notification_type'
//         ]);
    
//          if ($validator->fails()) {
//             return Redirect::back()->withErrors($validator->errors());
//         }
    
        $update = Notification::find($id);
        $update->user_id = $request->user_id;
        $update->station_id = $request->station_id;
        $update->image = $request->image;
        $users->time = $request->time;
        $update->slot_id = $request->slot_id;
        $update->charger_id = $request->charger_id;
        $update->notification_read = $request->notification_read;
        $update->title = $request->title;
        $update->description = $request->description;
        $update->notification_type = $request->notification_type;
        // dd($update);
        $update->save();
        Session::flash('Success', 'Record updated successfully');
        return redirect('/notification');  
  }
   
   public function destroy($id){
      $delete=Notification::find($id)->delete();
        Session::flash('success',' Student deleted  Successfully!!');
          return redirect('/notification');
    }
  
     public function findSearch(Request $request)
        {
        $search = $request->input('Search');
        $users = Notification::query()->where('notification_type', 'LIKE', "%{$search}%")->orWhere('user_id', 'LIKE', "%{$search}%")->get(); 
        return view ( 'notification_list.search' ,compact('users'))->withDetails ( $users )->withQuery ( $search );
             }
             
    public function Search(Request $request)
        {
        $search = $request->input('Search');
        $users = Notification::query()->where('notification_type', 'LIKE', "%{$search}%")->orWhere('user_id', 'LIKE', "%{$search}%")->get(); 
        return view ( 'notification_list.search' ,compact('users'))->withDetails ( $users )->withQuery ( $search );
             }    
  }
// }