<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\NewsCategory;
use Illuminate\Http\Request;

class NewsCategoryC extends Controller
{
  public function index($id = null)
  {
    $rows = NewsCategory::get();
    if ($id != null) {
      $sd = NewsCategory::find($id);
      if (!is_null($sd)) {
        $ft = 'edit';
        $url = url('admin/news-category/update/' . $id);
        $title = 'Update';
      } else {
        return redirect('admin/news-category');
      }
    } else {
      $ft = 'add';
      $url = url('admin/news-category/store');
      $title = 'Add New';
      $sd = '';
    }
    $page_title = "News Category";
    $page_route = "news-category";
    $data = compact('rows', 'sd', 'ft', 'url', 'title', 'page_title', 'page_route');
    return view('admin.news-category')->with($data);
  }
  public function store(Request $request)
  {
    // printArray($request->all());
    // die;
    $request->validate(
      [
        'cate_name' => 'required|unique:news_categories,cate_name',
      ]
    );
    $field = new NewsCategory;

    $field->cate_name = $request['cate_name'];
    $field->slug = slugify($request['cate_name']);
    $field->meta_title = $request['meta_title'];
    $field->meta_keyword = $request['meta_keyword'];
    $field->meta_description = $request['meta_description'];
    $field->page_content = $request['page_content'];
    //$field->seo_rating = $request['seo_rating'];
    $field->save();
    session()->flash('smsg', 'New record has been added successfully.');
    return redirect('admin/news-category');
  }
  public function delete($id)
  {
    //echo $id;
    echo $result = NewsCategory::find($id)->delete();
  }
  public function update($id, Request $request)
  {
    $request->validate(
      [
        'cate_name' => 'required|unique:news_categories,cate_name,' . $id,
      ]
    );
    $field = NewsCategory::find($id);
    $field->cate_name = $request['cate_name'];
    $field->slug = slugify($request['cate_name']);
    $field->meta_title = $request['meta_title'];
    $field->meta_keyword = $request['meta_keyword'];
    $field->meta_description = $request['meta_description'];
    $field->page_content = $request['page_content'];
    //$field->seo_rating = $request['seo_rating'];
    $field->save();
    session()->flash('smsg', 'Record has been updated successfully.');
    return redirect('admin/news-category');
  }
}
