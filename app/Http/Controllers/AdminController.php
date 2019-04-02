<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Models\Booking_filgit_airplane;
use App\Http\Models\BookingFlightAirport;
class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        return view('admin.index');
    }

    public function RevenueStatistics()
    {
        $obj_bfa = new Booking_filgit_airplane();
        $db = $obj_bfa->getAllitems();
    	return view('admin.RevenueStatistics',['db' => $db]);
    }

    public function AirportStatistics()
    {

        $obj_bfa = new BookingFlightAirport();
        $db = new $obj_bfa->getAllitem();
        // $a_To = array();
        // $a_From = array();
        // // var_dump($number)
        // $demTo = array();
        // $demFrom = array();
        // for($i = 0 ; $i < count($db) ; $i++){
        //     $demTo[$i] = 0;
        //     $demFrom[$i] = 0;
        //     for ($j= $i+1; $j < count($db); $j++) { 
        //         if($db[$i]->flight_to == $db[$j]->flight_to )
        //         {
        //             $demTo[$i]++;
        //             $a_To[$i] = $db[$i]->flight_to;
        //         }

        //         if($db[$i]->flight_from == $db[$j]->flight_from){
        //             $demFrom[$i]++;
        //             $a_From[$i] = $db[$i]->flight_from;
        //         } 

        //     }
        // }

        // $tempTo = $demTo[0];
        // $id_a_to = $a_To[0];
        // for ($y=0; $y < count($a_To); $y++) { 
        //     if($tempTo <$demTo[$y])
        //     {
        //         $tempTo = $demTo[$y];
        //         $id_a_to = $a_To[$y];

        //     }
        // }
       
        // $tempFrom = $demFrom[0];
        // $id_a_from = $a_From[0];
        // for ($v=0; $v < count($a_From); $v++) { 
        //     if($tempFrom < $demFrom[$v])
        //     {
        //         $tempFrom = $demFrom[$v];
        //         $id_a_from = $a_From[$v];
        //     }
        // }
        //     $AFrom = $db->where('flights.flight_airport_from_id',$id_a_from);
        //     $ATo = $db->where('flights.flight_airport_to_id',$id_a_to);

         return view('admin.AirportStatistics')->with(['air' => $db]);

    }

    public function TicketManagement()
    {
    	
    }
}
