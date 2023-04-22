<?php

namespace App\Http\Controllers\EVStation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Redirect;
use App\Models\Payment;
use App\Models\User;
use DB;

class PaymentController extends Controller
{
    public function index() {
        
        $payment  = Payment::paginate(5);
        /* $users = DB::table('users')
        ->leftjoin('table_name' users)
        ->select('name','phone')->get();*/
        $users = User::all();
        // dd($users);
        return view('payment_list.list', compact('users','payment'));
    }
     public function edit( Request $request,$id){
 
        $user_list = Payment::find($id);
        // dd($user_list);
        return view('payment_list.edit', compact('user_list'));
    } 
    
      public function update(Request $request, $id){
     $request->validate( [ 
            'user_id' =>'required',
            'transaction_id' =>'required',
            'total_amount' =>'required',
            'payment_status'=>'required',
           
        ]);
        $update = Payment::find($id);
        $update->user_id = $request->user_id;
        $update->transaction_id = $request->transaction_id;
        $update->total_amount = $request->total_amount;
        $update->payment_status = $request->payment_status;
        // dd($update);
        $update->save();
        Session::flash('Success', 'Record updated successfully');
        return redirect('/payment');  
        
      }
      public function destroy($id){
    
      $delete=Payment::find($id)->delete();
        Session::flash('success',' Student deleted  Successfully!!');
          return redirect('/payment');
    }  
    
    public function findSearch(Request $request)
        {
        $search = $request->input('Search');
        $users = Payment::query()->where('Payment_status', 'LIKE', "%{$search}%")->orWhere('total_amount', 'LIKE', "%{$search}%")->get(); 
        return view ('payment_list.search' ,compact('users'))->withDetails ( $users )->withQuery ( $search );
        }
        
        
        
    public function Search(Request $request)
        {
        $search = $request->input('Search');
        $users = Payment::query()->where('Payment_status', 'LIKE', "%{$search}%")->orWhere('total_amount', 'LIKE', "%{$search}%")->get(); 
        return view ('payment_list.search' ,compact('users'))->withDetails ( $users )->withQuery ( $search );
        }
        
        
        
        
}
  