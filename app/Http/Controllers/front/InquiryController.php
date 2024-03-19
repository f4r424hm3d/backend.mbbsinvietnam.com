<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Mail;
use App\Models\Country;
use App\Models\Lead;
use App\Models\Service;
use App\Models\Treatment;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
  public function submitContactUs(Request $request)
  {
    // printArray($request->toArray());
    // die;
    $request->validate(
      [
        'g-recaptcha-response' => 'required',
        'service_id' => 'required|numeric',
        'name' => 'required',
        'mobile' => 'required|numeric',
        'email' => 'required|email',
        'message' => [
          'required',
          'string',
          'max:500', // You can adjust the max length as needed
          'regex:/^[a-zA-Z0-9\s!@#$%^&*(),.?:"{}|<>]+$/',
        ],
      ]
    );
    $field = new Lead();
    $field->name = $request['name'];
    $field->mobile = $request['mobile'];
    $field->email = $request['email'];
    $field->message = $request['message'];
    $field->source = $request['source'];
    $field->source_path = $request['source_path'];
    $field->save();
    session()->flash('smsg', 'Your inquiry has been submitted succesfully. We will contact you soon.');

    $emaildata = [
      'name' => $request['name'],
      'email' => $request['email'],
      'mobile' => $request['mobile'],
      'inquiry_message' => $request['message'],
      'source' => $request['source'],
      'source_path' => $request['source_path'],
    ];
    $dd = ['to' => $request['email'], 'to_name' => $request['name'], 'subject' => 'Inquiry'];

    Mail::send(
      'mails.inquiry-reply',
      $emaildata,
      function ($message) use ($dd) {
        $message->to($dd['to'], $dd['to_name']);
        $message->subject($dd['subject']);
        $message->priority(1);
      }
    );

    $dd2 = ['to' => TO_EMAIL, 'cc' => CC_EMAIL, 'to_name' => TO_NAME, 'cc_name' => CC_NAME, 'subject' => 'New Inquiry'];

    Mail::send(
      'mails.inquiry-mail-to-team',
      $emaildata,
      function ($message) use ($dd2) {
        $message->to($dd2['to'], $dd2['to_name']);
        $message->cc($dd2['cc'], $dd2['cc_name']);
        $message->subject($dd2['subject']);
        $message->priority(1);
      }
    );

    // $api_url = "https://www.tutelagestudy.com/crm/Api/submitInquiryFromTutelageWeb";
    // $form_data = $emaildata;
    // //echo json_encode($form_data, true);
    // $client = curl_init($api_url);
    // curl_setopt($client, CURLOPT_POST, true);
    // curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);
    // curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
    // $response = curl_exec($client);
    // curl_close($client);

    return redirect('thank-you');
  }
  public function appointment(Request $request)
  {
    // printArray($request->toArray());
    // die;
    $request->validate(
      [
        'g-recaptcha-response' => 'required',
        'service_id' => 'required|numeric',
        'appointment_date' => 'required|date',
        'name' => 'required',
        'mobile' => 'required|numeric',
        'email' => 'required|email',
        'message' => [
          'required',
          'string',
          'max:500', // You can adjust the max length as needed
          'regex:/^[a-zA-Z0-9\s!@#$%^&*(),.?:"{}|<>]+$/',
        ],
      ]
    );
    $field = new Lead();
    $field->name = $request['name'];
    $field->mobile = $request['mobile'];
    $field->email = $request['email'];
    $field->message = $request['message'];
    $field->source = $request['source'];
    $field->source_path = $request['source_path'];
    $field->service_id = $request['service_id'];
    $field->appointment_date = $request['appointment_date'];
    $field->type = 'inquiry';
    $field->save();
    session()->flash('smsg', 'Your inquiry has been submitted succesfully. We will contact you soon.');

    $tr = Service::find($request['service_id']);

    $emaildata = [
      'name' => $request['name'],
      'email' => $request['email'],
      'mobile' => $request['mobile'],
      'inquiry_message' => $request['message'],
      'source' => $request['source'],
      'source_path' => $request['source_path'],
      'service' => $tr->service_name,
    ];
    $dd = ['to' => $request['email'], 'to_name' => $request['name'], 'subject' => 'Service Inquiry'];

    Mail::send(
      'mails.inquiry-reply',
      $emaildata,
      function ($message) use ($dd) {
        $message->to($dd['to'], $dd['to_name']);
        $message->subject($dd['subject']);
        $message->priority(1);
      }
    );

    $dd2 = ['to' => TO_EMAIL, 'cc' => CC_EMAIL, 'to_name' => TO_NAME, 'cc_name' => CC_NAME, 'subject' => 'New Appointment Request'];

    Mail::send(
      'mails.appointment-mail-to-team',
      $emaildata,
      function ($message) use ($dd2) {
        $message->to($dd2['to'], $dd2['to_name']);
        $message->cc($dd2['cc'], $dd2['cc_name']);
        $message->subject($dd2['subject']);
        $message->priority(1);
      }
    );

    // $api_url = "https://www.tutelagestudy.com/crm/Api/submitInquiryFromTutelageWeb";
    // $form_data = $emaildata;
    // //echo json_encode($form_data, true);
    // $client = curl_init($api_url);
    // curl_setopt($client, CURLOPT_POST, true);
    // curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);
    // curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
    // $response = curl_exec($client);
    // curl_close($client);

    return redirect('thank-you');
  }

  public function thankyou(Request $request)
  {
    $title = 'Thank You';
    $page_url = url()->current();

    $countries = Country::orderBy('name', 'asc')->get();
    $phonecodes = Country::select('phonecode', 'name')->distinct()->orderBy('phonecode', 'asc')->get();

    $data = compact('title', 'page_url', 'countries', 'phonecodes',);
    return view('front.thank-you')->with($data);
  }
}
