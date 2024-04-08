<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\DynamicPageFaq;
use Illuminate\Http\Request;

class DynamicPageFaqC extends Controller
{
  public function index($page_id, $id = null)
  {
    $rows = DynamicPageFaq::where('page_id', $page_id);
    $rows = $rows->get();
    if ($id != null) {
      $sd = DynamicPageFaq::find($id);
      if (!is_null($sd)) {
        $ft = 'edit';
        $url = url('admin/dynamic-page-faq/update/' . $id);
        $title = 'Update';
      } else {
        return redirect('admin/dynamic-page-faq');
      }
    } else {
      $ft = 'add';
      $url = url('admin/dynamic-page-faq/store');
      $title = 'Add New';
      $sd = '';
    }
    $page_title = "Dynamic Page FAQ";
    $page_route = "dynamic-page-faq";
    $data = compact('rows', 'sd', 'ft', 'url', 'title', 'page_title', 'page_route');
    return view('admin.dynamic-page-faq')->with($data);
  }
  public function store(Request $request)
  {
    // printArray($request->all());
    // die;
    $request->validate(
      [
        'question' => 'required',
        'answer' => 'required',
      ]
    );
    $field = new DynamicPageFaq;
    $field->page_id = $request['page_id'];
    $field->question = $request['question'];
    $field->answer = $request['answer'];
    $field->save();
    session()->flash('smsg', 'New record has been added successfully.');
    return redirect('admin/dynamic-page-faq/' . $request['page_id']);
  }
  public function delete($id)
  {
    //echo $id;
    echo $result = DynamicPageFaq::find($id)->delete();
  }
  public function update($id, Request $request)
  {
    $request->validate(
      [
        'question' => 'required',
        'answer' => 'required',
      ]
    );
    $field = DynamicPageFaq::find($id);
    $field->page_id = $request['page_id'];
    $field->question = $request['question'];
    $field->answer = $request['answer'];
    $field->save();
    session()->flash('smsg', 'Record has been updated successfully.');
    return redirect('admin/dynamic-page-faq/' . $request['page_id']);
  }
}
