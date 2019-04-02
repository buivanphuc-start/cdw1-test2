<?php 

namespace App\Http\Models;

use Illuminate\Support\Facades\DB;

class BookingListFlightAirplanesAirports
{

    public function getItemById($user_id){
        $booked = DB::table('booking_list')
                  ->join('flights', 'flights.id', 'booking_list.flight_id')  
                  ->join('airplanes', 'flights.fslight_airplane_id', 'airplanes.id')                          
                  ->join('airports as airport_from', 'flights.flight_airport_from_id', 'airport_from.id')
                  ->join('airports as airport_to', 'flights.flight_airport_to_id', 'airport_to.id')
                  ->select(
                    'booking_list.*',
                    'flights.*',
                    'airplanes.airplane_name',
                    'booking_list.id as bookid',
                    'airport_from.airport_code as airport_from_code',
                    'airport_from.city_name as city_from',
                    'airport_to.airport_code as airport_to_code',
                    'airport_to.city_name as city_to'
                  )->where('user_id', '=', $user_id)->get();
        return $booked;
    }
}
 