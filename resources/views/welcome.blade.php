<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <div class="header col-xs-12">
            <div class="col-xs-12 col-sm-offset-2 col-sm-10">
                TAXI MONTERRICO: MÓDULO DE FLOTA
            </div>
        </div>


        <div class="section_inicio1">
            <div class="container">
                <div class="lista-cuadro col-xs-12 col-md-offset-1 col-md-10">
                    <div class="lista-izq col-xs-12 col-sm-12">
                        <table class="table table-striped listavuelos">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Inicio</th>
                                    <th>Destino</th>
                                    <th>Modelo</th>
                                    <th>Placa</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($response as $res)
                                    <tr>
                                        <td>{{ $res->driverName }}</td>
                                        <td>{{ $res->tripInitAddress }}</td>
                                        <td>{{ $res->tripEndAddress }}</td>
                                        <td>{{ $res->vehicleModel }}</td>
                                        <td>{{ $res->vehicleLicensePlate }}</td>
                                        <td>

                                            <form  method="POST" class="form-data" action="{{ URL::to('/api/v1/trip/send') }}">
                                                <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                                                <input type="hidden" name="idTrip" value="{{ $res->idTrip }}">
                                                <input type="hidden" name="tripDate" value="{{ $res->tripDate }}">
                                                <input type="hidden" name="tripInitLatitude" value="{{ $res->tripInitLatitude }}">
                                                <input type="hidden" name="tripInitLongitude" value="{{ $res->tripInitLongitude }}">
                                                <input type="hidden" name="tripEndLatitude" value="{{ $res->tripEndLatitude }}">
                                                <input type="hidden" name="tripEndLongitude" value="{{ $res->tripEndLongitude }}">
                                                <input type="hidden" name="tripInitAddress" value="{{ $res->tripInitAddress }}">
                                                <input type="hidden" name="tripEndAddress" value="{{ $res->tripEndAddress }}">
                                                <input type="hidden" name="tripStatus" value="{{ $res->tripStatus }}">
                                                <input type="hidden" name="idVehicle" value="{{ $res->idVehicle }}">
                                                <input type="hidden" name="vehicleLicensePlate" value="{{ $res->vehicleLicensePlate }}">
                                                <input type="hidden" name="vehicleModel" value="{{ $res->vehicleModel }}">
                                                <input type="hidden" name="idDriver" value="{{ $res->idDriver }}">
                                                <input type="hidden" name="driverName" value="{{ $res->driverName }}">
                                                <input type="hidden" name="driverLastName" value="{{ $res->driverLastName }}">
                                                <input type="hidden" name="driverCellphone" value="{{ $res->driverCellphone }}">
                                                <button type="submit" class="btn btn-primary">Send</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="message">
                    @if ($response_message !== "")
                        {{ $response_message }}
                    @else
                        
                    @endif
                </div>
            </div>
        </div>
        
        <script src="js/jquery.js"></script>
        <script src="js/index.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>
