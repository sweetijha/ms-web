<?php

namespace App\Http\Controllers;
//require 'vendor/autoload.php';
use Illuminate\Http\Request;
use DB;
use Intervention\Image\ImageManagerStatic as Image;


class OrderController extends Controller
{
    public function GetOrder(Request $request){


    $getorder=DB::table('order_list')->join('user_profile','user_profile.user_id','order_list.order_id')->where('order_list.phone','=','user_profile.phone')->select('*')->get();

    echo json_encode($getorder);

    }

    public function add_order(Request $request){
      date_default_timezone_set('America/Los_Angeles');
      $date = $request->date;
      $phone = $request->phone;
      $name = $request->name;
      $email = $request->email;
      $shopping_list = $request->shopping_list;
      $status = $request->status;
      $isAdmin = $request->is_admin;

      if(($this->dateFormat($date) < date('Y-m-d') ||
      ($this->dateFormat($date) <= date('Y-m-d') && date('H:i')>date("13:15"))) && !($isAdmin?1:0)){
        $RESPONSE['error'] = true;
        $RESPONSE['message'] = 'Cut-off Time For This Date Has Passed';
      }else{
        $getData = DB::table('order_list')->where('date',$date)->where('phone',$phone)->get();

        if(sizeof($getData)>0){
          $data = [
            "shopping_list" => $shopping_list,
            "status" => $status
          ];
          // return $getData;
          if($getData[0]->status == 'update'){
            $orderMsg = 'Your Updated Order Is Placed Successfully';
          }else{
            $orderMsg = 'Your Order Is Placed Successfully';
          }
          $insertData = DB::table('order_list')->where('order_id',($getData[0]->order_id))->update($data);
          if($insertData){
            if($status == 'save'){
              $RESPONSE['message'] = 'Order Saved Successfully';
            }else if($status == 'ordered'){
              $RESPONSE['message'] = $orderMsg;
            }else if($status == 'update'){
              $RESPONSE['message'] = 'Order Updated Successfully';
            }
            $RESPONSE['error'] = false;
          }else{
            $RESPONSE['error'] = true;
            if($status == 'save'){
              $RESPONSE['message'] = 'Order Saved Successfully';
            }else if($status == 'ordered'){
              $RESPONSE['message'] = 'Your Order Is Already Placed';
            }else if($status == 'update'){
              $RESPONSE['message'] = 'Order Updated Successfully';
            }
          }
        }else{
          $data = array(
            "date" => $date,
            "phone" => $phone,
            "name" => $name,
            "email_id" => $email,
            "shopping_list" => $shopping_list,
            "status" => $status
          );

          $insertData = DB::table('order_list')->insertGetId($data);

          if($insertData){
            $RESPONSE['error'] = false;
            $RESPONSE['message'] = 'Order Added';
          }else{
            $RESPONSE['error'] = true;
            $RESPONSE['message'] = 'Order Not Added';
          }
        }
      }


      return $RESPONSE;
    }
    public function update_status(Request $request){
      $order_id = $request->order_id;
      $date = $request->date;
      $shopping_list = $request->shopping_list;
      $status = $request->status;

      $data = [
        "date" => $date,
        "shopping_list" => $shopping_list,
        "status" => $status
      ];

      $insertData = DB::table('order_list')->where('order_id',$order_id)->update($data);

      if($insertData){
        $RESPONSE['error'] = false;
        $RESPONSE['message'] = 'Order Updated';
      }else{
        $RESPONSE['error'] = true;
        $RESPONSE['message'] = 'Order Not Updated';
      }
      return $RESPONSE;
    }

    public function get_order(Request $request){
      date_default_timezone_set('America/Los_Angeles');
      $date = $request->date;
      $phone = $request->phone;
      $isAdmin = $request->is_admin;

      if(($this->dateFormat($date) < date('Y-m-d') ||
      ($this->dateFormat($date) <= date('Y-m-d') && date('H:i')>date("13:15"))) && !$isAdmin){
        $RESPONSE['disable'] = true;
        if($this->dateFormat($date) == date('Y-m-d') && date('H:i')>date("13:15")){
          $getData = DB::table('order_list')->where('date',$date)->where('phone',$phone)->get();

          if(sizeof($getData)>0){
            $data = [
              "status" => 'ordered'
            ];
            $insertData = DB::table('order_list')->where('order_id',($getData[0]->order_id))->update($data);
            if($insertData){
              $RESPONSE['error'] = false;
              $RESPONSE['message'] = 'Order Added';
            }else{
              $RESPONSE['error'] = true;
              $RESPONSE['message'] = 'Order Not Added';
            }
          }
        }
      }else{
        $RESPONSE['disable'] = false;
      }

      $getData = DB::table('order_list')->where('date',$date)->where('phone',$phone)->get();

      if(sizeof($getData)>0){
        $RESPONSE['error'] = false;
        $RESPONSE['data'] = $getData[0];
      }else{
        $RESPONSE['error'] = true;
        $RESPONSE['message'] = 'Data not found';
      }
      $RESPONSE['current_time'] = date('H:i:s');
      return $RESPONSE;
    }

