<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\User;
use Auth;
use App\Http\Models\Passenger;
use App\Http\Models\Booking_list;
use App\Http\Models\Flight;
use App\Http\Models\Airports;
use App\Http\Models\BookingListFlightAirplanesAirports;

class BookingController extends Controller
{

    public function booking(Request $request)
    {
        $data = array();
        for ($i=1; $i <= $request->pas; $i++) { 
            $data[] = [ 
                'title'.$i => 'required|string|max:25',
                'pas_first_name'.$i => 'required|string|max:255',
                'pas_last_name'.$i => 'required|string|max:255',];
                
                }

        $validator = Validator::make($request->all(), [
         $data,
          'payment_method' => 'required|string|max:255',
          'card_number' => 'required|string|max:19|min:13',
          'name_card' => 'required|string|max:255',
          'ccv_code' => 'required|string|max:4|min:3',
        ]);

        if ($validator->fails()) {
            return redirect()
                        ->back()
                        ->withErrors($validator->errors())
                        ->withInput();
                    }
        else {
            $input = $request->all();
            $booking = new Booking_list();           

            $booking->addData(Auth::user()->id,
                $input['pas'],
                $input['total_cost'],
                $input['payment_method'],
                $input['card_number'],
                $input['name_card'],  
                $input['ccv_code'],
                $input['flight_id'] );
                $booking->save();
            $passenger = new Passenger();
            for ($i=1; $i <= $request->pas; $i++) { 

                $title = 'title'.$i;
                $firstname = 'pas_first_name'.$i;
                $lastname = 'pas_last_name'.$i;


                $passenger->addData($input[$title], $input[$firstname],$input[$lastname],$booking->flight_id,Auth::user()->id); 
                
                }
            $book = $booking->getAllItems();
            $pass = $passenger->getAllItems();

            // }
            return redirect()->action('BookingController@detailBooking', ['booking'=>$book, 'passenger'=>$pass]);
        }
        
        
    }

    public function detailBooking($id)
    {
        $obj_filght = new Flight();
        $obj_bookingLight = new Booking_list();
        $obj_airport = new Airports();
        $obj_passenger = new Passenger();


        $booking = $obj_bookingLight->getItemById($id);
        $flight = $obj_filght->getItemById($booking[0]->flight_id); 
        $airport_from = $obj_airport->getItemById($flight[0]->flight_airport_from_id);
        $airport_to = $obj_airport->getItemById($flight[0]->flight_airport_to_id);
        $user = Auth::user()->where('id', '=',  $booking[0]->user_id)->first();
        $passenger = $obj_passenger->getUserFilght($booking[0]->user_id,$booking[0]->flight_id);

        // var_dump($passenger);
        $fare = $passenger->countPas();
        $cost = $flight[0]->flight_cost * $fare ;

        return view('detail_booking', [
        'booking' => $booking[0],
        'flight' => $flight[0],
        'airport_from'=> $airport_from[0],
        'airport_to'=> $airport_to[0],
        'passenger' => $passenger[0],
        'user' => $user,
        'cost' => $cost,
        'fare' => $fare
      ]);
    }

    public function MannageTicket($userid)
    { 
        $obj_bfaa = new BookingList_Flight_Airplane_Airports();
        $users = Auth::user()->id;        
        $user = Db::table('users')->where('id', '=', $userid)->get()->first();
        if ($userid == $users) {
            $booked = $obj_bfaa->getItemById($user->id);
            return view('manage_ticket', [
                'booked' => $booked[0],
            ]);
        } else {
            return back();
        }      
    }
    public function destroy($bookid)
    {
        $obj_bookingLight = new Booking_list();
        $obj_passenger = new Passenger();
        $bookingId = $obj_bookingLight->getItemById($bookid);
        $del_bl = $obj_bookingLight->deleteBooking($bookid);
        $del_pas = $obj_passenger->deletePassenger($bookid);
        return back();
    }
}
