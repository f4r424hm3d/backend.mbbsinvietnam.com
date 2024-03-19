<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;

use App\Models\DynamicPageSeo;
use App\Models\Treatment;
use Illuminate\Http\Request;

class TreatmentFc extends Controller
{
  public function index(Request $request)
  {
    $rows = Treatment::paginate(10)->withQueryString();
    $data = compact('rows');
    return view('front.treatments')->with($data);
  }
  public function treatmentDetail(Request $request)
  {
    $slug = $request->segment(1);
    $treatment = Treatment::where('treatment_slug', $slug)->firstOrFail();
    $treatments = Treatment::where('id', '!=', $treatment->id)->limit(10)->get();
    $allTr = Treatment::all();

    $page_url = url()->current();

    $wrdseo = ['url' => 'treatment-details'];
    $dseo = DynamicPageSeo::where($wrdseo)->first();

    $sub_slug = $treatment->treatment_name;
    $site = 'drjayabalan.net';

    $tagArray = ['title' => $sub_slug, 'currentmonth' => date('M'), 'currentyear' => date('Y'), 'site' => $site];

    $meta_title = $treatment->meta_title == '' ? $dseo->meta_title : $treatment->meta_title;
    $meta_title = replaceTag($meta_title, $tagArray);

    $meta_keyword = $treatment->meta_keyword == '' ? $dseo->meta_keyword : $treatment->meta_keyword;
    $meta_keyword = replaceTag($meta_keyword, $tagArray);

    $page_content = $treatment->page_content == '' ? $dseo->page_content : $treatment->page_content;
    $page_content = replaceTag($page_content, $tagArray);

    $meta_description = $treatment->meta_description == '' ? $dseo->meta_description : $treatment->meta_description;
    $meta_description = replaceTag($meta_description, $tagArray);

    $og_image_path = $treatment->thumbnail_path == '' ? $dseo->og_image_path : $treatment->thumbnail_path;

    $data = compact('treatments', 'treatment', 'page_url', 'dseo', 'sub_slug', 'site', 'meta_title', 'meta_keyword', 'page_content', 'meta_description', 'og_image_path', 'allTr');
    return view('front.treatment-detail')->with($data);
  }
}
