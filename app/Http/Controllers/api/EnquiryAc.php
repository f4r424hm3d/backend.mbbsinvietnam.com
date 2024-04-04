<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class EnquiryAc extends Controller
{
  public function index(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required|regex:/^[a-zA-Z ]*$/',
      'email' => 'required|email',
      'mobile' => 'required|numeric',
      'intrested_program' => 'required',
    ]);

    if ($validator->fails()) {
      return response()->json([
        'error' => $validator->errors(),
      ]);
    }


    $field = new Student();
    $field->name = $request['name'];
    $field->email = $request['email'];
    $field->mobile = $request['mobile'];
    $field->intrested_program = $request['intrested_program'];
    $field->state = $request['state'];
    $field->save();

    $emaildata = ['name' => $request['name'], 'email' => $request['email'], 'mobile' => $request['mobile'], 'intrested_program' => $request['intrested_program'], 'state' => $request['state']];

    $dd = ['to' => $request['email'], 'to_name' => $request['name'], 'subject' => 'MBBS in Vietnam'];

    Mail::send(
      'mails.inquiry-reply',
      $emaildata,
      function ($message) use ($dd) {
        $message->to($dd['to'], $dd['to_name']);
        $message->subject($dd['subject']);
        $message->priority(1);
      }
    );

    $msg = 'Enquiry submitted successfully.';
    return response()->json(['message' => $msg, 'status' => 'success']);
  }
}
