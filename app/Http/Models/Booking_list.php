<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Booking_list extends Model
{
  public $table = "Booking_list";
      public function getItemById($id){
        $item = $this->where('id','=',$id)->get();
        return $item;
      }

      public function deleteBooking($id){

        $item = $this->where('id','=',$id);
        $item = $this->delete();

        return $item;
      }

      public function addData(
      	$user,
      	$pas,
      	$tatol_cost,
      	$payment_method, 
      	$card_number, 
      	$name_card, 
      	$cvv_code, 
      	$flight_id){

        $this->user_id = $user;
      	$this->total_passenger = $pas;
        $this->total_cost = $tatol_cost;
        $this->payment_method = $payment_method;
        $this->card_number = $card_number;
        $this->name_card = $name_card;
        $this->ccv_code = $cvv_code;
        $this->flight_id = $flight_id;
        $this->save();
        return $this;
      }

      public function getAllItems(){
        $item = $this->get();
        return $items;
      }
}