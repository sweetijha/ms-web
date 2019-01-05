$(document).ready(function(){
  $("#forgotPass_opt").css({"display":"none"});
  $("#enter_opt").css({"display":"none"});
  $("#newuser_login").css({"display":"none"});
  $("#forgot_pass").css({"display":"none"});
  $("#reg_enter_opt").css({"display":"none"});
  $("#reg_forgot_pass").css({"display":"none"});
  // getShoppingList();
  $('#save_label').html('Save');
  $('#order_label').html('Order');
  function userLogin(){
    $.post("https://api.myshoperoo.com/public/login",
    {
        phone: $('#phone').val(),
        password: $('#password').val()
    },
    function(data, status){
        if(data.error){
          alert(data.message);
        }else{
          localStorage.setItem('loginData', JSON.stringify(data.data));
          window.location.href = 'home.html';
          //if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
          // alert(navigator.userAgent)
          //}
        }
    });
  }
  $('.login-form-submit').submit(function(){
    userLogin();
  });
  $('.login_submit').click(function(){
    userLogin();
  });
  var authy_id;

  function sendOTPfunction(){
  if($('#get-otp-phone').val().length<10){
  	alert("Please enter a valid phone number");
  }
  else{
  $.post("https://api.myshoperoo.com/public/get_otp",
    {
        phone: $('#get-otp-phone').val(),
        type: 'forgot'
    },
    function(data, status){
      if(data.error){
        alert(data.message);
      }else{
      	authy_id = data.authy_id;
        $("#newuser_login").css({"display":"none"});
        $("#user_login").css({"display":"none"});
        $("#forgot_pass").css({"display":"none"});
        $("#enter_opt").css({"display":"block"});
      }
    });
  }
  }
  $('.sendOTPFunction').submit(function(){
    sendOTPfunction();
  });
  $('.go_otp').click(function(){
    sendOTPfunction();
  });
  

  function sendRegistrationOTP(){
  if($('#reg-get-otp-phone').val() != "" && $('#reg-get-otp-phone').val().length == 10)
  {
    $.post("https://api.myshoperoo.com/public/get_otp",
    {
        phone: $('#reg-get-otp-phone').val(),
        type: 'signup'
    },
    function(data, status){
      if(data.error){
        alert(data.message);
      }else{
      authy_id = data.authy_id;
        $("#newuser_login").css({"display":"none"});
        $("#user_login").css({"display":"none"});
        $("#forgot_pass").css({"display":"none"});
        $("#enter_opt").css({"display":"none"});
        $("#reg_forgot_pass").css({"display":"none"});
        $("#reg_enter_opt").css({"display":"block"});
        $("#newuser_login").css({"display":"none"});
        $("#user_login").css({"display":"none"});
      }
    });
    }
    else{
    	alert("Please enter a valid phone number");
    }
  }
  $('.registrationSendOtp').submit(function(){
    sendRegistrationOTP();
  });
  $('.reg_go_otp').click(function(){
    sendRegistrationOTP();
  });

  function registrationEnterOtp(){
    $.post("https://api.myshoperoo.com/public/verify_otp",
    {
        otp: $('#reg-enter-otp').val(),
        authy_id : authy_id
    },
    function(data, status){
      if(!data.success){
        alert(data.message);
      }else{
        $('#reg-phone').val($('#reg-get-otp-phone').val());
        $("#newuser_login").css({"display":"none"});
        $("#user_login").css({"display":"none"});
        $("#forgot_pass").css({"display":"none"});
        $("#enter_opt").css({"display":"none"});
        $("#reg_forgot_pass").css({"display":"none"});
        $("#reg_enter_opt").css({"display":"none"});
        $("#newuser_login").css({"display":"block"});
        $("#user_login").css({"display":"none"});
      }
    });

  }
  $('.regEnterOtpButton').submit(function(){
    registrationEnterOtp();
  });
  $('.reg_enter_otp_button').click(function(){
    registrationEnterOtp();
  });
  

  function userRegistration(){
	  if($('#reg-name').val()!='' && $('#reg-email').val()!='' && $('#reg-password').val()!=''){
	  var email=document.getElementById("reg-email");
	  var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	   if (re.test(email.value) == false)
        {
            alert('Invalid Email Address');
            $('#reg-email').val('');
        }
        else{
         $.post("https://api.myshoperoo.com/public/signup",
		    {
		        phone: $('#reg-phone').val(),
		        name: $('#reg-name').val(),
		        email: $('#reg-email').val(),
		        password: $('#reg-password').val(),
		        company_code: ($('#company_code').val()?($('#company_code').val()).toUpperCase():$('#company_code').val()),
		        unique_code : ($('#unique_code').val()?($('#unique_code').val()).toUpperCase():$('#unique_code').val()),
		    },
		    function(data, status){
		      if(data.error){
		        alert(data.message);
		      }else{
			      if(data.code){
			      	alert(data.message);
			      }
		        login($('#reg-phone').val(), $('#reg-password').val());
		      }
		    });
        }
	  }
	  else{
	  	alert('Please Fill Name,Email and Password');
	  }
	 }
	$('.newuserregistrationform').submit(function(){
	    userRegistration();
	  });
	$('.reg-submit').click(function(){
	    userRegistration();
	  });
	
  function verifyOTPfunction(){
    $.post("https://api.myshoperoo.com/public/verify_otp",
    {
        //phone: $('#get-otp-phone').val(),
        otp: $('#for-otp').val(),
        authy_id : authy_id
    },
    function(data, status){
      if(!data.success){
        alert(data.message);
      }else{
        $("#newuser_login").css({"display":"none"});
        $("#user_login").css({"display":"none"});
        $("#forgot_pass").css({"display":"none"});
        $("#enter_opt").css({"display":"none"});
        $("#reg_forgot_pass").css({"display":"none"});
        $("#reg_enter_opt").css({"display":"none"});
        $("#newuser_login").css({"display":"none"});
        $("#user_login").css({"display":"none"});
        $("#forgotPass_opt").css({"display":"block"});
      }
    });

  }
  $('.forEnterOtpButton').submit(function(){
	    verifyOTPfunction();
	  });
  $('.for_enter_otp_button').click(function(){
	    verifyOTPfunction();
	  });
	  
  function changepasswordFunction(){
    if($('#for-password').val() == $('#for-conf-password').val()){
      $.post("https://api.myshoperoo.com/public/change_password",
      {
          phone: $('#get-otp-phone').val(),
          password: $('#for-password').val(),
          confirm_password: $('#for-conf-password').val()
      },
      function(data, status){
        if(data.error){
          alert(data.message);
        }else{
          $("#forgotPass_opt").css({"display":"none"});
          $("#enter_opt").css({"display":"none"});
          $("#newuser_login").css({"display":"none"});
          $("#forgot_pass").css({"display":"none"});
          $("#reg_enter_opt").css({"display":"none"});
          $("#reg_forgot_pass").css({"display":"none"});
          $("#newuser_login").css({"display":"none"});
          $("#user_login").css({"display":"block"});
          $("#forgot_pass").css({"display":"none"});
        }
      });
    }else{
      alert('Password Mismach');
    }
  }
   $('.changepasswordfunction').submit(function(){
	    changepasswordFunction();
	  });
  $('.change_password').click(function(){
	    changepasswordFunction();
	  });
	  

  function login(phone, password){
    $.post("https://api.myshoperoo.com/public/login",
    {
        phone: phone,
        password: password
    },
    function(data, status){
        if(data.error){
          alert(data.message)
        }else{
          localStorage.setItem('loginData', JSON.stringify(data.data));
          window.location.href = 'home.html';
        }
    });
  }

  $("#forgotPass_opt").css({"display":"none"});
  $("#enter_opt").css({"display":"none"});
  $("#newuser_login").css({"display":"none"});
  $("#forgot_pass").css({"display":"none"});
  $("#reg_enter_opt").css({"display":"none"});
  $("#reg_forgot_pass").css({"display":"none"});
  $(".newuser_login").click(function(){
    $("#forgotPass_opt").css({"display":"none"});
    $("#enter_opt").css({"display":"none"});
    $("#newuser_login").css({"display":"none"});
    $("#forgot_pass").css({"display":"none"});
    $("#reg_enter_opt").css({"display":"none"});
    $("#reg_forgot_pass").css({"display":"none"});
    $("#reg_forgot_pass").css({"display":"block"});
    $("#user_login").css({"display":"none"});
  });
  $(".forgot_pass").click(function(){
    $("#forgotPass_opt").css({"display":"none"});
    $("#enter_opt").css({"display":"none"});
    $("#newuser_login").css({"display":"none"});
    $("#forgot_pass").css({"display":"none"});
    $("#reg_enter_opt").css({"display":"none"});
    $("#reg_forgot_pass").css({"display":"none"});
    $("#newuser_login").css({"display":"none"});
    $("#user_login").css({"display":"none"});
    $("#forgot_pass").css({"display":"block"});
  });
  $(".user_login").click(function(){
    $("#forgotPass_opt").css({"display":"none"});
    $("#enter_opt").css({"display":"none"});
    $("#newuser_login").css({"display":"none"});
    $("#forgot_pass").css({"display":"none"});
    $("#reg_enter_opt").css({"display":"none"});
    $("#reg_forgot_pass").css({"display":"none"});
    $("#newuser_login").css({"display":"none"});
    $("#user_login").css({"display":"block"});
    $("#forgot_pass").css({"display":"none"});
  });

  // $(".go_otp").click(function(){
  //   $("#newuser_login").css({"display":"none"});
  //   $("#user_login").css({"display":"none"});
  //   $("#forgot_pass").css({"display":"none"});
  //   $("#enter_opt").css({"display":"block"});
  // });

  //$(".goto_forgotpassotp").click(function(){
   // $("#newuser_login").css({"display":"none"});
   // $("#user_login").css({"display":"none"});
   // $("#forgot_pass").css({"display":"none"});
   // $("#enter_opt").css({"display":"none"});
   // $("#forgotPass_opt").css({"display":"block"})
  //});





  //home page jquery started


  $('#save_button').click(function(){
    if($('#save_label').html() == 'Update'){
      var loginData = JSON.parse(localStorage.loginData);
        $.post("https://api.myshoperoo.com/public/add_order",
        {
            date: $('#caledar').val(),
            phone: loginData.phone,
            name: loginData.name,
            email: loginData.email_id,
            shopping_list: $('.shopping_list').val(),
            status : 'update',
            is_admin: 0
        },
        function(data, status){
          if(data.error){
            // alert(data.message);
            // getShoppingList();
            $('textarea').prop('disabled', true);
            $('#save-order-alert-modal .modal-body').html(data.message);
            $('#save-order-alert-modal').modal('show');
            $('#save_label').html('Update');
          }else{
            getShoppingList();
            $('textarea').prop('disabled', false);
            $('#save_label').html('Save');
          }
        });
      // $('textarea').prop('disabled', false);
      // $('#order_label').html('Order');
    }else{
      var loginData = JSON.parse(localStorage.loginData);
        $.post("https://api.myshoperoo.com/public/add_order",
        {
            date: $('#caledar').val(),
            phone: loginData.phone,
            name: loginData.name,
            email: loginData.email_id,
            shopping_list: $('.shopping_list').val(),
            status : 'save',
            is_admin: 0
        },
        function(data, status){
          if(data.error){
            $('#save-order-alert-modal .modal-body').html(data.message);
            $('#save-order-alert-modal').modal('show');
          }else{
            getShoppingList();
          }
        });
    }
  })

  $('#order_button').click(function(){
      var loginData = JSON.parse(localStorage.loginData);
        $.post("https://api.myshoperoo.com/public/add_order",
        {
            date: $('#caledar').val(),
            phone: loginData.phone,
            name: loginData.name,
            email: loginData.email_id,
            shopping_list: $('.shopping_list').val(),
            status : 'ordered',
            is_admin: 0
        },
        function(data, status){
          if(data.error){
            // alert(data.message);
            $('#save-order-alert-modal .modal-body').html(data.message);
            $('#save-order-alert-modal').modal('show');
          }else{
            sendmail();
            sendsms();
            getShoppingList();
          }
        });


    })
    function sendmail(){
      var loginData = JSON.parse(localStorage.loginData);
      $.post("https://api.myshoperoo.com/public/send_mail",
      {
          msg: $('.shopping_list').val(),
          email: loginData.email_id,
          name: loginData.name,
          phone: loginData.phone,
          date: $('#caledar').val(),
          company_code:loginData.company_code
      },
      function(data, status){
        $('#alert-modal').modal('show');
      });

      // $.get("../../mail.php?from="loginData.email_id+'&msg='+$('.shopping_list').val(), function(data, status){
      //     alert("Thanks for order.");
      // });
    }

    function sendsms(){
      // var loginData = JSON.parse(localStorage.loginData);
      // $.post("https://api.myshoperoo.com/public/send_sms",
      // {
      //     msg: $('.shopping_list').val(),
      //     email: loginData.email_id,
      //     name: loginData.name,
      //     phone: loginData.phone,
      //     date: $('#caledar').val()
      // },
      // function(data, status){
      // });
    }





})
