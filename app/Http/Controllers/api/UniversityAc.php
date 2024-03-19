<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\University;
use App\Models\UniversityGallery;
use App\Models\UniversityOverview;
use App\Models\UniversityVideoGallery;
use Illuminate\Http\Request;

class UniversityAc extends Controller
{
  public function index(Request $request)
  {
    $rows = University::with('getInstType', 'getAuthor', 'getDestination')->get();

    return response()->json($rows);
  }
  public function detail($slug)
  {
    $row = University::with('getInstType', 'getAuthor', 'getDestination')->where('slug', $slug)->first();

    if (!$row) {
      return response()->json(['message' => 'University not found'], 404);
    }

    return response()->json($row);
  }
  public function overviews($university_id)
  {
    $rows = UniversityOverview::where('university_id', $university_id)->get();

    if (!$rows) {
      return response()->json(['message' => 'data not found'], 404);
    }

    return response()->json($rows);
  }
  public function photos($university_id)
  {
    $rows = UniversityGallery::where('university_id', $university_id)->get();

    if (!$rows) {
      return response()->json(['message' => 'data not found'], 404);
    }

    return response()->json($rows);
  }
  public function videos($university_id)
  {
    $rows = UniversityVideoGallery::where('university_id', $university_id)->get();

    if (!$rows) {
      return response()->json(['message' => 'data not found'], 404);
    }

    return response()->json($rows);
  }
  public function universityBydestination(Request $request, $destination_id)
  {
    $rows = University::select('id', 'name', 'slug')->where('destination_id', $destination_id)->get();
    return response()->json($rows);
  }
}
