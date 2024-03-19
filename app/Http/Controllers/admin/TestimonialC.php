<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialC extends Controller
{
  public function index($id = null)
  {
    $countries = Country::all();
    $rows = Testimonial::get();
    if ($id != null) {
      $sd = Testimonial::find($id);
      if (!is_null($sd)) {
        $ft = 'edit';
        $url = url('admin/testimonials/update/' . $id);
        $title = 'Update';
      } else {
        return redirect('admin/testimonials');
      }
    } else {
      $ft = 'add';
      $url = url('admin/testimonials/store');
      $title = 'Add New';
      $sd = '';
    }
    $page_title = "Testimonials";
    $page_route = "testimonials";
    $data = compact('rows', 'sd', 'ft', 'url', 'title', 'page_title', 'page_route', 'countries');
    return view('admin.testimonials')->with($data);
  }
  public function store(Request $request)
  {
    // printArray($request->all());
    // die;
    $request->validate(
      [
        'name' => 'required',
        'thumbnail' => 'nullable|max:5000|mimes:jpg,jpeg,png,gif',
        'review' => 'required',
      ]
    );
    $field = new Testimonial;
    if ($request->hasFile('thumbnail')) {
      $fileOriginalName = $request->file('thumbnail')->getClientOriginalName();
      $fileNameWithoutExtention = pathinfo($fileOriginalName, PATHINFO_FILENAME);
      $file_name_slug = slugify($fileNameWithoutExtention);
      $fileExtention = $request->file('thumbnail')->getClientOriginalExtension();
      $file_name = $file_name_slug . '_' . time() . '.' . $fileExtention;
      $move = $request->file('thumbnail')->move('uploads/testimonial/', $file_name);
      if ($move) {
        $field->image = 'uploads/testimonial/' . $file_name;
      } else {
        session()->flash('emsg', 'Some problem occured. File not uploaded.');
      }
    }
    $field->name = $request['name'];
    $field->country = $request['country'];
    $field->review = $request['review'];
    $field->save();
    session()->flash('smsg', 'New record has been added successfully.');
    return redirect('admin/testimonials');
  }
  public function delete($id)
  {
    //echo $id;
    echo $result = Testimonial::find($id)->delete();
  }
  public function update($id, Request $request)
  {
    $request->validate(
      [
        'name' => 'required',
        'thumbnail' => 'nullable|max:5000|mimes:jpg,jpeg,png,gif',
        'review' => 'required',
      ]
    );
    $field = Testimonial::find($id);
    if ($request->hasFile('thumbnail')) {
      $fileOriginalName = $request->file('thumbnail')->getClientOriginalName();
      $fileNameWithoutExtention = pathinfo($fileOriginalName, PATHINFO_FILENAME);
      $file_name_slug = slugify($fileNameWithoutExtention);
      $fileExtention = $request->file('thumbnail')->getClientOriginalExtension();
      $file_name = $file_name_slug . '_' . time() . '.' . $fileExtention;
      $move = $request->file('thumbnail')->move('uploads/testimonial/', $file_name);
      if ($move) {
        $field->image = 'uploads/testimonial/' . $file_name;
      } else {
        session()->flash('emsg', 'Some problem occured. File not uploaded.');
      }
    }
    $field->name = $request['name'];
    $field->country = $request['country'];
    $field->review = $request['review'];
    $field->save();
    session()->flash('smsg', 'Record has been updated successfully.');
    return redirect('admin/testimonials');
  }
}
