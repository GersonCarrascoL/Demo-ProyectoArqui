<?php
namespace App\Http\Repositories;
use Validator;
use DB;
use GuzzleHttp\Client;

class TripRepository{

    public function index(){

        $response = DB::select('CALL sp_get_trips()');

        return view('welcome',['response'=> $response ,'response_message' => ""]);
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
        $id_viaje = $request->input('idTrip');
        $latitude = $request->input('tripInitLatitude');
        $longitude = $request->input('tripInitLongitude');
        $date = $request->input('tripDate');
        $conductor_name = $request->input('driverName');
        $conductor_ln = $request->input('driverLastName');
        $trip_status = $request->input('tripStatus');
        
        switch($trip_status){
            case 1:
                $status = "En espera";
                break;
            case 2:
                $status = "En viaje";
                break;
            case 3:
                $status = "Finalizado";
                break;
        }
        $res = $client->request('POST', '/viaje', [
            'multipart' => [
                [
                    'name' => 'latitude',
                    'contents' => $latitude
                ],
                [
                    'name' => 'longitude',
                    'contents' => $longitude
                ],
                [
                    'name' => 'id_viaje',
                    'contents' => $id_viaje
                ],
                [
                    'name' => 'fecha_viaje',
                    'contents' => $date
                ],
                [
                    'name' => 'nombre_p',
                    'contents' => 'Juan'
                ],
                [
                    'name' => 'apellido_p',
                    'contents' => 'Mendieta León'
                ],
                [
                    'name' => 'nombre_c',
                    'contents' => $conductor_name
                ],
                [
                    'name' => 'apellido_c',
                    'contents' => $conductor_ln
                ],
                [
                    'name' => 'estado',
                    'contents' => $status
                ]
                ,
                [
                    'name' => 'incidencia',
                    'contents' => 'Ninguna'
                ]
            ]
        ]);

        $response = DB::select('CALL sp_get_trips()');
        
        if ($res->getStatusCode() == 200) {
            $mensaje = 'Envio correcto';
        }
        $mensaje = 'Hubo un error';
        return back()->with(['response'=> $response, 'response_message' => $mensaje]);
    }
}
?>