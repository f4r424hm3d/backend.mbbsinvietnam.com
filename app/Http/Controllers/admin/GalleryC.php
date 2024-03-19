<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryC extends Controller
{
  public function index($id = null)
  {
    $rows = Gallery::get();
    if ($id != null) {
      $sd = Gallery::find($id);
      if (!is_null($sd)) {
        $ft = 'edit';
        $url = url('admin/gallery/update/' . $id);
        $title = 'Update';
      } else {
        return redirect('admin/gallery');
      }
    } else {
      $ft = 'add';
      $url = url('admin/gallery/store');
      $title = 'Add New';
      $sd = '';
    }
    $page_title = "Gallery";
    $page_route = "gallery";
    $data = compact('rows', 'sd', 'ft', 'url', 'title', 'page_title', 'page_route');
    return view('admin.gallery')->with($data);
  }
  public function store(Request $request)
  {
    // printArray($request->all());
    // die;
    $request->validate(
      [
        'title' => 'required',
      ]
    );
    $field = new Gallery;
    if ($request->hasFile('thumbnail')) {
      $fileOriginalName = $request->file('thumbnail')->getClientOriginalName();
      $fileNameWithoutExtention = pathinfo($fileOriginalName, PATHINFO_FILENAME);
      $file_name_slug = slugify($fileNameWithoutExtention);
      $fileExtention = $request->file('thumbnail')->getClientOriginalExtension();
      $file_name = $file_name_slug . '_' . time() . '.' . $fileExtention;
      $move = $request->file('thumbnail')->move('uploads/gallery/', $file_name);
      if ($move) {
        $field->image_name = $file_name;
        $field->image_path = 'uploads/gallery/' . $file_name;
      } else {
        session()->flash('emsg', 'Some problem occured. File not uploaded.');
      }
    }
    $field->title = $request['title'];
    $field->save();
    session()->flash('smsg', 'New record has been added successfully.');
    return redirect('admin/gallery');
  }
  public function delete($id)
  {
    echo $result = Gallery::find($id)->delete();
  }
  public function update($id, Request $request)
  {
    $request->validate(
      [
        'title' => 'required'
      ]
    );
    $field = Gallery::find($id);
    if ($request->hasFile('thumbnail')) {
      $fileOriginalName = $request->file('thumbnail')->getClientOriginalName();
      $fileNameWithoutExtention = pathinfo($fileOriginalName, PATHINFO_FILENAME);
      $file_name_slug = slugify($fileNameWithoutExtention);
      $fileExtention = $request->file('thumbnail')->getClientOriginalExtension();
      $file_name = $file_name_slug . '_' . time() . '.' . $fileExtention;
      $move = $request->file('thumbnail')->move('uploads/gallery/', $file_name);
      if ($move) {
        $field->image_name = $file_name;
        $field->image_path = 'uploads/gallery/' . $file_name;
      } else {
        session()->flash('emsg', 'Some problem occured. File not uploaded.');
      }
    }
    $field->title = $request['title'];
    $field->save();
    session()->flash('smsg', 'Record has been updated successfully.');
    return redirect('admin/gallery');
  }
}
