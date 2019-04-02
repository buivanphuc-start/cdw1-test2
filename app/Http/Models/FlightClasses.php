<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class FlightClasses extends Model
{
    public function flights() {

      return $this->hasMany(Flight::class, 'flight_class_id');
    }

    public function getAllitems(){
    	return $this->get();
    }
}
