<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Airplanes extends Model
{
    // public function flights()
    // {
    //   return $this->hasMany(Flight::class, 'flight_airplane_id');
    // }

    public function getAllItems(){
    	return $this->get();
    }
}
