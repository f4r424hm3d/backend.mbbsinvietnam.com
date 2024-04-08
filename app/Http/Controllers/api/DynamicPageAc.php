<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\DynamicPage;
use App\Models\DynamicPageContents;
use App\Models\DynamicPageFaq;
use App\Models\DynamicPageGallery;
use Illuminate\Http\Request;

class DynamicPageAc extends Controller
{
  public function index(Request $request)
  {
    $rows = DynamicPage::with('author')->get();

    return response()->json($rows);
  }
  public function detail($slug)
  {
    $row = DynamicPage::with('author')->where('slug', $slug)->first();

    if (!$row) {
      return response()->json(['message' => 'Page not found'], 404);
    }

    return response()->json($row);
  }
  public function desContent($page_id)
  {
    $rows = DynamicPageContents::where('page_id', $page_id)->get();

    if (!$rows) {
      return response()->json(['message' => 'data not found'], 404);
    }

    return response()->json($rows);
  }
  public function gallery($page_id)
  {
    $rows = DynamicPageGallery::where('page_id', $page_id)->get();

    if (!$rows) {
      return response()->json(['message' => 'data not found'], 404);
    }

    return response()->json($rows);
  }
  public function faqs($page_id)
  {
    $rows = DynamicPageFaq::where('page_id', $page_id)->get();

    if (!$rows) {
      return response()->json(['message' => 'data not found'], 404);
    }

    return response()->json($rows);
  }
}
