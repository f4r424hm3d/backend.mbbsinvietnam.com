<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommonController extends Controller
{
  public function getSubStatusByStatus(Request $request)
  {
    //echo $id;
    $field = DB::table('lead_sub_statuses')->where('status_id', $request['status_id'])->get();
    $output = '<option value="">Select</option>';
    foreach ($field as $row) {
      $output .= '<option value="' . $row->id . '">' . $row->sub_status . '</option>';
    }
    echo $output;
  }
  public function changeStatus(Request $request)
  {
    echo $result = DB::table($request->tbl)->where('id', $request->id)->update(['status' => $request->val]);
  }
  public function updateField(Request $request)
  {
    echo $result = DB::table($request->tbl)->whereIn('id', $request->ids)->update([$request->col => $request->val]);
  }
  public function updateFieldById(Request $request)
  {
    echo $result = DB::table($request->tbl)->where('id', $request->id)->update([$request->col => $request->val]);
  }
  public function updateBulkField(Request $request)
  {
    echo $result = DB::table($request->tbl)->whereIn('id', $request->ids)->update([$request->col => $request->val]);
  }
  public function getCountryByDestination(Request $request)
  {
    //echo $id;
    $field = DB::table('destinations')->where('id', $request['destination_id'])->first();
    $output = $field->country;
    echo $output;
  }
  public function slugifyString(Request $request)
  {
    $output = slugify($request->val);
    echo $output;
  }
  public function convert_currecy(Request $request)
  {
    //echo "Hello";
    //die;
    if ($_REQUEST) {
      $from = strtoupper($_REQUEST['from']);
      $to = strtoupper($_REQUEST['to']);
      $amount = $_REQUEST['amount'];
      //echo $from . ' , ' . $to . ' , ' . $amount;
      $api_url = "https://api.getgeoapi.com/v2/currency/convert?api_key=3c10af8cae94eaf3650ba0b9edb97d1eef23505e&from=" . $from . "&to=" . $to . "&amount=" . $amount . "&format=json";

      $client = curl_init($api_url);

      curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

      $response = curl_exec($client);
      curl_close($client);

      echo $response;
      // $result = json_decode($response);
      // // echo "<pre>";
      // // print_r($result);
      // // echo "</pre>";
      // $rslt = $result->amount . ' ' . $result->base_currency_code . ' = ' . $result->rates->$to->rate_for_amount . ' ' . $to;
      // echo $rslt;
    } else {
      echo "Please fill all the information";
    }
  }

}
