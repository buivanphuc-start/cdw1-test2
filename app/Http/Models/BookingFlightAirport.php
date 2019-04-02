<?php 

namespace App\Http\Models;

use Illuminate\Support\Facades\DB;

class BookingFlightAirport
{
	public function getAllItems(){
	$db = DB::table('booking_list')
						->join('flights', 'flights.id', 'booking_list.flight_id')
						->join('airports as airports_from', 'flights.flight_airport_from_id', 'airports_from.id')
                        ->join('airports as airports_to', 'flights.flight_airport_to_id', 'airports_to.id')
						->select(
                        'booking_list.*',
                        'flights.flight_airport_to_id as flight_to',
                        'flights.flight_airport_from_id as flight_from',
                        'airports_from.airport_name as name_a_from',
                        'airports_to.airport_name as name_a_to'	                                            
                        )->get();
       return $db;
	}
}