<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
/*class Sinch
{
    var $key = "59bb3db3-34c8-4d21-846c-cbf85813ad94";
    var $secret = "Nr3BgGU0s0+I/dPtKGM4lw==";
    var $contentType = "application/json";
    var $baseurl = "https://api.sinch.com";
    var $ch;

    public function sendCode($mobile)
    {
        $url_path = $this->encodeurl('/verification/v1/verifications');
        $this->ch = curl_init($this->baseurl . $url_path);
        $this->setupDefault();
        $this->setupSendData($mobile, $url_path);
        $return = $this->getResult();
        return $return;
    }

    public function verifyMobile($mobile, $code)
    {
        $url_path = $this->encodeurl('/verification/v1/verifications/number/' . $mobile);
        $this->ch = curl_init($this->baseurl . $url_path);
        $this->setupDefault();
        $this->setupVerifyData($code, $url_path);
        $return = $this->getResult();
        return $return;
    }

    private function setupDefault()
    {
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
    }

    private function setupVerifyData($code, $url_path)
    {
        $data = json_encode([
            'method' => 'sms',
            'sms' => [
                'code' => (string)$code
            ]
        ]);
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $data);
        $this->signedHeaders("PUT", $data, $url_path);
    }

    private function setupSendData($mobile, $url_path)
    {
        $data = json_encode([
            'identity' => [
                'type' => 'number',
                'endpoint' => $mobile,
            ],
            'method' => 'sms'
        ]);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($this->ch, CURLOPT_POST, true);
        $this->signedHeaders("POST", $data, $url_path);
    }

    private function getResult()
    {
        $result = curl_exec($this->ch);
        $return = [];
        if (curl_errno($this->ch)) {
            $return['error'] = curl_error($this->ch);
        } else {
            $return['data'] = $result;
        }
        return $result;
    }

    private function compileContentType()
    {
        return 'content-type: ' . $this->contentType;
    }

    private function signedHeaders($method, $body, $url_path)
    {
        $method = strtoupper($method);
        $date = date("c");
        $contentMd5 = base64_encode(md5(utf8_encode($body), true));
        $xTimestamp = "x-timestamp:" . $date;
        $StringToSign = $method . "\n" .
            $contentMd5 . "\n" .
            $this->contentType . "\n" .
            $xTimestamp . "\n" .
            $url_path;
        $signature = base64_encode(hash_hmac("sha256", utf8_encode($StringToSign), base64_decode($this->secret), true));
        $Authorization = 'Authorization: Application ' . $this->key . ":" . $signature;
        $headers = [
            $this->compileContentType(),
            $Authorization,
            $xTimestamp
        ];
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $headers);
    }

    private function encodeurl($url)
    {
        // $url_ = urlencode(utf8_encode($url));
        //  $url_ = str_replace("\\+", "%20", $url_);
        //  $url_ = str_replace("\\%7E", "~", $url_);
        return $url;
    }
}
*/

class UserController extends Controller
{
    public function get_otp(Request $request){
      $login_type = $request->type;
      $phone = $request->phone;

     if($login_type == 'signup'){
      $checkPhone = DB::table('user_profile')->where('phone',$phone)->count();
       if($checkPhone>0){
         $RESPONSE['error'] = true;
         $RESPONSE['message'] = 'Phone number already registered.';
        }else{
         $result = $this->sendOtpFunction($phone);
          return $result;
          if ($result) {
            $RESPONSE['error'] = false;
            $RESPONSE['message'] = 'OTP has send to your phone number.';
          }else{
            $RESPONSE['error'] = true;
            $RESPONSE['message'] = 'Failed. Try again.';
          }
        }
      }else{
       $checkPhone = DB::table('user_profile')->where('phone',$phone)->count();
        if($checkPhone==0){
          $RESPONSE['error'] = true;
         $RESPONSE['message'] = 'Phone number not registered.';
        }else{
         $result = $this->sendOtpFunction($phone);
         return $result;
          if ($result) {
           $RESPONSE['error'] = false;
            $RESPONSE['message'] = 'OTP has send to your phone number.';
          }else{
           $RESPONSE['error'] = true;
           $RESPONSE['message'] = 'Failed. Try again.';
        }
       }
      }
     return $RESPONSE;
   }

