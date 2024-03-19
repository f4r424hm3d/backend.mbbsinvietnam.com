<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceC extends Controller
{
  public function index($id = null)
  {
    $rows = Service::get();
    if ($id != null) {
      $sd = Service::find($id);
      if (!is_null($sd)) {
        $ft = 'edit';
        $url = url('admin/services/update/' . $id);
        $title = 'Update';
      } else {
        return redirect('admin/services');
      }
    } else {
      $ft = 'add';
      $url = url('admin/services/store');
      $title = 'Add New';
      $sd = '';
    }
    $page_title = "Service";
    $page_route = "services";
    $data = compact('rows', 'sd', 'ft', 'url', 'title', 'page_title', 'page_route');
    return view('admin.services')->with($data);
  }
  public function store(Request $request)
  {
    // printArray($request->all());
    // die;
    $request->validate(
      [
        'service_name' => 'required|unique:services,service_name',
      ]
    );
    $field = new Service;
    if ($request->hasFile('thumbnail')) {
      $fileOriginalName = $request->file('thumbnail')->getClientOriginalName();
      $fileNameWithoutExtention = pathinfo($fileOriginalName, PATHINFO_FILENAME);
      $file_name_slug = slugify($fileNameWithoutExtention);
      $fileExtention = $request->file('thumbnail')->getClientOriginalExtension();
      $file_name = $file_name_slug . '_' . time() . '.' . $fileExtention;
      $move = $request->file('thumbnail')->move('uploads/services/', $file_name);
      if ($move) {
        $field->image_name = $file_name;
        $field->image_path = 'uploads/services/' . $file_name;
      } else {
        session()->flash('emsg', 'Some problem occured. File not uploaded.');
      }
    }
    $field->service_name = $request['service_name'];
    $field->service_slug = slugify($request['service_slug'] ?? $request['service_name']);
    $field->description = $request['description'];
    $field->meta_title = $request['meta_title'];
    $field->meta_keyword = $request['meta_keyword'];
    $field->meta_description = $request['meta_description'];
    $field->page_content = $request['page_content'];
    //$field->seo_rating = $request['seo_rating'];
    $field->save();
    session()->flash('smsg', 'New record has been added successfully.');
    return redirect('admin/services');
  }
  public function delete($id)
  {
    //echo $id;
    echo $result = Service::find($id)->delete();
  }
  public function update($id, Request $request)
  {
    $request->validate(
      [
        'service_name' => 'required|unique:services,service_name,' . $id
      ]
    );
    $field = Service::find($id);
    if ($request->hasFile('thumbnail')) {
      $fileOriginalName = $request->file('thumbnail')->getClientOriginalName();
      $fileNameWithoutExtention = pathinfo($fileOriginalName, PATHINFO_FILENAME);
      $file_name_slug = slugify($fileNameWithoutExtention);
      $fileExtention = $request->file('thumbnail')->getClientOriginalExtension();
      $file_name = $file_name_slug . '_' . time() . '.' . $fileExtention;
      $move = $request->file('thumbnail')->move('uploads/services/', $file_name);
      if ($move) {
        $field->image_name = $file_name;
        $field->image_path = 'uploads/services/' . $file_name;
      } else {
        session()->flash('emsg', 'Some problem occured. File not uploaded.');
      }
    }
    $field->service_name = $request['service_name'];
    $field->service_slug = slugify($request['service_slug'] ?? $request['service_name']);
    $field->description = $request['description'];
    $field->meta_title = $request['meta_title'];
    $field->meta_keyword = $request['meta_keyword'];
    $field->meta_description = $request['meta_description'];
    $field->page_content = $request['page_content'];
    $field->save();
    session()->flash('smsg', 'Record has been updated successfully.');
    return redirect('admin/services');
  }
}
