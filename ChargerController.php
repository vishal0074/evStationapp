<?php

namespace App\Http\Controllers\EVStation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Redirect;
use DB;
use App\Models\Station;
use App\Models\ChargingStationType;
use App\Models\ChargingStationStatus;
use App\Models\ChargerConnector;
use App\Models\Charger_status;
use App\Models\ChargingType;

class ChargerController extends Controller
{
    public function charger_list() {
        $data =ChargingStationType::get();
        $status =ChargingStationStatus::get();
        $users =Station::get();
        $connector=ChargerConnector::get();
        $statuses=Charger_status::get();
        $charger_type =ChargingType::get();
        
        // dd($users);
        return view('charger.list',compact('users','data','status','connector','statuses','charger_type'));
    }
    
//  public function charger_type() {
//         $data =ChargingStationType::paginate();
//         // dd($users);
//         return view('charger.list',compact('$data'));
//     }   
    
    //  public function charger_status() {
    //     $users =Charger_status::paginate();
    //     dd($users);
    //     return view('charger.list',compact('users'));
    // }  
    
    
}