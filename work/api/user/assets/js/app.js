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
  $('.login_submit').click(function(){
    $.post("http://api.work.myshoperoo.com/public/login",
    {
        phone: $('#phone').val(),
        password: $('#password').val()
    },
    function(data, status){
        if(data.error){
          alert(data.message)
        }else{
          localStorage.setItem('loginData', JSON.stringify(data.data));
          window.location.href = 'home.html';
        }
    });
  });

  $('.go_otp').click(function(){
    $.post("http://api.work.myshoperoo.com/public/get_otp",
    {
        phone: $('#get-otp-phone').val(),
        type: 'forgot'
    },
    function(data, status){
      if(data.error){
        alert(data.message);
      }else{
        $("#newuser_login").css({"display":"none"});
        $("#user_login").css({"display":"none"});
        $("#forgot_pass").css({"display":"none"});
        $("#enter_opt").css({"display":"block"});
      }
    });

  })

  $('.reg_go_otp').click(function(){
    $.post("http://api.work.myshoperoo.com/public/get_otp",
    {
        phone: $('#reg-get-otp-phone').val(),
        type: 'signup'
    },
    function(data, status){
      if(data.error){
        alert(data.message);
      }else{
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

  })

  $('.reg_enter_otp_button').click(function(){
    $.post("http://api.work.myshoperoo.com/public/verify_otp",
    {
        phone: $('#reg-get-otp-phone').val(),
        otp: $('#reg-enter-otp').val()
    },
    function(data, status){
      if(data.error){
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

  })

  $('.reg-submit').click(function(){
    $.post("http://api.work.myshoperoo.com/public/signup",
    {
        phone: $('#reg-phone').val(),
        name: $('#reg-name').val(),
        email: $('#reg-email').val(),
        password: $('#reg-password').val()
    },
    function(data, status){
      if(data.error){
        alert(data.message);
      }else{
        login($('#reg-phone').val(), $('#reg-password').val());
      }
    });

  })

  $('.for_enter_otp_button').click(function(){
    $.post("http://api.work.myshoperoo.com/public/verify_otp",
    {
        phone: $('#get-otp-phone').val(),
        otp: $('#for-otp').val()
    },
    function(data, status){
      if(data.error){
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

  })
  $('.change_password').click(function(){
    if($('#for-password').val() == $('#for-conf-password').val()){
      $.post("http://api.work.myshoperoo.com/public/change_password",
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


  })

  function login(phone, password){
    $.post("http://api.work.myshoperoo.com/public/login",
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

  $(".goto_forgotpassotp").click(function(){
    $("#newuser_login").css({"display":"none"});
    $("#user_login").css({"display":"none"});
    $("#forgot_pass").css({"display":"none"});
    $("#enter_opt").css({"display":"none"});
    $("#forgotPass_opt").css({"display":"block"})
  });





  //home page jquery started


  $('#save_button').click(function(){
    if($('#order_label').html() == 'Order'){
      var loginData = JSON.parse(localStorage.loginData);
        $.post("http://api.work.myshoperoo.com/public/add_order",
        {
            date: $('#caledar').val(),
            phone: loginData.phone,
            name: loginData.name,
            email: loginData.email_id,
            shopping_list: $('.shopping_list').val(),
            status : 'save'
        },
        function(data, status){
          if(data.error){
            alert(data.message);
          }else{
            getShoppingList();
          }
        });
    }
  })

  $('#order_button').click(function(){
    if($('#order_label').html() == 'Update'){
      var loginData = JSON.parse(localStorage.loginData);
        $.post("http://api.work.myshoperoo.com/public/add_order",
        {
            date: $('#caledar').val(),
            phone: loginData.phone,
            name: loginData.name,
            email: loginData.email_id,
            shopping_list: $('.shopping_list').val(),
            status : 'update'
        },
        function(data, status){
          if(data.error){
            // alert(data.message);
          }else{
            getShoppingList();
          }
        });
      $('textarea').prop('disabled', false);
      $('#order_label').html('Order');
    }else{
      var loginData = JSON.parse(localStorage.loginData);
        $.post("http://api.work.myshoperoo.com/public/add_order",
        {
            date: $('#caledar').val(),
            phone: loginData.phone,
            name: loginData.name,
            email: loginData.email_id,
            shopping_list: $('.shopping_list').val(),
            status : 'ordered'
        },
        function(data, status){
          if(data.error){
            // alert(data.message);
          }else{
            getShoppingList();
          }
        });
    }

    })
    function sendmail(){
      $.get("../../mail.php", function(data, status){
          alert("Thanks for order.");
      });

      // $.get("../../mail.php?from="loginData.email_id+'&msg='+$('.shopping_list').val(), function(data, status){
      //     alert("Thanks for order.");
      // });
    }


})
