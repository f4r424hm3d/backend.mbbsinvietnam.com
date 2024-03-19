<?php

namespace App\Http\Controllers\sitemap;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Exam;
use App\Models\ExamPage;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\Service;
use App\Models\University;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
  public function sitemap(Request $request)
  {
    return response()->view('sm.sitemap')->header('Content-Type', 'text/xml');
  }
  public function home(Request $request)
  {
    return response()->view('sm.home')->header('Content-Type', 'text/xml');
  }
  public function blog(Request $request)
  {
    $categories = NewsCategory::all();
    $news = News::all();
    $data = compact('categories','news');
    return response()->view('sm.blog',$data)->header('Content-Type', 'text/xml');
  }
  public function medicalUniversity(Request $request)
  {
    $universities = University::groupBy('country_slug')->get();
    $data = compact('universities');
    return response()->view('sm.medical-universities',$data)->header('Content-Type', 'text/xml');
  }
  public function destination(Request $request)
  {
    $destinations = Destination::all();
    $data = compact('destinations');
    return response()->view('sm.destinations',$data)->header('Content-Type', 'text/xml');
  }
  public function services(Request $request)
  {
    $services = Service::all();
    $data = compact('services');
    return response()->view('sm.services',$data)->header('Content-Type', 'text/xml');
  }
  public function exam(Request $request)
  {
    $exams = Exam::all();
    $exampages = ExamPage::all();
    $data = compact('exams','exampages');
    return response()->view('sm.exam',$data)->header('Content-Type', 'text/xml');
  }
  public function university(Request $request)
  {
    $universities = University::all();
    $data = compact('universities');
    return response()->view('sm.university',$data)->header('Content-Type', 'text/xml');
  }
}
