<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    protected $table = 'flights';

    public function flightClass()
    { 
      return $this->beLongsTo(FlightClass::class);
    }

    public function airplane()
    {
      return $this->beLongsTo(Airplane::class);
    }

    public function getItemById($id){
    	$item = $this->where('id' , $id)->get();
    	return $item;
    }
         
    public function addData($flightClass, $flight_type, $flight_code, $airplane, $flight_airport_from, $flight_airport_to, $distance, $departure_date, $return_date,$departure_datetime,$arrival_datetime){

        $this->flight_class_id = $flightClass;
        $this->flight_type = $flight_type;
        $this->flight_code = $flight_code;
        $this->flight_airplane_id = $airplane;
        $this->flight_airport_from_id = $flight_airport_from;
        $this->flight_airport_to_id = $flight_airport_to;
                // Quy dinh gia may bay
      switch ($distance) {
        case $distance >= 0 && $distance <= 100:
          $this->flight_cost = 500000;
          break;
        case $distance >= 101 && $distance <= 200:
          $this->flight_cost = 1000000;
          break;
        case $distance >= 201 && $distance <= 500:
          $this->flight_cost = 2000000;
          break;
        case $distance >= 501 && $distance <= 1000:
          $this->flight_cost = 3000000;
          break;
        case $distance >= 1001 && $distance <= 2000:
          $this->flight_cost = 6000000;
          break;
        case $distance >= 2001 && $distance <= 5000:
          $this->flight_cost = 20000000;
          break;
        case $distance >= 5001:
            $this->flight_cost = 30000000;
            break;
        default:
          break;
      }
        $this->flight_departure_date = $departure_date;
        $this->flight_return_date = $return_date;


        $this->flight_departure_time = $departure_datetime;
        $this->flight_arrival_time = $arrival_datetime;
        $this->duration = date('H:i', strtotime($arrival_datetime) - strtotime($departure_datetime));
        $this->save();
        return $this;


    }
}
