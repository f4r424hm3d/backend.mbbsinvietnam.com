<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\DynamicPageSeo;
use Illuminate\Http\Request;

class SeoAc extends Controller
{
  public function index(Request $request, $page_name)
  {
    $row = DynamicPageSeo::where('url', $page_name)->firstOrFail();
    return response()->json($row);
  }
}
