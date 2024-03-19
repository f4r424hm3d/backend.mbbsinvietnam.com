<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\DynamicPageSeo;
use App\Models\Treatment;
use Illuminate\Http\Request;

class BlogFc extends Controller
{
  public function index(Request $request)
  {
    $blogs = Blog::paginate(9)->withQueryString();
    $data = compact('blogs');
    return view('front.blog')->with($data);
  }
  public function blogByCategory(Request $request)
  {
    $category_slug = $request->segment(2);
    $category = BlogCategory::where('category_slug', $category_slug)->firstOrFail();
    $blogs = Blog::where('category_id', $category->id)->paginate(10)->withQueryString();

    $page_url = url()->current();

    $wrdseo = ['url' => 'blog-by-category'];
    $dseo = DynamicPageSeo::where($wrdseo)->first();

    $title = $category->category_name;
    $site =  'drjayabalan.net';
    $tagArray = ['title' => $title, 'currentmonth' => date('M'), 'currentyear' => date('Y'), 'site' => $site];

    $meta_title = $category->meta_title == '' ? $dseo->meta_title : $category->meta_title;
    $meta_title = replaceTag($meta_title, $tagArray);

    $meta_keyword = $category->meta_keyword == '' ? $dseo->meta_keyword : $category->meta_keyword;
    $meta_keyword = replaceTag($meta_keyword, $tagArray);

    $page_content = $category->page_content == '' ? $dseo->page_content : $category->page_content;
    $page_content = replaceTag($page_content, $tagArray);

    $meta_description = $category->meta_description == '' ? $dseo->meta_description : $category->meta_description;
    $meta_description = replaceTag($meta_description, $tagArray);

    $og_image_path = null;

    $data = compact('category', 'blogs', 'page_url', 'dseo', 'title', 'site', 'meta_title', 'meta_keyword', 'page_content', 'meta_description', 'og_image_path');
    return view('front.blog-by-category')->with($data);
  }
  public function blogdetail(Request $request)
  {
    $allTr = Treatment::all();

    $slug = $request->segment(1);
    $blog = Blog::where('slug', $slug)->firstOrFail();
    $blogs = Blog::where('id', '!=', $blog->id)->limit(10)->get();
    $categories = BlogCategory::all();

    $treatments = Treatment::limit(10)->get();

    $page_url = url()->current();

    $wrdseo = ['url' => 'blog-details'];
    $dseo = DynamicPageSeo::where($wrdseo)->first();

    $sub_slug = $blog->title;
    $category = str_replace('-', ' ', $blog->cate_slug);
    $site = 'drjayabalan.net';

    $tagArray = ['title' => $sub_slug, 'category' => $category, 'currentmonth' => date('M'), 'currentyear' => date('Y'), 'site' => $site];

    $meta_title = $blog->meta_title == '' ? $dseo->meta_title : $blog->meta_title;
    $meta_title = replaceTag($meta_title, $tagArray);

    $meta_keyword = $blog->meta_keyword == '' ? $dseo->meta_keyword : $blog->meta_keyword;
    $meta_keyword = replaceTag($meta_keyword, $tagArray);

    $page_content = $blog->page_content == '' ? $dseo->page_content : $blog->page_content;
    $page_content = replaceTag($page_content, $tagArray);

    $meta_description = $blog->meta_description == '' ? $dseo->meta_description : $blog->meta_description;
    $meta_description = replaceTag($meta_description, $tagArray);

    $og_image_path = $blog->thumbnail_path == '' ? $dseo->og_image_path : $blog->thumbnail_path;

    $data = compact('categories', 'blogs', 'blog', 'page_url', 'dseo', 'sub_slug', 'site', 'meta_title', 'meta_keyword', 'page_content', 'meta_description', 'og_image_path', 'treatments', 'allTr');
    return view('front.blog-detail')->with($data);
  }
}
