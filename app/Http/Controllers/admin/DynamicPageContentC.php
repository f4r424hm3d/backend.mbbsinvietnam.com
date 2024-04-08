<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\DynamicPageContents;
use Illuminate\Http\Request;

class DynamicPageContentC extends Controller
{
  public function index($page_id, $id = null)
  {
    $rows = DynamicPageContents::where('page_id', $page_id);
    $rows = $rows->orderBy('priority', 'ASC')->get();
    if ($id != null) {
      $sd = DynamicPageContents::find($id);
      if (!is_null($sd)) {
        $ft = 'edit';
        $url = url('admin/dynamic-page-content/update/' . $id);
        $title = 'Update';
      } else {
        return redirect('admin/dynamic-page-content');
      }
    } else {
      $ft = 'add';
      $url = url('admin/dynamic-page-content/store');
      $title = 'Add New';
      $sd = '';
    }
    $page_title = "Dynamic Page Contents";
    $page_route = "dynamic-page-content";
    $data = compact('rows', 'sd', 'ft', 'url', 'title', 'page_title', 'page_route');
    return view('admin.dynamic-page-content')->with($data);
  }
  public function store(Request $request)
  {
    // printArray($request->all());
    // die;
    $request->validate(
      [
        'page_id' => 'required',
        'title' => 'required',
        'tab_content' => 'required',
      ]
    );
    $field = new DynamicPageContents;
    $field->page_id = $request['page_id'];
    $field->title = $request['title'];
    $field->tab_content = $request['tab_content'];
    $field->save();
    session()->flash('smsg', 'New record has been added successfully.');
    return redirect('admin/dynamic-page-content/' . $request['page_id'] . '/' . $request['tab_id']);
  }
  public function delete($id)
  {
    //echo $id;
    echo $result = DynamicPageContents::find($id)->delete();
  }
  public function update($id, Request $request)
  {
    $request->validate(
      [
        'page_id' => 'required',
        'title' => 'required',
        'tab_content' => 'required',
      ]
    );
    $field = DynamicPageContents::find($id);
    $field->page_id = $request['page_id'];
    $field->title = $request['title'];
    $field->tab_content = $request['tab_content'];
    $field->save();
    session()->flash('smsg', 'Record has been updated successfully.');
    return redirect('admin/dynamic-page-content/' . $request['page_id']);
  }
}
