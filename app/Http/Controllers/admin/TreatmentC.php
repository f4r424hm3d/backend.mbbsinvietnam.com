<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Treatment;
use Illuminate\Http\Request;

class TreatmentC extends Controller
{
  public function index($id = null)
  {
    $rows = Treatment::get();
    if ($id != null) {
      $sd = Treatment::find($id);
      if (!is_null($sd)) {
        $ft = 'edit';
        $url = url('admin/treatments/update/' . $id);
        $title = 'Update';
      } else {
        return redirect('admin/treatments');
      }
    } else {
      $ft = 'add';
      $url = url('admin/treatments/store');
      $title = 'Add New';
      $sd = '';
    }
    $page_title = "Treatment";
    $page_route = "treatments";
    $data = compact('rows', 'sd', 'ft', 'url', 'title', 'page_title', 'page_route');
    return view('admin.treatments')->with($data);
  }
  public function store(Request $request)
  {
    // printArray($request->all());
    // die;
    $request->validate(
      [
        'treatment_name' => 'required|unique:treatments,treatment_name',
      ]
    );
    $field = new Treatment;
    if ($request->hasFile('thumbnail')) {
      $fileOriginalName = $request->file('thumbnail')->getClientOriginalName();
      $fileNameWithoutExtention = pathinfo($fileOriginalName, PATHINFO_FILENAME);
      $file_name_slug = slugify($fileNameWithoutExtention);
      $fileExtention = $request->file('thumbnail')->getClientOriginalExtension();
      $file_name = $file_name_slug . '_' . time() . '.' . $fileExtention;
      $move = $request->file('thumbnail')->move('uploads/treatments/', $file_name);
      if ($move) {
        $field->image_name = $file_name;
        $field->image_path = 'uploads/treatments/' . $file_name;
      } else {
        session()->flash('emsg', 'Some problem occured. File not uploaded.');
      }
    }
    $field->treatment_name = $request['treatment_name'];
    $field->treatment_slug = slugify($request['treatment_slug'] ?? $request['treatment_name']);
    $field->description = $request['description'];
    $field->meta_title = $request['meta_title'];
    $field->meta_keyword = $request['meta_keyword'];
    $field->meta_description = $request['meta_description'];
    $field->page_content = $request['page_content'];
    //$field->seo_rating = $request['seo_rating'];
    $field->save();
    session()->flash('smsg', 'New record has been added successfully.');
    return redirect('admin/treatments');
  }
  public function delete($id)
  {
    //echo $id;
    echo $result = Treatment::find($id)->delete();
  }
  public function update($id, Request $request)
  {
    $request->validate(
      [
        'treatment_name' => 'required|unique:treatments,treatment_name,' . $id
      ]
    );
    $field = Treatment::find($id);
    if ($request->hasFile('thumbnail')) {
      $fileOriginalName = $request->file('thumbnail')->getClientOriginalName();
      $fileNameWithoutExtention = pathinfo($fileOriginalName, PATHINFO_FILENAME);
      $file_name_slug = slugify($fileNameWithoutExtention);
      $fileExtention = $request->file('thumbnail')->getClientOriginalExtension();
      $file_name = $file_name_slug . '_' . time() . '.' . $fileExtention;
      $move = $request->file('thumbnail')->move('uploads/treatments/', $file_name);
      if ($move) {
        $field->image_name = $file_name;
        $field->image_path = 'uploads/treatments/' . $file_name;
      } else {
        session()->flash('emsg', 'Some problem occured. File not uploaded.');
      }
    }
    $field->treatment_name = $request['treatment_name'];
    $field->treatment_slug = slugify($request['treatment_slug'] ?? $request['treatment_name']);
    $field->description = $request['description'];
    $field->meta_title = $request['meta_title'];
    $field->meta_keyword = $request['meta_keyword'];
    $field->meta_description = $request['meta_description'];
    $field->page_content = $request['page_content'];
    $field->save();
    session()->flash('smsg', 'Record has been updated successfully.');
    return redirect('admin/treatments');
  }
}
