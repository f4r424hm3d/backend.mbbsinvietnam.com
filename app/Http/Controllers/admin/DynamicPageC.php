<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\DynamicPage;
use App\Models\User;
use Illuminate\Http\Request;

class DynamicPageC extends Controller
{
  public function index($id = null)
  {
    $users = User::All();
    $countries = Country::all();
    $rows = DynamicPage::get();
    if ($id != null) {
      $sd = DynamicPage::find($id);
      if (!is_null($sd)) {
        $ft = 'edit';
        $url = url('admin/dynamic-pages/update/' . $id);
        $title = 'Update';
      } else {
        return redirect('admin/dynamic-pages');
      }
    } else {
      $ft = 'add';
      $url = url('admin/dynamic-pages/store');
      $title = 'Add New';
      $sd = '';
    }
    $page_title = "Dynamic Page";
    $page_route = "dynamic-pages";
    $data = compact('rows', 'sd', 'ft', 'url', 'title', 'page_title', 'page_route', 'countries', 'users');
    return view('admin.dynamic-pages')->with($data);
  }
  public function store(Request $request)
  {
    // printArray($request->all());
    // die;
    $request->validate(
      [
        'page_name' => 'required|unique:dynamic_pages,page_name',
        'author_id' => 'numeric|nullable',
      ]
    );
    $field = new DynamicPage;
    if ($request->hasFile('thumbnail')) {
      $fileOriginalName = $request->file('thumbnail')->getClientOriginalName();
      $fileNameWithoutExtention = pathinfo($fileOriginalName, PATHINFO_FILENAME);
      $file_name_slug = slugify($fileNameWithoutExtention);
      $fileExtention = $request->file('thumbnail')->getClientOriginalExtension();
      $file_name = $file_name_slug . '_' . time() . '.' . $fileExtention;
      $move = $request->file('thumbnail')->move('uploads/dynamic-pages/', $file_name);
      if ($move) {
        $field->thumbnail = 'uploads/dynamic-pages/' . $file_name;
      } else {
        session()->flash('emsg', 'Some problem occured. File not uploaded.');
      }
    }
    if ($request->hasFile('image')) {
      $fileOriginalName = $request->file('image')->getClientOriginalName();
      $fileNameWithoutExtention = pathinfo($fileOriginalName, PATHINFO_FILENAME);
      $file_name_slug = slugify($fileNameWithoutExtention);
      $fileExtention = $request->file('image')->getClientOriginalExtension();
      $file_name = $file_name_slug . '_' . time() . '.' . $fileExtention;
      $move = $request->file('image')->move('uploads/dynamic-pages/', $file_name);
      if ($move) {
        $field->image_name = $file_name;
        $field->image_path = 'uploads/dynamic-pages/' . $file_name;
      } else {
        session()->flash('emsg', 'Some problem occured. File not uploaded.');
      }
    }
    $field->page_name = $request['page_name'];
    $field->slug = slugify($request['slug']);
    // $field->country = $request['country'];
    $field->author_id = $request['author_id'];
    // $field->course_duration = $request['course_duration'];
    // $field->neet = $request['neet'];
    // $field->english_profiency_exam = $request['english_profiency_exam'];
    // $field->intake = $request['intake'];
    // $field->eligibility = $request['eligibility'];
    // $field->medium_of_teaching = $request['medium_of_teaching'];
    $field->top_description = $request['top_description'];
    $field->meta_title = $request['meta_title'];
    $field->meta_keyword = $request['meta_keyword'];
    $field->meta_description = $request['meta_description'];
    $field->page_content = $request['page_content'];
    $field->seo_rating = $request['seo_rating'];
    $field->save();
    session()->flash('smsg', 'New record has been added successfully.');
    return redirect('admin/dynamic-pages');
  }
  public function delete($id)
  {
    echo $result = DynamicPage::find($id)->delete();
  }
  public function update($id, Request $request)
  {
    $request->validate(
      [
        'page_name' => 'required|unique:dynamic_pages,page_name,' . $id,
        'author_id' => 'numeric|nullable',
      ]
    );
    $field = DynamicPage::find($id);
    if ($request->hasFile('thumbnail')) {
      $fileOriginalName = $request->file('thumbnail')->getClientOriginalName();
      $fileNameWithoutExtention = pathinfo($fileOriginalName, PATHINFO_FILENAME);
      $file_name_slug = slugify($fileNameWithoutExtention);
      $fileExtention = $request->file('thumbnail')->getClientOriginalExtension();
      $file_name = $file_name_slug . '_' . time() . '.' . $fileExtention;
      $move = $request->file('thumbnail')->move('uploads/dynamic-pages/', $file_name);
      if ($move) {
        $field->thumbnail = 'uploads/dynamic-pages/' . $file_name;
      } else {
        session()->flash('emsg', 'Some problem occured. File not uploaded.');
      }
    }
    if ($request->hasFile('image')) {
      $fileOriginalName = $request->file('image')->getClientOriginalName();
      $fileNameWithoutExtention = pathinfo($fileOriginalName, PATHINFO_FILENAME);
      $file_name_slug = slugify($fileNameWithoutExtention);
      $fileExtention = $request->file('image')->getClientOriginalExtension();
      $file_name = $file_name_slug . '_' . time() . '.' . $fileExtention;
      $move = $request->file('image')->move('uploads/dynamic-pages/', $file_name);
      if ($move) {
        $field->image_name = $file_name;
        $field->image_path = 'uploads/dynamic-pages/' . $file_name;
      } else {
        session()->flash('emsg', 'Some problem occured. File not uploaded.');
      }
    }
    $field->page_name = $request['page_name'];
    $field->slug = slugify($request['slug']);
    // $field->country = $request['country'];
    $field->author_id = $request['author_id'];
    // $field->course_duration = $request['course_duration'];
    // $field->neet = $request['neet'];
    // $field->english_profiency_exam = $request['english_profiency_exam'];
    // $field->intake = $request['intake'];
    // $field->eligibility = $request['eligibility'];
    // $field->medium_of_teaching = $request['medium_of_teaching'];
    $field->top_description = $request['top_description'];
    $field->meta_title = $request['meta_title'];
    $field->meta_keyword = $request['meta_keyword'];
    $field->meta_description = $request['meta_description'];
    $field->page_content = $request['page_content'];
    $field->seo_rating = $request['seo_rating'];
    $field->save();
    session()->flash('smsg', 'Record has been updated successfully.');
    return redirect('admin/dynamic-pages');
  }
}
