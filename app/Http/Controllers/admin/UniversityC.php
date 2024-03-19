<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Imports\UniversityImport;
use App\Models\Country;
use App\Models\Destination;
use App\Models\InstituteType;
use App\Models\State;
use App\Models\University;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UniversityC extends Controller
{
  public function index($id = null)
  {
    // echo $request->search;
    // die;
    $authors = User::all();
    $destinations = Destination::all();

    $rows = University::with('getAuthor', 'getInstType');
    if (isset($_GET['search']) && $_GET['search'] != null) {
      $rows = $rows->where('name', 'like', '%' . $_GET['search'] . '%')->orWhere('country', 'like', '%' . $_GET['search'] . '%');
    }
    $rows = $rows->paginate(10);

    // printArray($rows->toArray());
    // die;
    $cp = $rows->currentPage();
    $pp = $rows->perPage();
    $i = ($cp - 1) * $pp + 1;

    $instType = InstituteType::all();
    $countries = Country::all();
    $states = State::all();
    if ($id != null) {
      $sd = University::find($id);
      if (!is_null($sd)) {
        $ft = 'edit';
        $url = url('admin/university/update/' . $id);
        $title = 'Update';
      } else {
        return redirect('admin/university');
      }
    } else {
      $ft = 'add';
      $url = url('admin/university/store');
      $title = 'Add New';
      $sd = '';
    }
    $page_title = "University";
    $page_route = "university";
    $data = compact('rows', 'sd', 'ft', 'url', 'title', 'page_title', 'page_route', 'instType', 'countries', 'states', 'i', 'authors', 'destinations');
    return view('admin.university')->with($data);
  }
  public function store(Request $request)
  {
    // printArray($request->all());
    // die;
    $request->validate(
      [
        'name' => 'required|unique:universities,name',
        'university_name' => 'nullable|unique:universities,university_name',
        'destination_id' => 'required',
        'logo' => 'nullable|max:5000|mimes:jpg,jpeg,png,gif',
        'banner' => 'nullable|max:5000|mimes:jpg,jpeg,png,gif'
      ]
    );
    $field = new University;
    if ($request->hasFile('logo')) {
      $fileOriginalName = $request->file('logo')->getClientOriginalName();
      $fileNameWithoutExtention = pathinfo($fileOriginalName, PATHINFO_FILENAME);
      $file_name_slug = slugify($fileNameWithoutExtention);
      $fileExtention = $request->file('logo')->getClientOriginalExtension();
      $file_name = $file_name_slug . '_' . time() . '.' . $fileExtention;
      $move = $request->file('logo')->move('uploads/university/', $file_name);
      if ($move) {
        $field->image_name = $file_name;
        $field->image_path = 'uploads/university/' . $file_name;
      } else {
        session()->flash('emsg', 'Some problem occured. File not uploaded.');
      }
    }
    if ($request->hasFile('banner')) {
      $fileOriginalName = $request->file('banner')->getClientOriginalName();
      $fileNameWithoutExtention = pathinfo($fileOriginalName, PATHINFO_FILENAME);
      $file_name_slug = slugify($fileNameWithoutExtention);
      $fileExtention = $request->file('banner')->getClientOriginalExtension();
      $file_name = $file_name_slug . '_' . time() . '.' . $fileExtention;
      $move = $request->file('banner')->move('uploads/university/', $file_name);
      if ($move) {
        $field->banner_name = $file_name;
        $field->banner_path = 'uploads/university/' . $file_name;
      } else {
        session()->flash('emsg', 'Some problem occured. File not uploaded.');
      }
    }
    if ($request->hasFile('brochure')) {
      $fileOriginalName = $request->file('brochure')->getClientOriginalName();
      $fileNameWithoutExtention = pathinfo($fileOriginalName, PATHINFO_FILENAME);
      $file_name_slug = slugify($fileNameWithoutExtention);
      $fileExtention = $request->file('brochure')->getClientOriginalExtension();
      $file_name = $file_name_slug . '_' . time() . '.' . $fileExtention;
      $move = $request->file('brochure')->move('uploads/university/', $file_name);
      if ($move) {
        $field->brochure_name = $file_name;
        $field->brochure_path = 'uploads/university/' . $file_name;
      } else {
        session()->flash('emsg', 'Some problem occured. File not uploaded.');
      }
    } else {
      $field->brochure_path = $request['brochure_path'];
    }
    $field->name = $request['name'];
    $field->slug = slugify($request['slug']);
    $field->university_name = $request['university_name'];
    $field->university_name_slug = slugify($request['university_name']);
    $field->author_id = $request['author_id'];
    $field->destination_id = $request['destination_id'];
    $field->views = $request['views'];
    $field->established_year = $request['established_year'];
    $field->country = $request['country'];
    $field->country_slug = slugify($request['country']);
    $field->rank = $request['rank'];
    $field->institute_type = $request['institute_type'];
    $field->meta_title = $request['meta_title'];
    $field->meta_keyword = $request['meta_keyword'];
    $field->meta_description = $request['meta_description'];
    $field->page_content = $request['page_content'];
    $field->top_description = $request['top_description'];
    $field->bottom_description = $request['bottom_description'];
    $field->status = 1;
    $field->save();
    session()->flash('smsg', 'New record has been added successfully.');
    return redirect('admin/university');
  }
  public function delete($id)
  {
    //echo $id;
    echo $result = University::find($id)->delete();
  }
  public function update($id, Request $request)
  {
    $request->validate(
      [
        'name' => 'required|unique:universities,name,' . $id,
        'university_name' => 'nullable|unique:universities,university_name,' . $id,
        'destination_id' => 'required',
        'logo' => 'nullable|max:5000|mimes:jpg,jpeg,png,gif',
        'banner' => 'nullable|max:5000|mimes:jpg,jpeg,png,gif'
      ]
    );

    $field = University::find($id);
    if ($request->hasFile('logo')) {
      $fileOriginalName = $request->file('logo')->getClientOriginalName();
      $fileNameWithoutExtention = pathinfo($fileOriginalName, PATHINFO_FILENAME);
      $file_name_slug = slugify($fileNameWithoutExtention);
      $fileExtention = $request->file('logo')->getClientOriginalExtension();
      $file_name = $file_name_slug . '_' . time() . '.' . $fileExtention;
      $move = $request->file('logo')->move('uploads/university/', $file_name);
      if ($move) {
        $field->image_name = $file_name;
        $field->image_path = 'uploads/university/' . $file_name;
      } else {
        session()->flash('emsg', 'Some problem occured. File not uploaded.');
      }
    }
    if ($request->hasFile('banner')) {
      $fileOriginalName = $request->file('banner')->getClientOriginalName();
      $fileNameWithoutExtention = pathinfo($fileOriginalName, PATHINFO_FILENAME);
      $file_name_slug = slugify($fileNameWithoutExtention);
      $fileExtention = $request->file('banner')->getClientOriginalExtension();
      $file_name = $file_name_slug . '_' . time() . '.' . $fileExtention;
      $move = $request->file('banner')->move('uploads/university/', $file_name);
      if ($move) {
        $field->banner_name = $file_name;
        $field->banner_path = 'uploads/university/' . $file_name;
      } else {
        session()->flash('emsg', 'Some problem occured. File not uploaded.');
      }
    }
    if ($request->hasFile('brochure')) {
      $fileOriginalName = $request->file('brochure')->getClientOriginalName();
      $fileNameWithoutExtention = pathinfo($fileOriginalName, PATHINFO_FILENAME);
      $file_name_slug = slugify($fileNameWithoutExtention);
      $fileExtention = $request->file('brochure')->getClientOriginalExtension();
      $file_name = $file_name_slug . '_' . time() . '.' . $fileExtention;
      $move = $request->file('brochure')->move('uploads/university/', $file_name);
      if ($move) {
        $field->brochure_name = $file_name;
        $field->brochure_path = 'uploads/university/' . $file_name;
      } else {
        session()->flash('emsg', 'Some problem occured. File not uploaded.');
      }
    } else {
      $field->brochure_path = $request['brochure_path'];
    }
    $field->name = $request['name'];
    $field->slug = slugify($request['slug']);
    $field->university_name = $request['university_name'];
    $field->university_name_slug = slugify($request['university_name']);
    $field->destination_id = $request['destination_id'];
    $field->author_id = $request['author_id'];
    $field->views = $request['views'];
    $field->established_year = $request['established_year'];
    $field->country = $request['country'];
    $field->country_slug = slugify($request['country']);
    $field->rank = $request['rank'];
    $field->institute_type = $request['institute_type'];
    $field->meta_title = $request['meta_title'];
    $field->meta_keyword = $request['meta_keyword'];
    $field->meta_description = $request['meta_description'];
    $field->page_content = $request['page_content'];
    $field->top_description = $request['top_description'];
    $field->bottom_description = $request['bottom_description'];
    $field->save();
    session()->flash('smsg', 'Record has been updated successfully.');
    return redirect('admin/university');
  }
  public function Import(Request $request)
  {
    // printArray($data->all());
    // die;
    $request->validate([
      'file' => 'required|mimes:xlsx,csv,xls'
    ]);
    $file = $request->file;
    if ($file) {
      try {
        $result = Excel::import(new UniversityImport, $file);
        // session()->flash('smsg', 'Data has been imported succesfully.');
        return redirect('admin/university');
      } catch (\Exception $ex) {
        dd($ex);
      }
    }
  }
}
