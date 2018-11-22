<?php
namespace App\Http\Repositories;
use Validator;
use DB;
class TripRepository{

    public function postTrip($request){
        $validate = Validator::make( $request->all(),[
            'idViaje' => 'required|numeric',
            'viajeStatus' => 'required|numeric',
            'incidents' =>  'required|array'
        ]);

        if ($validate->fails()) {
            return response()->json([
                "errors" => $validate->errors()
            ],400);
        }

        $response = DB::raw('CALL sp_update_trip_status(?,?)',[
            trim($request->input('idViaje')),
            trim($request->input('viajeStatus'))
        ]);
        

        return "Ok";
    }
}
?>