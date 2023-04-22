<?php

namespace App\Http\Controllers\EVStation;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\review;
use Redirect;

class ReviewController extends Controller{
    public function index(){
        $users = review::paginate();
        // dd($users);
        return view('review_list.list', compact('users'));
    }
     public function destroy($id){
         $delete = review::find($id)->delete();
        //  dd($delete);
          Session::flash('Success', 'Record deleted successfully');
          return redirect('/review');
}

public function findSearch(Request $request){
      {
        $search = $request->input('Search');
        $users = review::query()->where('station_id', 'LIKE', "%{$search}%")->orWhere('review', 'LIKE', "%{$search}%")->get(); 
        return view('review_list.search' ,compact('users'))->withDetails( $users )->withQuery( $search );
       }}
       
    public function Search(Request $request){
      {
        $search = $request->input('Search');
        $users = review::query()->where('station_id', 'LIKE', "%{$search}%")->orWhere('review', 'LIKE', "%{$search}%")->get(); 
        return view('review_list.search' ,compact('users'))->withDetails( $users )->withQuery( $search );
       }}
}