<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;

use App\Models\Service;
use App\Models\Treatment;
use App\Models\User;
use Illuminate\Http\Request;

class AppointmentFc extends Controller
{
  public function index(Request $request)
  {
    $services = Service::all();
    //$users = User::all();
    $data = compact('services');
    return view('front.appointment')->with($data);
  }
}