    public function check_date_time(Request $request){
      date_default_timezone_set('America/Los_Angeles');

      $RESPONSE['year'] = date('Y');
      $RESPONSE['month'] = date('m');
      $RESPONSE['month_in_word'] = $this->monthFormat(date('m'));
      $RESPONSE['date'] = date('d');
      $RESPONSE['hour'] = date('H');
      $RESPONSE['minute'] = date('i');
      $RESPONSE['second'] = date('s');

      return $RESPONSE;

    }

    public function dateFormat($date){
      date_default_timezone_set('America/Los_Angeles');
      $data = explode('-', $date);
      $month;
      switch($data[1]){
        case 'Jan' : $month = '01';break;
        case 'Feb' : $month = '02';break;
        case 'Mar' : $month = '03';break;
        case 'Apr' : $month = '04';break;
        case 'May' : $month = '05';break;
        case 'Jun' : $month = '06';break;
        case 'Jul' : $month = '07';break;
        case 'Aug' : $month = '08';break;
        case 'Sep' : $month = '09';break;
        case 'Oct' : $month = '10';break;
        case 'Nov' : $month = '11';break;
        case 'Dec' : $month = '12';break;

      }
      return date($data[2].'-'.$month.'-'.$data[0]);
    }

    public function mmddyyyy($date){
      date_default_timezone_set('America/Los_Angeles');
      $data = explode('-', $date);
      $month;
      switch($data[1]){
        case 'Jan' : $month = '01';break;
        case 'Feb' : $month = '02';break;
        case 'Mar' : $month = '03';break;
        case 'Apr' : $month = '04';break;
        case 'May' : $month = '05';break;
        case 'Jun' : $month = '06';break;
        case 'Jul' : $month = '07';break;
        case 'Aug' : $month = '08';break;
        case 'Sep' : $month = '09';break;
        case 'Oct' : $month = '10';break;
        case 'Nov' : $month = '11';break;
        case 'Dec' : $month = '12';break;

      }
      return date($month.'/'.$data[0].'/'.$data[2]);
    }

    public function monthFormat($m){
      switch($m){
        case '01' : $month = 'Jan';break;
        case '02' : $month = 'Feb';break;
        case '03' : $month = 'Mar';break;
        case '04' : $month = 'Apr';break;
        case '05' : $month = 'May';break;
        case '06' : $month = 'Jun';break;
        case '07' : $month = 'Jul';break;
        case '08' : $month = 'Aug';break;
        case '09' : $month = 'Sep';break;
        case '10' : $month = 'Oct';break;
        case '11' : $month = 'Nov';break;
        case '12' : $month = 'Dec';break;

      }
      return $month;
    }

    public function send_mail(Request $request){
      date_default_timezone_set('America/Los_Angeles');
      $msg = $request->msg;
      $from = 'work@myshoperoo.com';
      $email = $request->email;
      $name = $request->name;
      $phone = $request->phone;
      $company_code = $request->company_code;
      $date = $request->date;
      $time = date('H:i:s');
      $current_date = date('m/d/Y');
      if(!$company_code){
      $subject = '999-'.$phone.' '.$this->mmddyyyy($date).' Order Details';
      }
      else{
      $subject = $company_code.'-'.$phone.' '.$this->mmddyyyy($date).' MyShoperoo Order Details';
      }

      // $subject = 'Order from My Shoperoo';
      $message = 'Dear '.$name.',

Thank you for using MyShoperoo @Work as your Shopping Concierge. Please find details about your order below:

Order Placed on: '.date('m/d/Y H:i:s').'

Order for: '.$this->mmddyyyy($date).'

Order Details: '.$msg.'

If you need to send us any pictures or updates to this order, feel free to reply to this email.

Regards,
MyShoperoo @Work';
      // $message = "Hi mohit
      //
      // Your order is confirmed.
      //
      // 1.Dog food
      // 2. Biscuits";
      $headers = "From: ".$from . "\r\n" .
"BCC: krisvanka@gmail.com";

      // send email
      if(mail("work@myshoperoo.com,".$email,$subject,$message, $headers)){
        $RESPONSE['error'] = false;

      }else{
        $RESPONSE['error'] = true;
      }
      return $RESPONSE;

    }



