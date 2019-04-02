<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    public function flightClass()
    {
      return $this->beLongsTo(FlightClass::class);
    }

    public function airplane()
    {
      return $this->beLongsTo(Airplane::class);
    }

    public function getItemById($id){
    	$item = $this->wherer('id','=',$id)->get();
    	return $item;
    }
}