    	public function verify_otp(Request $request){
	     $otp = $request->otp;
	     $Authy_id= $request->authy_id;
    	$result = $this->verifyOtpTwilio($Authy_id, $otp);
    	return $result;
   }
	public function verifyOtpTwilio($Authy_id, $otp){

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,"https://api.authy.com/protected/json/verify/".$otp."/".$Authy_id."?api_key=Q7G5KVpoafv240Py4USxK2s6w3NXCn6u");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$server_output = curl_exec($ch);
		curl_close ($ch);
		$ob = json_decode($server_output, TRUE);
		return $ob;
		//echo $server_output;exit;
		return $server_output;
	}

    public function signup(Request $request){
      $name = $request->name;
      $phone = $request->phone;
      $email = $request->email;
      $password = md5($request->password);
      $company_code=$request->company_code;
      $unique_code =$request->unique_code;
	$device_details=$this->systemInfo();
	
	//return json_decode(json_encode($device_details),true)->device;
	if(!$unique_code && !$company_code){
		$checkEmail = DB::table('user_profile')->where('email_id',$email)->count();
		if($checkEmail>0){
		        $RESPONSE['error'] = true;
		        $RESPONSE['message'] = 'Email ID already register with another account.';
		}else{
		        $data = array(
		          "name" => $name,
		          "phone" => $phone,
		          "email_id" => $email,
		          "password" => $password,
		          "device"=>$device_details["device"],
		          "os"=>$device_details["os"]
		        );
	        $result = DB::table('user_profile')->insert($data);
	        if ($result) {
	        $company_code='';
	        $unique_code='';
	          $RESPONSE['error'] = false;
	          $RESPONSE['code'] = 1000;
	          $RESPONSE['message'] = 'Registration Successfull Without Using Company Code and/or Unique Code. Please Update In Profile.';
	          $this->send_registration_confirmation_mail($name,$phone,$email,$company_code,$unique_code);
	        }else{
	          $RESPONSE['error'] = true;
	          $RESPONSE['message'] = 'Registration failed. Try again.';
	        }
	      }
	}
	else{
	$checkEmail = DB::table('user_profile')->where('email_id',$email)->count();
	$checkuniqueCode =DB::table('user_profile')->where('company_code',$company_code)->where('unique_code',$unique_code)->count();
	$checkCodeValidation=DB::table('admin_profile')->select('company_code','unique_code')->where('company_code',$company_code)->where('unique_code',$unique_code)->get();
		if($checkEmail>0){
		        $RESPONSE['error'] = true;
		        $RESPONSE['message'] = 'Email ID already register with another account.';
		}
		else if($checkuniqueCode>0){
			$RESPONSE['error'] = true;
		        $RESPONSE['message'] = 'Company Code and/or User Code is Not Correct. Please Fix or Remove Both Codes to Proceed with Registration.';
		}
		else if(sizeof($checkCodeValidation)>0){
		if(($checkCodeValidation[0]->company_code == $company_code) && ($checkCodeValidation[0]->unique_code == $unique_code)){
		        $data = array(
		          "name" => $name,
		          "phone" => $phone,
		          "email_id" => $email,
		          "password" => $password,
		          "company_code"=> $company_code,
		          "unique_code"=> $unique_code,
		          "device"=>$device_details["device"],
		          "os"=>$device_details["os"]
		        );
		       
	        $result = DB::table('user_profile')->insert($data);
	        $updateflag= DB::table('admin_profile')->where('company_code',$company_code)->where('unique_code',$unique_code)->update(array("use_flag"=>1));
	        if ($result) {
	          $RESPONSE['error'] = false;
	          $RESPONSE['message'] = 'Registration successfully';
	          $this->send_registration_confirmation_mail($name,$phone,$email,$company_code,$unique_code); 
	        }else{
	          $RESPONSE['error'] = true;
	          $RESPONSE['message'] = 'Registration failed. Try again.';
	        }
	      }
	      else{
	     	 $RESPONSE['error'] = true;
	         $RESPONSE['message'] = 'Company Code and/or User Code is Not Correct. Please Fix or Remove Both Codes to Proceed with Registration.';
	      }
		}
		else{
			
			$RESPONSE['error'] = true;
	         	$RESPONSE['message'] = 'Company Code and/or User Code is Not Correct. Please Fix or Remove Both Codes to Proceed with Registration.';
		}

	}
	$RESPONSE['device']=$device_details;
     return $RESPONSE;
    }

