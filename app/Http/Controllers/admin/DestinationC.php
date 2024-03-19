<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Country;
use App\Models\Destination;
use App\Models\User;
use Illuminate\Http\Request;

class DestinationC extends Controller
{
  public function index($id = null)
  {
    $users = User::All();
    $countries = Country::all();
    $rows = Destination::get();
    if ($id != null) {
      $sd = Destination::find($id);
      if (!is_null($sd)) {
        $ft = 'edit';
        $url = url('admin/destinations/update/' . $id);
        $title = 'Update';
      } else {
        return redirect('admin/destinations');
      }
    } else {
      $ft = 'add';
      $url = url('admin/destinations/store');
      $title = 'Add New';
      $sd = '';
    }
    $page_title = "Destination";
    $page_route = "destinations";
    $data = compact('rows', 'sd', 'ft', 'url', 'title', 'page_title', 'page_route', 'countries', 'users');
    return view('admin.destinations')->with($data);
  }
  public function store(Request $request)
  {
    // printArray($request->all());
    // die;
    $request->validate(
      [
        'page_name' => 'required|unique:destinations,page_name',
        'country' => 'required',
        'author_id' => 'numeric|nullable',
      ]
    );
    $field = new Destination;
    if ($request->hasFile('thumbnail')) {
      $fileOriginalName = $request->file('thumbnail')->getClientOriginalName();
      $fileNameWithoutExtention = pathinfo($fileOriginalName, PATHINFO_FILENAME);
      $file_name_slug = slugify($fileNameWithoutExtention);
      $fileExtention = $request->file('thumbnail')->getClientOriginalExtension();
      $file_name = $file_name_slug . '_' . time() . '.' . $fileExtention;
      $move = $request->file('thumbnail')->move('uploads/destinations/', $file_name);
      if ($move) {
        $field->thumbnail = 'uploads/destinations/' . $file_name;
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
      $move = $request->file('image')->move('uploads/destinations/', $file_name);
      if ($move) {
        $field->image_name = $file_name;
        $field->image_path = 'uploads/destinations/' . $file_name;
      } else {
        session()->flash('emsg', 'Some problem occured. File not uploaded.');
      }
    }
    $field->page_name = $request['page_name'];
    $field->slug = slugify($request['slug']);
    $field->country = $request['country'];
    $field->author_id = $request['author_id'];
    $field->course_duration = $request['course_duration'];
    $field->neet = $request['neet'];
    $field->english_profiency_exam = $request['english_profiency_exam'];
    $field->intake = $request['intake'];
    $field->eligibility = $request['eligibility'];
    $field->medium_of_teaching = $request['medium_of_teaching'];
    $field->top_description = $request['top_description'];
    $field->meta_title = $request['meta_title'];
    $field->meta_keyword = $request['meta_keyword'];
    $field->meta_description = $request['meta_description'];
    $field->page_content = $request['page_content'];
    $field->seo_rating = $request['seo_rating'];
    $field->save();
    session()->flash('smsg', 'New record has been added successfully.');
    return redirect('admin/destinations');
  }
  public function delete($id)
  {
    //echo $id;
    echo $result = Destination::find($id)->delete();
  }
  public function update($id, Request $request)
  {
    $request->validate(
      [
        'page_name' => 'required|unique:destinations,page_name,' . $id,
        'country' => 'required',
        'author_id' => 'numeric|nullable',
      ]
    );
    $field = Destination::find($id);
    if ($request->hasFile('thumbnail')) {
      $fileOriginalName = $request->file('thumbnail')->getClientOriginalName();
      $fileNameWithoutExtention = pathinfo($fileOriginalName, PATHINFO_FILENAME);
      $file_name_slug = slugify($fileNameWithoutExtention);
      $fileExtention = $request->file('thumbnail')->getClientOriginalExtension();
      $file_name = $file_name_slug . '_' . time() . '.' . $fileExtention;
      $move = $request->file('thumbnail')->move('uploads/destinations/', $file_name);
      if ($move) {
        $field->thumbnail = 'uploads/destinations/' . $file_name;
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
      $move = $request->file('image')->move('uploads/destinations/', $file_name);
      if ($move) {
        $field->image_name = $file_name;
        $field->image_path = 'uploads/destinations/' . $file_name;
      } else {
        session()->flash('emsg', 'Some problem occured. File not uploaded.');
      }
    }
    $field->page_name = $request['page_name'];
    $field->slug = slugify($request['slug']);
    $field->country = $request['country'];
    $field->author_id = $request['author_id'];
    $field->course_duration = $request['course_duration'];
    $field->neet = $request['neet'];
    $field->english_profiency_exam = $request['english_profiency_exam'];
    $field->intake = $request['intake'];
    $field->eligibility = $request['eligibility'];
    $field->medium_of_teaching = $request['medium_of_teaching'];
    $field->top_description = $request['top_description'];
    $field->meta_title = $request['meta_title'];
    $field->meta_keyword = $request['meta_keyword'];
    $field->meta_description = $request['meta_description'];
    $field->page_content = $request['page_content'];
    $field->seo_rating = $request['seo_rating'];
    $field->save();
    session()->flash('smsg', 'Record has been updated successfully.');
    return redirect('admin/destinations');
  }
}
