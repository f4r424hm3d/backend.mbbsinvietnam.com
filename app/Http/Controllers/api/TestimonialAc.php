<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialAc extends Controller
{
  public function index(Request $request)
  {
    $rows = Testimonial::all();
    return response()->json($rows);
  }
}
