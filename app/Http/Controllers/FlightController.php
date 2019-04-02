<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Http\Models\Flights;
use App\Http\Models\Airports;
use App\Http\Models\Airplanes;
use App\Http\Models\FlightAirportAirplane;
use App\Http\Models\FlightClasses;
use App\Http\Models\Flight_Airport_Airplane_FlightClass;
class FlightController extends Controller
{

    public function index()
    {
      $obj_faa = new FlightAirportAirplane();
      $obj_airport = new Airports();
      $obj_airplane = new Airplanes();
      $obj_flightClasses = new FlightClasses();

      $flights = $obj_faa->getAllItems();
      $airports = $obj_airport->getAllItems();
      $airplanes = $obj_airplane->getAllitems();
      $flightClasses = $obj_flightClasses->getAllitems();

      return view('index', [
        'flights' => $flights,
        'airplanes' => $airplanes,
        'airports' => $airports,
        'flightClasses' => $flightClasses
      ]);
    }
    public function create()
    {
      $obj_airport = new Airports();
      $obj_airplane = new Airplanes();
      $obj_flightClasses = new FlightClasses();

        $airports = $obj_airport->getAllItems();
        $airplanes = $obj_airplane->getAllITems();
        $flightClasses = $obj_flightClasses->getAllItems();
        return view('admin.create-flight', [          
          'airports' => $airports,
          'airplanes' => $airplanes,
          'flightClasses' => $flightClasses,
        ]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
          'flight_airport_from' => 'required|different:flight_airport_to',
          'flight_code' => 'required|unique:flights',
          'distance' => 'required',
          'departure-date' => 'required|after_or_equal:today',
          'return-date' => 'after_or_equal:departure-date|nullable',
          'departure-datetime' => 'required|after_or_equal:departure-date',
          'arrival-datetime' => 'required|after_or_equal:departure-datetime',
        ]);

        if ($validator->fails()) {
            return redirect()
                        ->back()
                        ->withErrors($validator->errors())
                        ->withInput();
        } else {

          $input = $request->all();
          $obj_flight = new Flight();

          $flight = $obj_flight->addData(
            $input['flightClass'],
            $input['flight_type'],
            $input['flight_code'],
            $input['airplane'],
            $input['flight_airport_from'],
            $input['flight_airport_to'],
            $input['distance'],
            $input['departure-date'],
            $input['return-date'],
            $input['departure-datetime'],
            $input['arrival-datetime'],
            $input['arrival-datetime']);
 
          return redirect()->action('FlightController@create')->with([
            'status' => [
              'created' => "OK"
            ],
            'input' => $input,
          ]);
        }

    }


     public function flightDetail($flight_id){
       $airports = new Airports();
       $obj_faac = new Flight_Airport_Airplane_FlightClass();

       $flightDetail = $obj_faac->getDetail($flight_id);
        $airport_from = $airports->getItemById($flightDetail[0]->flight_airport_from_id);
        $airport_to= $airports->getItemById($flightDetail[0]->flight_airport_to_id);

        return view('detail_flight', [
            'flight' => $flightDetail[0],
            'airport_from' => $airport_from[0],
            'airport_to' => $airport_to[0]
          ]);
      }

    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
          'from' => 'required|different:to'
        ]);

        if ($validator->fails()) {
            return redirect()
                        ->back()
                        ->withErrors($validator->errors())
                        ->withInput();
        } else {
          $input = $request->all();
          //           $flights = DB::table('flights')
          //                     ->join('airplanes', 'flights.flight_airplane_id', 'airplanes.id')
          //                     ->join('airports as airport_from', 'flights.flight_airport_from_id', 'airport_from.id')
          //                     ->join('airports as airport_to', 'flights.flight_airport_to_id', 'airport_to.id')
          //                     ->select(
          //                       'flights.*',
          //                       'airplanes.airplane_name',
          //                       'airport_from.airport_code as airport_from_code',
          //                       'airport_from.city_name as city_from',
          //                       'airport_to.airport_code as airport_to_code',
          //                       'airport_to.city_name as city_to'
          //                     );

          // $flights->where('flight_class_id', '=', $input['flight-class']);
          // $flights = $flights->where('flight_type', '=', $input['flight_type']);
          // $flights->where('flight_airport_from_id', '=', $input['from']);
          // $flights->where('flight_airport_to_id', '=', $input['to']);

          // // Check if departure-date is selected
          // if (isset($input['departure-date'])) {
          //   $flights = $flights->where('flight_departure_date', '=', $input['departure-date']);
          // }
          
          // // Check if return-date is selected
          // if (isset($input['departure-date'])) {
          //   $flights = $flights->where('flight_return_date', '=', $input['return-date']);
          // }

          // // Paginate
          // $flights = $flights->paginate(5);
          // $flights->appends(request()->input())->links();

          $obj_faac = new Flight_Airport_Airplane_FlightClass();

          $flights = $obj_faac->search(
            $input['flight-class'],
            $input['flight_type'],
            $input['from'],
            $input['to'],
            $input['departure-date'],
            $input['return-date']
        );
                  // // Paginate
          $flights = $flights->paginate(5);
          $flights->appends(request()->input())->links();
          $airports = DB::table('airports')->get();
          $airport_from = $airports[$input['from'] - 1];
          $airport_to = $airports[$input['to'] - 1];

          return view('flight-list', [
            'input' => $input,
            'flights' => $flights,

            'airport_from' => $airport_from,
            'airport_to' => $airport_to
          ]);
        }
    }
}
