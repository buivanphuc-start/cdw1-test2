<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Airports extends Model
{
	protected $table = 'airports';
   public function getItemById($id)
   {
   		return $this->where('id', '=', $id)->get();
   }

   public function getAllItems(){
   		return $this->get();
   }

}
