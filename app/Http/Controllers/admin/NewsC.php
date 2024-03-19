<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\NewsCategory;
use App\Models\News;
use App\Models\University;
use App\Models\User;
use Illuminate\Http\Request;

class NewsC extends Controller
{
  public function index($id = null)
  {
    $authors = Author::all();
    $universities = University::all();
    $category = NewsCategory::all();
    $rows = News::get();
    if ($id != null) {
      $sd = News::find($id);
      if (!is_null($sd)) {
        $ft = 'edit';
        $url = url('admin/news/update/' . $id);
        $title = 'Update';
      } else {
        return redirect('admin/news');
      }
    } else {
      $ft = 'add';
      $url = url('admin/news/store');
      $title = 'Add New';
      $sd = '';
    }
    $page_title = "News";
    $page_route = "news";
    $data = compact('rows', 'sd', 'ft', 'url', 'title', 'page_title', 'page_route','category','authors','universities');
    return view('admin.news')->with($data);
  }
  public function store(Request $request)
  {
    // printArray($request->all());
    // die;
    $request->validate(
      [
        'cate_id' => 'required',
        'headline' => 'required|unique:news,headline',
        'description' => 'required',
      ]
    );
    $field = new News;
    if ($request->hasFile('thumbnail')) {
      $fileOriginalName = $request->file('thumbnail')->getClientOriginalName();
      $fileNameWithoutExtention = pathinfo($fileOriginalName, PATHINFO_FILENAME);
      $file_name_slug = slugify($fileNameWithoutExtention);
      $fileExtention = $request->file('thumbnail')->getClientOriginalExtension();
      $file_name = $file_name_slug . '_' . time() . '.' . $fileExtention;
      $move = $request->file('thumbnail')->move('uploads/news/', $file_name);
      if ($move) {
        $field->imgname = $file_name;
        $field->imgpath = 'uploads/news/' . $file_name;
      } else {
        session()->flash('emsg', 'Some problem occured. File not uploaded.');
      }
    }
    $field->cate_id = $request['cate_id'];
    $field->author_id = $request['author_id'];
    $field->u_id = $request['u_id'];
    $field->headline = $request['headline'];
    $field->slug = slugify($request['headline']);
    $field->description = $request['description'];
    $field->meta_title = $request['meta_title'];
    $field->meta_keyword = $request['meta_keyword'];
    $field->meta_description = $request['meta_description'];
    $field->page_content = $request['page_content'];
    $field->status = 1;
    //$field->seo_rating = $request['seo_rating'];
    $field->save();
    session()->flash('smsg', 'New record has been added successfully.');
    return redirect('admin/news');
  }
  public function delete($id)
  {
    //echo $id;
    echo $result = News::find($id)->delete();
  }
  public function update($id, Request $request)
  {
    $request->validate(
      [
        'cate_id' => 'required',
        'headline' => 'required|unique:news,headline,'.$id,
        'description' => 'required',
      ]
    );
    $field = News::find($id);
    if ($request->hasFile('thumbnail')) {
      $fileOriginalName = $request->file('thumbnail')->getClientOriginalName();
      $fileNameWithoutExtention = pathinfo($fileOriginalName, PATHINFO_FILENAME);
      $file_name_slug = slugify($fileNameWithoutExtention);
      $fileExtention = $request->file('thumbnail')->getClientOriginalExtension();
      $file_name = $file_name_slug . '_' . time() . '.' . $fileExtention;
      $move = $request->file('thumbnail')->move('uploads/news/', $file_name);
      if ($move) {
        $field->imgname = $file_name;
        $field->imgpath = 'uploads/news/' . $file_name;
      } else {
        session()->flash('emsg', 'Some problem occured. File not uploaded.');
      }
    }
    $field->cate_id = $request['cate_id'];
    $field->author_id = $request['author_id'];
    $field->u_id = $request['u_id'];
    $field->headline = $request['headline'];
    $field->slug = slugify($request['headline']);
    $field->description = $request['description'];
    $field->meta_title = $request['meta_title'];
    $field->meta_keyword = $request['meta_keyword'];
    $field->meta_description = $request['meta_description'];
    $field->page_content = $request['page_content'];
    //$field->seo_rating = $request['seo_rating'];
    $field->save();
    session()->flash('smsg', 'Record has been updated successfully.');
    return redirect('admin/news');
  }
}
