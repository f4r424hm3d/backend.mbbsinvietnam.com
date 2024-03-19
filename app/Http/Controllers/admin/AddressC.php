<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Country;
use Illuminate\Http\Request;

class AddressC extends Controller
{
  public function index($id = null)
  {
    $countries = Country::all();
    $rows = Address::get();
    if ($id != null) {
      $sd = Address::find($id);
      if (!is_null($sd)) {
        $ft = 'edit';
        $url = url('admin/addresses/update/' . $id.'/');
        $title = 'Update';
      } else {
        return redirect('admin/addresses');
      }
    } else {
      $ft = 'add';
      $url = url('admin/addresses/store/');
      $title = 'Add New';
      $sd = '';
    }
    $page_title = "Address";
    $page_route = "addresses";
    $data = compact('rows', 'sd', 'ft', 'url', 'title', 'page_title', 'page_route','countries');
    return view('admin.addresses')->with($data);
  }
  public function store(Request $request)
  {
    // printArray($request->all());
    // die;
    $request->validate(
      [
        'country' => 'required',
      ]
    );
    $field = new Address;
    $field->country = $request['country'];
    $field->city = $request['city'];
    $field->mobile = $request['mobile'];
    $field->email = $request['email'];
    $field->address = $request['address'];
    $field->save();
    session()->flash('smsg', 'New record has been added successfully.');
    return redirect('admin/addresses');
  }
  public function delete($id)
  {
    //echo $id;
    echo $result = Address::find($id)->delete();
  }
  public function update($id, Request $request)
  {
    $request->validate(
      [
        'country' => 'required',
      ]
    );
    $field = Address::find($id);
    $field->country = $request['country'];
    $field->city = $request['city'];
    $field->mobile = $request['mobile'];
    $field->email = $request['email'];
    $field->address = $request['address'];
    $field->save();
    session()->flash('smsg', 'Record has been updated successfully.');
    return redirect('admin/addresses');
  }
}