public static function systemInfo()
 {
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $os_platform    = "Unknown OS Platform";
    $os_array       = array('/windows phone 8/i'    =>  'Windows Phone 8',
                            '/windows phone os 7/i' =>  'Windows Phone 7',
                            '/windows nt 6.3/i'     =>  'Windows 8.1',
                            '/windows nt 6.2/i'     =>  'Windows 8',
                            '/windows nt 6.1/i'     =>  'Windows 7',
                            '/windows nt 6.0/i'     =>  'Windows Vista',
                            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                            '/windows nt 5.1/i'     =>  'Windows XP',
                            '/windows xp/i'         =>  'Windows XP',
                            '/windows nt 5.0/i'     =>  'Windows 2000',
                            '/windows me/i'         =>  'Windows ME',
                            '/win98/i'              =>  'Windows 98',
                            '/win95/i'              =>  'Windows 95',
                            '/win16/i'              =>  'Windows 3.11',
                            '/macintosh|mac os x/i' =>  'Mac OS X',
                            '/mac_powerpc/i'        =>  'Mac OS 9',
                            '/linux/i'              =>  'Linux',
                            '/ubuntu/i'             =>  'Ubuntu',
                            '/iphone/i'             =>  'iPhone',
                            '/ipod/i'               =>  'iPod',
                            '/ipad/i'               =>  'iPad',
                            '/android/i'            =>  'Android',
                            '/blackberry/i'         =>  'BlackBerry',
                            '/webos/i'              =>  'Mobile');
    $found = false;
    $device = '';
    foreach ($os_array as $regex => $value) 
    { 
        if($found)
         break;
        else if (preg_match($regex, $user_agent)) 
        {
            $os_platform    =   $value;
            $device = !preg_match('/(windows|mac|linux|ubuntu)/i',$os_platform)
                      ?'MOBILE':(preg_match('/phone/i', $os_platform)?'MOBILE':'SYSTEM');
        }
    }
    $device = !$device? 'SYSTEM':$device;
    return array('os'=>$os_platform,'device'=>$device);
 }
    //Ashish
  //public function alternate_login(Request $request){
  //  $name = $request->name;
  // $email =$request->email;
  // $first_char=$name[0];
