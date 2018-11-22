<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Repositories\TripRepository;


class TripController extends Controller
{
    protected $tripRepository;

    public function __construct(TripRepository $tripRepository){
        $this->tripRepository = $tripRepository;
    }

    public function postTrip(Request $request){
        return $this->tripRepository->postTrip($request);
    }
}
