<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;

use App\Models\Service;
use Illuminate\Http\Request;

class ContactFc extends Controller
{
  public function index(Request $request)
  {
    $services = Service::all();
    $data = compact('services');
    return view('front.contact-us')->with($data);
  }
  public function thankYou(Request $request)
  {
    return view('front.thank-you');
  }
}
