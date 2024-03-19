<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\DestinationPageTab;
use Illuminate\Http\Request;

class DestinationTabC extends Controller
{
  public function index($id = null)
  {
    $rows = DestinationPageTab::get();
    if ($id != null) {
      $sd = DestinationPageTab::find($id);
      if (!is_null($sd)) {
        $ft = 'edit';
        $url = url('admin/destination-tabs/update/' . $id);
        $title = 'Update';
      } else {
        return redirect('admin/destination-tabs');
      }
    } else {
      $ft = 'add';
      $url = url('admin/destination-tabs/store');
      $title = 'Add New';
      $sd = '';
    }
    $page_title = "Destination Page Tabs";
    $page_route = "destination-tabs";
    $data = compact('rows', 'sd', 'ft', 'url', 'title', 'page_title', 'page_route');
    return view('admin.destination-tabs')->with($data);
  }
  public function store(Request $request)
  {
    // printArray($request->all());
    // die;
    $request->validate(
      [
        'tab' => 'required|unique:destination_page_tabs,tab',
      ]
    );
    $field = new DestinationPageTab;
    $field->tab = $request['tab'];
    $field->slug = slugify($request['tab']);
    $field->save();
    session()->flash('smsg', 'New record has been added successfully.');
    return redirect('admin/destination-tabs');
  }
  public function delete($id)
  {
    //echo $id;
    echo $result = DestinationPageTab::find($id)->delete();
  }
  public function update($id, Request $request)
  {
    $request->validate(
      [
        'tab' => 'required|unique:destination_page_tabs,tab,' . $id,
      ]
    );
    $field = DestinationPageTab::find($id);
    $field->tab = $request['tab'];
    $field->slug = slugify($request['tab']);
    $field->save();
    session()->flash('smsg', 'Record has been updated successfully.');
    return redirect('admin/destination-tabs');
  }
}
