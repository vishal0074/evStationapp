<?php

namespace App\Http\Controllers\EVStation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Redirect;
use DB;
use App\Models\StationChargeList;
use App\Models\Station;

class ChargingController extends Controller
{
    public function index() {
        $users  = StationChargeList::paginate();
        // dd($users);
        return view('charger_list.list', compact('users'));
    }
    
     public function findSearch(Request $request,$id)
        {
        $data =Station::find($id);
        $users =StationChargeList::select('*')->where('station_id',$data->id)->get();
        // dd($users);
        return view('charger_list.list' ,compact('users','data'));
        }
    
    
    
}