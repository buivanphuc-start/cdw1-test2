<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Passenger extends Model
{
      protected $table = 'passenger';

     public function addData($title, $firstname, $lastname, $flight_id, $user_id ){
     	$this->title = $title;
     	$this->pas_first_name = $firstname;
     	$this->pas_last_name = $lastname;
     	$this->flight_id = $flight_id;
     	$this->user_id = $user_id;
     	$this->save();
     }

	public function getUserFilght($user_id, $flight_id){
		$item = $this->where([['user_id','=', $user_id],['flight_id','=',$flight_id]])->get();
		return $item;
	}
}
