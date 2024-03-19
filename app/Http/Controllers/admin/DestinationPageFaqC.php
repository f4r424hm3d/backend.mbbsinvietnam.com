<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\DestinationPageFaq;
use Illuminate\Http\Request;

class DestinationPageFaqC extends Controller
{
  public function index($page_id,$id = null)
  {
    $rows = DestinationPageFaq::where('page_id',$page_id);
    $rows = $rows->get();
    if ($id != null) {
      $sd = DestinationPageFaq::find($id);
      if (!is_null($sd)) {
        $ft = 'edit';
        $url = url('admin/destination-faq/update/' . $id);
        $title = 'Update';
      } else {
        return redirect('admin/destination-faq');
      }
    } else {
      $ft = 'add';
      $url = url('admin/destination-faq/store');
      $title = 'Add New';
      $sd = '';
    }
    $page_title = "Destination FAQ";
    $page_route = "destination-faq";
    $data = compact('rows', 'sd', 'ft', 'url', 'title', 'page_title', 'page_route');
    return view('admin.destination-faq')->with($data);
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
    $field = new DestinationPageFaq;
    $field->page_id = $request['page_id'];
    $field->question = $request['question'];
    $field->answer = $request['answer'];
    $field->save();
    session()->flash('smsg', 'New record has been added successfully.');
    return redirect('admin/destination-faq/'.$request['page_id']);
  }
  public function delete($id)
  {
    //echo $id;
    echo $result = DestinationPageFaq::find($id)->delete();
  }
  public function update($id, Request $request)
  {
    $request->validate(
      [
        'question' => 'required',
        'answer' => 'required',
      ]
    );
    $field = DestinationPageFaq::find($id);
    $field->page_id = $request['page_id'];
    $field->question = $request['question'];
    $field->answer = $request['answer'];
    $field->save();
    session()->flash('smsg', 'Record has been updated successfully.');
    return redirect('admin/destination-faq/'.$request['page_id']);
  }

}
