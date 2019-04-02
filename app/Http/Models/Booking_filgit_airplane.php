<?php 

namespace App\Http\Models;

use Illuminate\Support\Facades\DB;

class Booking_filgit_airplane
{
    public function getAllitems(){
		$db = DB::table('booking_list')
							->join('flights', 'flights.id', 'booking_list.flight_id')
							->join('airplanes', 'flights.flight_airplane_id', 'airplanes.id')
							->select(
	                        'booking_list.total_cost',
	                        'flights.*',
	                        'airplanes.airplane_name'
	                        )->get();
        return $db;               

    }
}