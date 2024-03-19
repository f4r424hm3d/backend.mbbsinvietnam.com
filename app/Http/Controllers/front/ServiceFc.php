<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;

use App\Models\DynamicPageSeo;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceFc extends Controller
{
  public function index(Request $request)
  {
    $rows = Service::paginate(10)->withQueryString();
    $data = compact('rows');
    return view('front.services')->with($data);
  }
  public function Detail(Request $request)
  {
    $slug = $request->segment(1);
    $service = Service::where('service_slug', $slug)->firstOrFail();
    $services = Service::where('id', '!=', $service->id)->limit(10)->get();
    $allServices = Service::all();

    $page_url = url()->current();

    $wrdseo = ['url' => 'service-details'];
    $dseo = DynamicPageSeo::where($wrdseo)->first();
    // printArray($dseo);
    // die;

    $sub_slug = $service->service_name;
    $site = 'drjayabalan.net';

    $tagArray = ['title' => $sub_slug, 'currentmonth' => date('M'), 'currentyear' => date('Y'), 'site' => $site];

    $meta_title = $service->meta_title == '' ? $dseo->meta_title : $service->meta_title;
    $meta_title = replaceTag($meta_title, $tagArray);
    //die;

    $meta_keyword = $service->meta_keyword == '' ? $dseo->meta_keyword : $service->meta_keyword;
    $meta_keyword = replaceTag($meta_keyword, $tagArray);

    $page_content = $service->page_content == '' ? $dseo->page_content : $service->page_content;
    $page_content = replaceTag($page_content, $tagArray);

    $meta_description = $service->meta_description == '' ? $dseo->meta_description : $service->meta_description;
    $meta_description = replaceTag($meta_description, $tagArray);

    $og_image_path = $service->thumbnail_path == '' ? $dseo->og_image_path : $service->thumbnail_path;

    $data = compact('services', 'service', 'page_url', 'dseo', 'sub_slug', 'site', 'meta_title', 'meta_keyword', 'page_content', 'meta_description', 'og_image_path', 'allServices');
    return view('front.service-detail')->with($data);
  }
}
