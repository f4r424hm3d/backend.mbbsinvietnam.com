<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceAc extends Controller
{
  public function index(Request $request)
  {
    $services = Service::all();

    return response()->json($services);
  }
  public function blogWithPaginate(Request $request)
  {
    $services = Service::all();

    return response()->json($services);
  }
  public function detail($slug)
  {
    $service = Service::where('service_slug', $slug)->first();

    if (!$service) {
      return response()->json(['message' => 'Service not found'], 404);
    }

    return response()->json($service);
  }
}
