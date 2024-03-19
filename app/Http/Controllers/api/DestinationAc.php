<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\DestinationGallery;
use App\Models\DestinationPageContent;
use App\Models\DestinationPageFaq;
use App\Models\DestinationPageTab;
use Illuminate\Http\Request;

class DestinationAc extends Controller
{
  public function index(Request $request)
  {
    $rows = Destination::with('author')->get();

    return response()->json($rows);
  }
  public function detail($slug)
  {
    $row = Destination::with('author')->where('slug', $slug)->first();

    if (!$row) {
      return response()->json(['message' => 'Destination not found'], 404);
    }

    return response()->json($row);
  }
  public function desContent($page_id)
  {
    $rows = DestinationPageContent::where('page_id', $page_id)->get();

    if (!$rows) {
      return response()->json(['message' => 'data not found'], 404);
    }

    return response()->json($rows);
  }
  public function gallery($destination_id)
  {
    $rows = DestinationGallery::where('destination_id', $destination_id)->get();

    if (!$rows) {
      return response()->json(['message' => 'data not found'], 404);
    }

    return response()->json($rows);
  }
  public function faqs($page_id)
  {
    $rows = DestinationPageFaq::where('page_id', $page_id)->get();

    if (!$rows) {
      return response()->json(['message' => 'data not found'], 404);
    }

    return response()->json($rows);
  }
}
