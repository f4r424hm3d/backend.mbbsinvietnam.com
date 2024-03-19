<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Country;
use Illuminate\Http\Request;

class AuthorC extends Controller
{
  public function index($id = null)
  {
    $countries = Country::all();
    $rows = Author::get();
    if ($id != null) {
      $sd = Author::find($id);
      if (!is_null($sd)) {
        $ft = 'edit';
        $url = url('admin/authors/update/' . $id);
        $title = 'Update';
      } else {
        return redirect('admin/authors');
      }
    } else {
      $ft = 'add';
      $url = url('admin/authors/store');
      $title = 'Add New';
      $sd = '';
    }
    $page_title = "Authors";
    $page_route = "authors";
    $data = compact('rows', 'sd', 'ft', 'url', 'title', 'page_title', 'page_route','countries');
    return view('admin.authors')->with($data);
  }
  public function store(Request $request)
  {
    // printArray($request->all());
    // die;
    $request->validate(
      [
        'name' => 'required',
        'slug' => 'required|unique:authors,slug',
        'thumbnail' => 'nullable|max:5000|mimes:jpg,jpeg,png,gif',
      ]
    );
    $field = new Author;
    if ($request->hasFile('thumbnail')) {
      $fileOriginalName = $request->file('thumbnail')->getClientOriginalName();
      $fileNameWithoutExtention = pathinfo($fileOriginalName, PATHINFO_FILENAME);
      $file_name_slug = slugify($fileNameWithoutExtention);
      $fileExtention = $request->file('thumbnail')->getClientOriginalExtension();
      $file_name = $file_name_slug . '_' . time() . '.' . $fileExtention;
      $move = $request->file('thumbnail')->move('uploads/author/', $file_name);
      if ($move) {
        $field->profile_pic = $file_name;
        $field->profile_pic_path = 'uploads/author/' . $file_name;
      } else {
        session()->flash('emsg', 'Some problem occured. File not uploaded.');
      }
    }
    $field->name = $request['name'];
    $field->slug = slugify($request['slug']);
    $field->email = $request['email'];
    $field->mobile = $request['mobile'];
    $field->shortnote = $request['shortnote'];
    $field->highlights = $request['highlights'];
    $field->education = $request['education'];
    $field->experiance = $request['experiance'];
    $field->save();
    session()->flash('smsg', 'New record has been added successfully.');
    return redirect('admin/authors');
  }
  public function delete($id)
  {
    //echo $id;
    echo $result = Author::find($id)->delete();
  }
  public function update($id, Request $request)
  {
    $request->validate(
      [
        'name' => 'required',
        'slug' => 'required|unique:authors,slug,'.$id,
        'thumbnail' => 'nullable|max:5000|mimes:jpg,jpeg,png,gif',
      ]
    );
    $field = Author::find($id);
    if ($request->hasFile('thumbnail')) {
      $fileOriginalName = $request->file('thumbnail')->getClientOriginalName();
      $fileNameWithoutExtention = pathinfo($fileOriginalName, PATHINFO_FILENAME);
      $file_name_slug = slugify($fileNameWithoutExtention);
      $fileExtention = $request->file('thumbnail')->getClientOriginalExtension();
      $file_name = $file_name_slug . '_' . time() . '.' . $fileExtention;
      $move = $request->file('thumbnail')->move('uploads/author/', $file_name);
      if ($move) {
        $field->profile_pic = $file_name;
        $field->profile_pic_path = 'uploads/author/' . $file_name;
      } else {
        session()->flash('emsg', 'Some problem occured. File not uploaded.');
      }
    }
    $field->name = $request['name'];
    $field->slug = slugify($request['slug']);
    $field->email = $request['email'];
    $field->mobile = $request['mobile'];
    $field->shortnote = $request['shortnote'];
    $field->highlights = $request['highlights'];
    $field->education = $request['education'];
    $field->experiance = $request['experiance'];
    $field->save();
    session()->flash('smsg', 'Record has been updated successfully.');
    return redirect('admin/authors');
  }
}