    public function send_sms(Request $request){
      // $msg = $request->msg;
      // $from = 'work@myshoperoo.com';
      // $email = $request->email;
      // $name = $request->name;
      // $phone = '+1'.$request->phone;
      // $date = $request->date;
      // $time = date('H:i:s');
      //
      // $key = "59bb3db3-34c8-4d21-846c-cbf85813ad94";
      // $secret = "Nr3BgGU0s0+I/dPtKGM4lw==";
      // $user = "application\\" . $key . ":" . $secret;
      // $message = array("message"=>"Hello ".$name.", \nYour order is confirmed.\n\nOrder Details:\n".$msg."\n\nOrder date: ".$date."\n\nThanks\nMyShoperoo @work");
      // $data = json_encode($message);
      // $ch = curl_init('https://messagingapi.sinch.com/v1/sms/' . $phone);
      // curl_setopt($ch, CURLOPT_POST, true);
      // curl_setopt($ch, CURLOPT_USERPWD,$user);
      // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
      // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      // curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
      // $result = curl_exec($ch);
      // if(curl_errno($ch)) {
      // } else {
      // }
      // curl_close($ch);
      // echo $phone;
    }

    public function md5convert(){
      $aa = DB::table('user_profile')->get();
      for($i=0;$i<sizeof($aa);$i++){
        // $aaa = $aa[$i]->password.'\n';
        // echo $aaa;
        DB::table('user_profile')->where('user_id',$aa[$i]->user_id)->update(['password'=>md5($aa[$i]->password)]);
      }
    }

    public function send_reminder_message(Request $request){
      $status = $request->status;
      $date = $request->date;
      $phone = [];
      $message = '';
      $email = [];
      if($status == 'save' || $status == 'update'){
        $message = 'This is auto message from MyShoperoo - please finalize and submit your order before 1pm cut-off for processing today.';
      }
      else{
        $message = 'This is auto message from MyShoperoo - we are processing your order placed for today.';
      }
      //$date = $this->dateFormatReverse(date('Y-m-d'));
      $getAllTodayData = DB::table('order_list')->select('*')->where('date',$date)->where('status',$status)->get();

      for($i=0;$i<sizeof($getAllTodayData);$i++){
        // $phone .= '+1'.$getAllTodayData[$i]->phone.',';
        array_push($phone, ('+1'.$getAllTodayData[$i]->phone));
        array_push($email, ($getAllTodayData[$i]->email_id));
        $url = "http://dev.myshoperoo.com/twilio/public/sms?phone=" . urlencode('+1'.$getAllTodayData[$i]->phone)."&message=".urlencode($message);
        // return $url;
        $cSession = curl_init();
        //step2
        curl_setopt($cSession,CURLOPT_URL,$url);
        curl_setopt($cSession,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($cSession,CURLOPT_HEADER, false);
        //step3
        $result=curl_exec($cSession);
        //step4
        curl_close($cSession);
        //step5
        echo $result;
      }
      $emailIds = '';
      if(sizeof($email)>0){
        for($j=0;$j<sizeof($email)-1;$j++){
          $emailIds .= $email[$j].',';
        }
        $emailIds .= $email[$j];

      }

      $RESPONSE['date'] = $date;
      $RESPONSE['phone'] = $phone;
      return $RESPONSE;
    }
    public function dateFormatReverse($date){
      date_default_timezone_set('America/Los_Angeles');
      $data = explode('-', $date);
      $month = '';
      switch($data[1]){
        case '01' : $month = 'Jan';break;
        case '02' : $month = 'Feb';break;
        case '03' : $month = 'Mar';break;
        case '04' : $month = 'Apr';break;
        case '05' : $month = 'May';break;
        case '06' : $month = 'Jun';break;
        case '07' : $month = 'Jul';break;
        case '08' : $month = 'Aug';break;
        case '09' : $month = 'Sep';break;
        case '10' : $month = 'Oct';break;
        case '11' : $month = 'Nov';break;
        case '12' : $month = 'Dec';break;

      }
      return $data[2].'-'.$month.'-'.$data[0];
    }

}
