<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\DynamicPageGallery;
use Illuminate\Http\Request;

class DynamicPageGalleryC extends Controller
{
  public function index($page_id, $id = null)
  {
    $rows = DynamicPageGallery::where('page_id', $page_id);
    $rows = $rows->get();
    if ($id != null) {
      $sd = DynamicPageGallery::find($id);
      if (!is_null($sd)) {
        $ft = 'edit';
        $url = url('admin/dynamic-page-gallery/update/' . $id);
        $title = 'Update';
      } else {
        return redirect('admin/dynamic-page-gallery');
      }
    } else {
      $ft = 'add';
      $url = url('admin/dynamic-page-gallery/store');
      $title = 'Add New';
      $sd = '';
    }
    $page_title = "Dynamic Page Gallery";
    $page_route = "dynamic-page-gallery";
    $data = compact('rows', 'sd', 'ft', 'url', 'title', 'page_title', 'page_route');
    return view('admin.dynamic-page-gallery')->with($data);
  }
  public function store(Request $request)
  {
    // printArray($request->all());
    // die;
    $request->validate(
      [
        'title' => 'required',
        'photo.*' => 'required|max:5000|mimes:jpg,jpeg,png,gif',
      ],
      [
        'photo.*.required' => 'Please upload an image',
        'photo.*.mimes' => 'Only jpg, jpeg, png and gif images are allowed',
        'photo.*.max' => 'Sorry! Maximum allowed size for an image is 5MB',
      ]
    );
    if ($request->hasFile('photo')) {
      foreach ($request->file('photo') as $key => $file) {
        $field = new DynamicPageGallery;
        $field->page_id = $request['page_id'];
        $field->title = $request['title'];
        $fileOriginalName = $file->getClientOriginalName();
        $fileNameWithoutExtention = pathinfo($fileOriginalName, PATHINFO_FILENAME);
        $file_name_slug = slugify($fileNameWithoutExtention);
        $file_name = $file_name_slug . '-' . time() . '.' . $file->getClientOriginalExtension();
        $move = $file->move('uploads/destinations/', $file_name);
        if ($move) {
          $field->image_name = $file_name;
          $field->image_path = 'uploads/destinations/' . $file_name;
        } else {
          session()->flash('emsg', 'Images not uploaded.');
        }
        $field->save();
      }
    }
    session()->flash('smsg', 'New record has been added successfully.');
    return redirect('admin/dynamic-page-gallery/' . $request['page_id']);
  }
  public function delete($id)
  {
    //echo $id;
    echo $result = DynamicPageGallery::find($id)->delete();
  }
  public function update($id, Request $request)
  {
    $request->validate(
      [
        'title' => 'required',
        'photo' => 'nullable|max:5000|mimes:jpg,jpeg,png,gif',
      ]
    );
    $field = DynamicPageGallery::find($id);
    if ($request->hasFile('photo')) {
      $fileOriginalName = $request->file('photo')->getClientOriginalName();
      $fileNameWithoutExtention = pathinfo($fileOriginalName, PATHINFO_FILENAME);
      $file_name_slug = slugify($fileNameWithoutExtention);
      $fileExtention = $request->file('photo')->getClientOriginalExtension();
      $file_name = $file_name_slug . '_' . time() . '.' . $fileExtention;
      $move = $request->file('photo')->move('uploads/destinations/', $file_name);
      if ($move) {
        $field->image_name = $file_name;
        $field->image_path = 'uploads/destinations/' . $file_name;
      } else {
        session()->flash('emsg', 'Some problem occured. File not uploaded.');
      }
    }
    $field->title = $request['title'];
    $field->save();
    session()->flash('smsg', 'Record has been updated successfully.');
    return redirect('admin/dynamic-page-gallery/' . $request['page_id']);
  }
}
