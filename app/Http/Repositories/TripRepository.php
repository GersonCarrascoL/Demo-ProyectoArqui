<?php
namespace App\Http\Repositories;
use Validator;
use DB;
use GuzzleHttp\Client;

class TripRepository{

    public function index(){

        $response = DB::select('CALL sp_get_trips()');

        return view('welcome',['response'=> $response]);
    }


    public function postTrip($request){
        $validate = Validator::make( $request->all(),[
            'idViaje' => 'required|numeric',
            'viajeStatus' => 'required|numeric',
            'incidents' =>  'array',
            // 'incidents.*' => 'numeric'
        ]);

        if ($validate->fails()) {
            return response()->json([
                "errors" => $validate->errors()
            ],400);
        }

        $arrayIncidents = $request->input('incidents');
        $stringIncidents = "";

        if( sizeof($arrayIncidents) > 0){
            for ($i=0; $i < sizeof($arrayIncidents) ; $i++) { 
                if ($i+1 == sizeof($arrayIncidents)) {
                    $stringIncidents = $stringIncidents.$arrayIncidents[$i];
                }else{     
                    $stringIncidents = $stringIncidents.$arrayIncidents[$i].";";
                }
            }
        } 


        $response = DB::select('CALL sp_update_trip_status(?,?,?)',[
            trim($request->input('idViaje')),
            trim($request->input('viajeStatus')),
            trim($stringIncidents)
        ]);

        if( $response[0]->response == 0){
            return response()->json([
                "message" => "Error inserted"
            ],400);
        }

        return response()->json([
            "message" => "Success"
        ],201);
    }

    public function sendData($request){
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'http://52.15.208.224:5555',
            // You can set any number of default request options.

        ]);

        $latitude = $request->input('tripInitLatitude');
        $longitude = $request->input('tripInitLongitude');
        // dd($latitude);
        // dd($latitude);
        $res = $client->request('POST', '/viaje', [
            'multipart' => [
                [
                    'name' => 'latitude',
                    'contents' => $latitude
                ],
                [
                    'name' => 'longitude',
                    'contents' => $longitude
                ]
            ]
        ]);

        $response = DB::select('CALL sp_get_trips()');

        return back()->with(['response'=> $response]);
    }
}
?>