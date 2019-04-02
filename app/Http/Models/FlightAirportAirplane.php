<?php 

namespace App\Http\Models;

use Illuminate\Support\Facades\DB;

class FlightAirportAirplane
{
	

    public function getAllItems(){
        $flights = DB::table('flights')
                              ->join('airplanes', 'flights.flight_airplane_id', 'airplanes.id')
                              ->join('airports as airport_from', 'flights.flight_airport_from_id', 'airport_from.id')
                              ->join('airports as airport_to', 'flights.flight_airport_to_id', 'airport_to.id')
                              ->select(
                                'flights.*',
                                'airplanes.airplane_name',
                                'airport_from.airport_code as airport_from_code',
                                'airport_from.city_name as city_from',
                                'airport_to.airport_code as airport_to_code',
                                'airport_to.city_name as city_to'
                              )->get();
        return $flights;
    }
}