//	$img = Image::make('devapi.myshoperoo.com/public/appNameplate.png');
//	$img->insert('devapi.myshoperoo.com/public/appNameplateinitial.png');
//	$img->save('devapi.myshoperoo.com/public/mergedImage.png');


 //  echo $first_char;exit;
  //  }

    public function login(Request $request){

      $phone = $request->phone;
      $password = md5($request->password);

      $result = DB::table('user_profile')->where('phone',$phone)->where('password',$password)->get();
      if (sizeof($result)>0) {
        $RESPONSE['error'] = false;
        $RESPONSE['message'] = 'Login successful';
        $RESPONSE['data'] = $result[0];
      }else{
        $RESPONSE['error'] = true;
        $RESPONSE['message'] = 'Invalid Login Credentials';
      }
      return $RESPONSE;
    }


    public function change_password(Request $request){
      $phone = $request->phone;
      $password = md5($request->password);
      $confirm_password = md5($request->confirm_password);

      if($password != $confirm_password){
        $RESPONSE['error'] = true;
        $RESPONSE['message'] = 'Password Mismatch';
      }else{
        $data = [
          "password" => $password
        ];
        $result = DB::table('user_profile')->where('phone',$phone)->update($data);
        if (sizeof($result)>0) {
          $RESPONSE['error'] = false;
          $RESPONSE['message'] = 'Password Change Successful';
        }else{
          $RESPONSE['error'] = true;
          $RESPONSE['message'] = 'Password is same as previous one.';
        }
      }

      return $RESPONSE;
    }

    public function admin_login(Request $request){

		      $phone = $request->phone;
		      $password = md5($request->password);

		      $result = DB::table('admin_credentials')->where('phone',$phone)->where('password',$password)->get();
		      if (sizeof($result)>0) {
			        $RESPONSE['error'] = false;
			        $RESPONSE['message'] = 'Login successful';
			        $RESPONSE['data'] = $result[0];
		      }else{
			        $RESPONSE['error'] = true;
			        $RESPONSE['message'] = 'Invalid Login Credentials';
		      }
		      return $RESPONSE;
	    }
    	public function change_admin_password(Request $request){
	      $phone = $request->phone;
	      $password = md5($request->password);
	      $confirm_password = md5($request->confirm_password);

	      if($password != $confirm_password){
	        $RESPONSE['error'] = true;
	        $RESPONSE['message'] = 'Password Mismatch';
	      }else{
	        $data = [
	          "password" => $password
	        ];
	        $result = DB::table('admin_credentials')->where('phone',$phone)->update($data);
	        if (sizeof($result)>0) {
	          $RESPONSE['error'] = false;
	          $RESPONSE['message'] = 'Password Change Successful';
	        }else{
	          $RESPONSE['error'] = true;
	          $RESPONSE['message'] = 'Password is same as previous one.';
	        }
	      }
	      return $RESPONSE;
	    }

	public function customer_login_by_admin(Request $request){
	$phone = $request->phone;

	$checkcustomer=Db::table('user_profile')->select('user_id','name','phone','email_id','company_code')->where('phone',$phone)->get();
	if(sizeof($checkcustomer)>0){
		$RESPONSE['error'] = false;
	        $RESPONSE['data'] = $checkcustomer[0] ;
	}
	else{
		$RESPONSE['error'] = true;
	        $RESPONSE['message'] = 'No Customer Registered With This Number.';
	}
	return $RESPONSE;
	}

    public function update_profile(Request $request){
    	$user_id= $request->user_id;
    	$name=$request->name;
    	$email=$request->email;
    	$company_code=$request->company_code;
    	$unique_code=$request->unique_code;

    	if(!$name || !$email){
    		$RESPONSE['error'] = true;
    		$RESPONSE['code']=1000;
          	$RESPONSE['message'] = 'Please Fill All The Fields To Update';
    	}
    	else if((!$company_code && $unique_code) || ($company_code && !$unique_code)){
    		$RESPONSE['error'] = true;
    		$RESPONSE['code']=1001;
          	$RESPONSE['message'] = 'Can\'t Update Only One Of the code';
    	}
    	else{
    		if($company_code && $unique_code){
    		$checkCodeValidation=DB::table('admin_profile')->select('company_code','unique_code','use_flag')->where('company_code',$company_code)->where('unique_code',$unique_code)->get();

    		if(sizeof($checkCodeValidation)>0){
          if($checkCodeValidation[0]->use_flag == 0){
              $updateDetails=DB::table('user_profile')->where('user_id',$user_id)->update(['name'=>$name,'email_id'=>$email,'company_code'=>$company_code,'unique_code'=>$unique_code]);
        			$updateFlag=DB::table('admin_profile')->where('company_code',$company_code)->where('unique_code',$unique_code)->update(['use_flag'=>1]);
        		$getUpdatedDetails=DB::table('user_profile')->where('user_id',$user_id)->get();
        		
        		if(sizeof($updateDetails)>0){
    	    		$RESPONSE['error'] = false;
    	    		$RESPONSE['tempdata']=$getUpdatedDetails;
    	          	$RESPONSE['message'] = 'Details Changed Successfully.';
        		}
        		else{
        			$RESPONSE['error'] = true;
        			$RESPONSE['code']=1002;
              		$RESPONSE['message'] = 'Details Same as Previous.';
        		}
          }else{
            $updateDetails=DB::table('user_profile')->where('user_id',$user_id)->update(['name'=>$name,'email_id'=>$email]);
            $getcodestatus=DB::table('user_profile')->where('user_id',$user_id)->where('company_code',$company_code)->where('unique_code',$unique_code)->count();
            $getUpdatedDetails=DB::table('user_profile')->where('user_id',$user_id)->get();
          if(sizeof($updateDetails)>0){
            $RESPONSE['error'] = false;
            	$RESPONSE['tempdata']=$getUpdatedDetails;
            	if($getcodestatus>0){
            		$RESPONSE['message'] = 'Name And/or Email Updated Successfully.';
            	}
            	else{
            		$RESPONSE['message'] = 'Company Code and/Or Unique Code in Invalid';
            	}
                
          }
          else{
            $RESPONSE['error'] = true;
            $RESPONSE['code']=1002;
                $RESPONSE['message'] = 'Details Same as Previous.';
          }
          }

    		}
    		else{

    			$RESPONSE['error'] = true;
    			$RESPONSE['code']=1003;
          		$RESPONSE['message'] = 'Company Code and/or User Code is Not Correct. Please Fix or Remove Both Codes to Proceed.';
    		}
    		}
    		else{
	    		$updateDetails=DB::table('user_profile')->where('user_id',$user_id)->update(['name'=>$name,'email_id'=>$email]);
	    		$getUpdatedDetails=DB::table('user_profile')->where('user_id',$user_id)->get();
	    		if(sizeof($updateDetails)>0){
		    		$RESPONSE['error'] = false;
		    		$RESPONSE['tempdata']=$getUpdatedDetails;
		          	$RESPONSE['message'] = 'Details Changed Successfully.';
	    		}
	    		else{
	    			$RESPONSE['error'] = true;
	    			$RESPONSE['code']=1004;
	          		$RESPONSE['message'] = 'Details Same as Previous.';
	    		}
    		}
    	}
    return $RESPONSE;
    }



	public function createCode(Request $request){
	$company_code=$request->company_code;
	$unique_code =$request->Unique_code;
	$work_email =$request->work_email;
	$sendmailORnot=$request->mailOrNot;
	if(!$unique_code || !$work_email || !$company_code){
		$RESPONSE['error'] = true;
          	$RESPONSE['message'] = 'Please fill All Details';
	}
	else{
		$checkPreviousEmailEntry=DB::table('admin_profile')->select('*')->where('work_email',$work_email)->get();
		$checkPreviousCodeEntry=DB::table('admin_profile')->select('*')->where('unique_code',$unique_code)->where('company_code',$company_code)->get();
		if(sizeof($checkPreviousEmailEntry)>0){
			$RESPONSE['error'] = true;
          		$RESPONSE['message'] = 'Email Already Exists!!!';
		}
		else if(sizeof($checkPreviousCodeEntry)>0){
			$RESPONSE['error'] = true;
          		$RESPONSE['message'] = 'Unique Code Already Exists!!!';
		}
		else{
		$insertUniqueCode=DB::table('admin_profile')->insert(array('work_email'=>$work_email,'company_code'=>$company_code,'unique_code'=>$unique_code));
		if(sizeof($insertUniqueCode)>0){
			$RESPONSE['error'] = false;
          		if($sendmailORnot){
          			$this->send_unique_code_by_mail($company_code,$unique_code,$work_email);
          			$RESPONSE['message'] = 'Unique Code '. $company_code.'-'.$unique_code .' Created And Mailed Successfully!!!';
          		}
          		else{
          			$RESPONSE['message'] = 'Unique Code '. $company_code.'-'.$unique_code .' Created Successfully!!!';
          		}
		}
		else{
			$RESPONSE['error'] = true;
          		$RESPONSE['message'] = 'Error While Inserting Unique Code!!!';
		}
		}
	    }
	    return $RESPONSE;
	}
	public function send_unique_code_by_mail($company_code,$unique_code,$email){
		      date_default_timezone_set('America/Los_Angeles');
		      $from = 'work@myshoperoo.com';
		      $date = date('d/m/y');
		      $subject = 'Welcome to MyShoperoo - Your Trusted Shopping Concierge';
$message ='Welcome To MyShoperoo @Work! Your Company is providing you with MyShoperoo benifits to save your valuable time. Please register by visiting work.myshoperoo.com.

Enter The Following Code at the time of registration:

Company Code : '.$company_code.'
Unique Code : '.$unique_code.'

If you have any questions, feel free to reply to this email and one of us will get back to you soon.

We look forward to serving you.
MyShoperoo @Work';

		      $headers = "From: ".$from . "\r\n" .
			"BCC: krisvanka@gmail.com,work@myshoperoo.com";

		      // send email
		      if(mail($email,$subject,$message, $headers)){
		        $RESPONSE['error'] = false;

		      }else{
		        $RESPONSE['error'] = true;
		      }
		      return $RESPONSE;

		    }
	public function send_registration_confirmation_mail($name,$phone,$email,$company_code,$unique_code){
		      date_default_timezone_set('America/Los_Angeles');
		      if(!$company_code){
		      $company_code='Company Code Not Entered';
		      }
		     	if(!$unique_code){
		     	$unique_code='Unique Code Not Entered';
		     	}
		 	$from = 'work@myshoperoo.com';
		      $date = date('d/m/y');
		      $subject = 'New Registration On Work.MyShoperoo.com';
$message ='Hello MyShoperoo Admin, we have a new registration on our website. Below are the details.

Name : '.$name.'
Email ID : '.$email.'
Phone Number : '.$phone.'
Company Code : '.$company_code.'
Unique Code : '.$unique_code.'
Registration Date : '.$date.'

MyShoperoo @Work';

		      $headers = "From: ".$from . "\r\n" .
			"BCC: krisvanka@gmail.com";

		      // send email
		      if(mail("work@myshoperoo.com",$subject,$message, $headers)){
		        $RESPONSE['error'] = false;

		      }else{
		        $RESPONSE['error'] = true;
		      }
		      return $RESPONSE;

		    }



	public function sendOtpFunction($phone){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,"https://api.authy.com/protected/json/users/new?api_key=Q7G5KVpoafv240Py4USxK2s6w3NXCn6u");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,
		            "user[email]=ideesys@myshoperoo.com&user[cellphone]=".$phone."&user[country_code]=1");

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$server_output = curl_exec($ch);

		curl_close ($ch);
		//echo json_encode(json_decode($server_output)->user->id);exit;
		if (json_decode($server_output)->success) { return $this->sendOtp(json_decode($server_output)->user->id); } else { return json_decode($server_output)->message; }

	}

	function sendOtp($authy_id){
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL,"http://api.authy.com/protected/json/sms/".$authy_id."?force=true&api_key=Q7G5KVpoafv240Py4USxK2s6w3NXCn6u");

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$server_output = curl_exec($ch);

		curl_close ($ch);
		$ob = json_decode($server_output, TRUE);
		$ob["authy_id"] = $authy_id;
		return $ob;
		//echo $server_output;exit;
		return $server_output;
		if ($server_output->success) { $this->sendOtp($server_output->user->id); } else { return $server_output->message; }
	}


    public function verifyOtpFunction($phone, $otp){
      $message = array("countryCode"=>'+1',"mobileNumber"=>$phone,"getGeneratedOTP"=>true);
      $data = json_encode($message);
      $ch = curl_init('http://api.work.myshoperoo.com/public/verifyOTPV1.php');
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, "mobileNumber=".$phone."&countryCode=%2B1"."&getGeneratedOTP=true&oneTimePassword=".$otp);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $result = curl_exec($ch);
      if(json_decode(json_decode($result))->status == 'SUCCESSFUL')
        return true;
      return false;
    }

}
