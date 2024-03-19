<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryAc extends Controller
{
  public function index(Request $request)
  {
    $rows = Gallery::all();

    return response()->json($rows);
  }
}
