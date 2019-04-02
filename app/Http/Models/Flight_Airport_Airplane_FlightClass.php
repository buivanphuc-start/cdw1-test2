<?php 
namespace App\Http\Models;

use Illuminate\Support\Facades\DB;

class Flight_Airport_Airplane_FlightClass
{
    public function search($flightClass, $flight_type, $from, $to, $departure_date,$return_date){
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
                              );


          $flights->where('flight_class_id', '=', $flightClass);
          $flights = $flights->where('flight_type', '=', $flight_type);
          $flights->where('flight_airport_from_id', '=', $from);
          $flights->where('flight_airport_to_id', '=', $to);
          // Check if departure-date is selected
          if ($departure_date) {
            $flights = $flights->where('flight_departure_date', '=', $departure_date);
          }
          // Check if return-date is selected
          if ($departure_date) {
            $flights = $flights->where('flight_return_date', '=', $return_date);
          }
  
          return $flights;
  }

  public function getDetail($flight_id){
      $flights = DB::table('flights')
                        ->join('airplanes', 'flights.flight_airplane_id', 'airplanes.id')
                        ->join('airports as airport_from', 'flights.flight_airport_from_id', 'airport_from.id')
                        ->join('airports as airport_to', 'flights.flight_airport_to_id', 'airport_to.id')
                        ->join('flight_classes','flights.flight_class_id', 'flight_classes.id')
                        ->select(
                          'flights.*',
                          'airplanes.airplane_name',
                          'airport_from.airport_code as airport_from_code',
                          'airport_from.city_name as city_from',
                          'airport_from.airport_name as airport_from_name',
                          'airport_to.airport_code as airport_to_code',
                          'airport_to.city_name as city_to',
                          'airport_to.airport_name as airport_to_name',
                          'flight_classes.flight_class_name as flight_class'
                        );
       $detail = $flights->where('flights.id',$flight_id)->get();  

       return $detail; 
  }
  
}