<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class StudentLoginAc extends Controller
{
  public function register(Request $request)
  {
    $otp = rand(1000, 9999);
    $otp_expire_at = date("YmdHis", strtotime("+5 minutes"));

    $validator = FacadesValidator::make($request->all(), [
      'name' => 'required|regex:/^[a-zA-Z ]*$/',
      'email' => 'required|email|unique:students,email',
      'c_code' => 'required|numeric',
      'mobile' => 'required|numeric',
      'password' => ['required', 'string', Password::min(8)->mixedCase()->numbers()->symbols()],
      'confirm_password' => 'required|same:password',
    ]);

    if ($validator->fails()) {
      return response()->json([
        'error' => $validator->errors(),
      ]);
    }


    $field = new Student();
    $field->name = $request['name'];
    $field->email = $request['email'];
    $field->c_code = $request['c_code'];
    $field->mobile = $request['mobile'];
    $field->password = $request['password'];
    $field->otp = $otp;
    $field->otp_expire_at = $otp_expire_at;
    $field->status = 0;
    $field->save();

    $emaildata = ['name' => $request['name'], 'otp' => $otp];
    $dd = ['to' => $request['email'], 'to_name' => $request['name'], 'subject' => 'OTP'];

    Mail::send(
      'mails.send-otp',
      $emaildata,
      function ($message) use ($dd) {
        $message->to($dd['to'], $dd['to_name']);
        $message->subject('OTP');
        $message->priority(1);
      }
    );

    $id = $field->id;
    $msg = 'An OTP has been send to your registered email address.';
    return response()->json(['message' => $msg, 'id' => $id]);
  }

  public function submitOtp(Request $request)
  {
    //printArray($request->all());
    $result = Student::find($request['id']);
    $current_time = date("YmdHis");
    if ($result->otp == $request['otp']) {
      if ($current_time > $result->otp_expire_at) {
        $otp_expire_at = date("YmdHis", strtotime("+5 minute"));
        $new_otp = rand(1000, 9999);
        $result->otp = $new_otp;
        $result->otp_expire_at = $otp_expire_at;
        $result->save();
        $msg = 'OTP expired. New OTP has been send to your email id.';
        return response()->json(['message' => $msg, 'id' => $result->id]);
      } else {
        $result->otp = null;
        $result->otp_expire_at = null;
        $result->email_verified_at = date("Y-m-d H:i:s");
        $result->email_verified = 1;
        $result->status = 1;
        $result->lead_type = 'new';
        $result->source = 'signup';
        $result->save();
        $msg = 'Email verified. Succesfully logged in.';
        return response()->json(['message' => $msg, 'id' => $result->id]);
      }
    } else {
      $msg = 'Enter incorrect OTP';
      return response()->json(['message' => $msg, 'id' => $result->id]);
    }
  }

  public function signin(Request $request)
  {
    $field = Student::whereEmail($request['email'])->first();
    if (is_null($field)) {
      $msg = 'Email address not exist.';
      return response()->json(['message' => $msg]);
    } else {
      if ($field->status == 1) {
        if ($field->password == $request['password']) {
          $lc = $field->login_count == '' ? 0 : $field->login_count + 1;
          $field->login_count = $lc;
          $field->last_login = date("Y-m-d H:i:s");
          $field->save();
          $msg = 'Succesfully logged in';
          return response()->json(['message' => $msg, 'student_id' => $field->id]);
        } else {
          $msg = 'Incorrect password entered';
          return response()->json(['message' => $msg]);
        }
      } else {
        $otp = rand(1000, 9999);
        $otp_expire_at = date("YmdHis", strtotime("+5 minutes"));

        $emaildata = ['name' => $field->name, 'otp' => $otp];
        $dd = ['to' => $field->email, 'to_name' => $field->name, 'subject' => 'Email OTP'];

        $result = Mail::send(
          'mails.send-otp',
          $emaildata,
          function ($message) use ($dd) {
            $message->to($dd['to'], $dd['to_name']);
            $message->subject($dd['subject']);
            $message->priority(1);
          }
        );
        if ($result == false) {
          $msg = 'Sorry! Please try again later';
          return response()->json(['message' => $msg]);
        } else {
          $field->otp = $otp;
          $field->otp_expire_at = $otp_expire_at;
          $field->save();
          $msg = 'An OTP has been send to your registered email address.';
          return response()->json(['message' => $msg]);
        }
      }
    }
  }


  public function forgetPassword(Request $request)
  {
    $remember_token = Str::random(45);
    $otp_expire_at = date("YmdHis", strtotime("+10 minutes"));
    $field = Student::whereEmail($request['email'])->first();
    if (is_null($field)) {
      $msg = 'Entered wrong email address. Please check.';
      return response()->json(['message' => $msg]);
    } else {

      $reset_password_link = 'https://lvoverseas.com/password/reset/?uid=' . $field->id . '&token=' . $remember_token;

      $emaildata = ['name' => $field->name, 'id' => $field->id, 'remember_token' => $remember_token,  'reset_password_link' => $reset_password_link];

      $dd = ['to' => $request['email'], 'to_name' => $field->name, 'subject' => 'Password Reset'];

      $chk = Mail::send(
        'mails.forget-password-link',
        $emaildata,
        function ($message) use ($dd) {
          $message->to($dd['to'], $dd['to_name']);
          $message->subject($dd['subject']);
          $message->priority(1);
        }
      );
      if ($chk == false) {
        $msg = 'Sorry! Please try again later';
        return response()->json(['message' => $msg]);
      } else {
        $field->remember_token = $remember_token;
        $field->otp_expire_at = $otp_expire_at;
        $field->save();
        return response()->json(['message' => 'Password reset link sent to email.']);
      }
    }
  }

  public function emailLogin(Request $request)
  {
    //printArray($request->all());
    //die;
    $id = $request['uid'];
    $remember_token = $request['token'];
    $where = ['id' => $id, 'remember_token' => $remember_token];
    $field = Student::where($where)->first();
    $current_time = date("YmdHis");
    //printArray($field->all());
    if (is_null($field)) {
      return redirect('account/invalid_link');
    } else {
      if ($current_time > $field->otp_expire_at) {
        return redirect('account/invalid_link');
      } else {
        $lc = $field->login_count == '' ? 0 : $field->login_count + 1;
        $field->login_count = $lc;
        $field->last_login = date("Y-m-d H:i:s");
        $field->remember_token = null;
        $field->otp_expire_at = null;
        $field->save();
        session()->flash('smsg', 'Succesfully logged in');
        $request->session()->put('studentLoggedIn', true);
        $request->session()->put('student_id', $field->id);
        return redirect('student/profile');
      }
    }
  }

  public function resetPassword(Request $request)
  {
    $validator = FacadesValidator::make($request->all(), [
      'new_password' => 'required|min:8',
      'confirm_new_password' => 'required|min:8|same:new_password'
    ]);

    if ($validator->fails()) {
      return response()->json([
        'error' => $validator->errors(),
      ]);
    }

    $id = $request['id'];
    $remember_token = $request['remember_token'];
    $where = ['id' => $id, 'remember_token' => $remember_token];
    $field = Student::where($where)->first();
    $current_time = date("YmdHis");
    //printArray($field->all());
    if (is_null($field)) {
      return response()->json(['message' => 'Invalid Link']);
    } else {
      if ($current_time > $field->otp_expire_at) {
        return response()->json(['message' => 'Invalid Link']);
      } else {
        $lc = $field->login_count == '' ? 0 : $field->login_count + 1;
        $field->login_count = $lc;
        $field->last_login = date("Y-m-d H:i:s");
        $field->remember_token = null;
        $field->otp_expire_at = null;
        $field->password = $request['new_password'];
        $field->save();
        $msg = 'Password change succesfully. Succesfully logged in';
        return response()->json(['message' => $msg, 'student_id' => $field->id]);
      }
    }
  }
}
