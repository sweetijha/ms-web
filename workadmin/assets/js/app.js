$(document).ready(function () {
  if (window.location.href.split('?')[1] == 'create-user-id') {
    $('#userClick').attr('class', 'active');
    $('#orderClick').removeAttr('class', 'active');
    $('#reminderClick').removeAttr('class', 'active');
    $('#content1').html('');
    $('#content').html(`
    <div class="UniqueCodeBox">
      <div class="modal-content" style="border-radius: 0px;">
        <div class="modal-header">
          <h4 class="modal-title">Create A Unique Code</h4>
        </div>
        <div class="modal-body">
            <form style="border-radius:none" action="javascript:void(0);">
            <div class="form-group">
                <input type="email" class="form-control" id="work_email" placeholder="Enter Work email" name="work_email" style="height: 48px !important;border-radius:0px !important">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="company_code" placeholder="Enter Company Code" name="company_code" oninput="this.value=this.value.replace(/[^a-z0-9]/i,'');this.value=this.value.length>3?this.value.slice(0, -1):this.value;" style="height: 48px !important;border-radius:0px !important">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="emp_code" placeholder="Enter Employee Code" name="emp_code" oninput="this.value=this.value.replace(/[^a-z0-9]/i,'');this.value=this.value.length>5?this.value.slice(0, -1):this.value;" style="height: 48px !important;border-radius:0px !important">
            </div>
            </form>
        </div>
        <div class="modal-footer col-sm-6 col-md-6 col-xs-6 changehieghtDynamic" style="background: #90603f !important;color: white !important;width:49.5%;margin-right:0.5%;font-size: 14px !important;text-align:center" onclick="createCode(0)">
	     <div><button type="submit">Create Code</button></div>
        </div>
        <div class="modal-footer col-sm-6 col-md-6 col-xs-6" style="background: #90603f !important;color: white !important;width:49.5%;margin-left:0.5%;font-size: 14px !important;text-align:center" onclick="createCode(1)">
	      <div><button type="submit">Create Code & Email</button></div>
        </div>
      </div>
     </div>
    `)
  } else if (window.location.href.split('?')[1] == 'order') {
    $('#userClick').removeAttr('class', 'active');
    $('#orderClick').attr('class', 'active');
    $('#reminderClick').removeAttr('class', 'active');
    $('#content1').html(`
    <div class="container responsiveStyle col-md-12" style="border:1px solid grey;padding: 0px;box-shadow: 1px 1px 3px 0px #999898;">
      <div class="col-md-6" style="border-right:1px solid #e8cfba;padding: 20px;">
          <form action="javascript:void(0)" id="form16">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Enter Customer Mobile Number (1234567890)" style="height: 48px !important;border:1px solid #905b35;border-radius:0px !important" id="customerphone" maxlength="10" oninput="this.value=this.value.replace(/[^0-9]/g,'');this.value=this.value.length>10?this.value.slice(0, -1):this.value;orderByAdmin(this.value)">
            </div>
          </form>
          <div id="sidemenu1">
          <div class="">
            <aside class="sidebar1">
            <div class="widget-wrapper">
              <form class="search-form">
                <div class="form-input">
                  <input value="" placeholder="Enter Date" type="text" class="calendar_inut"  id="caledar" readonly style="color:#905b35;height: 48px !important;border:1px solid #905b35;border-radius:0px !important;color:#905b35">
                  <span class="form-button btn_calendar">
                    <button type="button">
                      <i class="fa fa-calendar"></i>
                    </button>
                  </span>
                </div>
              </form>
            </div>
            </aside>
          </div>
        </div>
      </div>
      <div class="col-md-6">
          <div style="padding: 10px;padding-top: 20px;">
            <span>Name  : <span id="currentName"></span></span>
          </div>
          <div style="padding: 10px">
            <span>Email  : <span id="customeremail"></span></span>
          </div>
          <div style="padding: 10px">
            <span>Phone : <span id="customerphoneno"></span></span>
          </div>
      </div>
    </div>
    `)
    $('#content').html(`
                    Enter Customer Phone Number To Search On His/her Behalf.
    `)
  }
  else if (window.location.href.split('?')[1] == 'reminder') {
    $('#userClick').removeAttr('class', 'active');
    $('#orderClick').removeAttr('class', 'active');
    $('#reminderClick').attr('class', 'active');
    $('#content1').html(`
    <div class="container responsiveStyle col-md-12" style="border:1px solid grey;padding: 0px;box-shadow: 1px 1px 3px 0px #999898;">
      <div class="widget-wrapper">
        <form class="search-form">
          <div class="form-input" style="margin-top: 10px;">
            <input value="" placeholder="Enter Date" type="text" class="calendar_inut"  id="caledar_reminder" readonly style="color:#905b35;height: 38px !important;border:1px solid #905b35;border-radius:0px !important;color:#905b35;padding-right: 38px;padding-left: 10px;">
            <span class="form-button btn_calendar" style="position: relative;right: 38px;">
              <button type="button">
                <i class="fa fa-calendar"></i>
              </button>
            </span>
          </div>
        </form>
      </div>
      <div class="col-md-12" style="border-right:1px solid #e8cfba;padding: 20px;">
          <div>
            <div id="send_draft_sms" class="col-sm-6 col-xs-12 draft_class" onclick="send_draft_sms_function()">Send Draft Message</div>
            <div id="send_ordered_sms" class="col-sm-6 col-xs-12 ordered_class" style="margin-bottom: 16px;" onclick="send_ordered_sms_function()">Send Ordered Message</div>
          </div>
      </div>

    </div>
    `)
    $('#content').html(``);
    $('#caledar_reminder').val(dateFormat(new Date()));
  }else {
    if (localStorage.adminloginData) {
      window.location.href = 'dashboard.html?create-user-id';
    }

  }
  setTimeout(function () {
    $("#caledar").datepicker({
      numberOfMonths: 1,
      // minDate:-0,
      dateFormat: "dd-M-yy",
      onSelect: function (dateText) {
        getShoppingList();
      }
    });
  }, 1000);
  setTimeout(function () {
  $("#caledar_reminder").datepicker({
    numberOfMonths: 1,
    // minDate:-0,
    dateFormat: "dd-M-yy",
    onSelect: function (dateText) {
      getShoppingList();
    }
  });
}, 1000);
  $("#forgotPass_opt").css({ "display": "none" });
  $("#enter_opt").css({ "display": "none" });
  $("#newuser_login").css({ "display": "none" });
  $("#forgot_pass").css({ "display": "none" });
  $("#reg_enter_opt").css({ "display": "none" });
  $("#reg_forgot_pass").css({ "display": "none" });
  // getShoppingList();
  $('#save_label').html('Save');
  $('#order_label').html('Order');
  $('.login_submit').click(function () {
    $.post("https://api.myshoperoo.com/public/admin_login",
      {
        phone: $('#phone').val(),
        password: $('#password').val()
      },
      function (data, status) {
        if (data.error) {
          alert(data.message);
        } else {
          localStorage.setItem('adminloginData', JSON.stringify(data.data));
          window.location.href = 'dashboard.html';
        }
      });
  });
  //by Ashish
  function orderbyadmin() {
    window.location.href = 'home.html';
  }

  $('.go_otp').click(function () {
    $.post("https://api.myshoperoo.com/public/get_otp",
      {
        phone: $('#get-otp-phone').val(),
        type: 'forgot'
      },
      function (data, status) {
        if (data.error) {
          alert(data.message);
        } else {
          $("#newuser_login").css({ "display": "none" });
          $("#user_login").css({ "display": "none" });
          $("#forgot_pass").css({ "display": "none" });
          $("#enter_opt").css({ "display": "block" });
        }
      });

  })

  $('.reg_go_otp').click(function () {

    if ($('#reg-get-otp-phone').val() != "") {
      $.post("https://api.myshoperoo.com/public/get_otp",
        {
          phone: $('#reg-get-otp-phone').val(),
          type: 'signup'
        },
        function (data, status) {
          if (data.error) {
            alert(data.message);
          } else {
            $("#newuser_login").css({ "display": "none" });
            $("#user_login").css({ "display": "none" });
            $("#forgot_pass").css({ "display": "none" });
            $("#enter_opt").css({ "display": "none" });
            $("#reg_forgot_pass").css({ "display": "none" });
            $("#reg_enter_opt").css({ "display": "block" });
            $("#newuser_login").css({ "display": "none" });
            $("#user_login").css({ "display": "none" });
          }
        });
    }
    else {
      alert("Please enter a valid phone number");
    }

  })

  $('.reg_enter_otp_button').click(function () {
    $.post("https://api.myshoperoo.com/public/verify_otp",
      {
        phone: $('#reg-get-otp-phone').val(),
        otp: $('#reg-enter-otp').val()
      },
      function (data, status) {
        data = JSON.parse(data);
        if (data.errorCode == "40003") {
          alert(data.message);
        } else {
          $('#reg-phone').val($('#reg-get-otp-phone').val());
          $("#newuser_login").css({ "display": "none" });
          $("#user_login").css({ "display": "none" });
          $("#forgot_pass").css({ "display": "none" });
          $("#enter_opt").css({ "display": "none" });
          $("#reg_forgot_pass").css({ "display": "none" });
          $("#reg_enter_opt").css({ "display": "none" });
          $("#newuser_login").css({ "display": "block" });
          $("#user_login").css({ "display": "none" });
        }
      });

  })

  $('.reg-submit').click(function () {
    $.post("https://api.myshoperoo.com/public/signup",
      {
        phone: $('#reg-phone').val(),
        name: $('#reg-name').val(),
        email: $('#reg-email').val(),
        password: $('#reg-password').val()
      },
      function (data, status) {
        if (data.error) {
          alert(data.message);
        } else {
          login($('#reg-phone').val(), $('#reg-password').val());
        }
      });

  })

  $('.for_enter_otp_button').click(function () {
    $.post("https://api.myshoperoo.com/public/verify_otp",
      {
        phone: $('#get-otp-phone').val(),
        otp: $('#for-otp').val()
      },
      function (data, status) {
        if (data.error) {
          alert(data.message);
        } else {
          $("#newuser_login").css({ "display": "none" });
          $("#user_login").css({ "display": "none" });
          $("#forgot_pass").css({ "display": "none" });
          $("#enter_opt").css({ "display": "none" });
          $("#reg_forgot_pass").css({ "display": "none" });
          $("#reg_enter_opt").css({ "display": "none" });
          $("#newuser_login").css({ "display": "none" });
          $("#user_login").css({ "display": "none" });
          $("#forgotPass_opt").css({ "display": "block" });
        }
      });

  })
  $('.change_password').click(function () {
    if ($('#for-password').val() == $('#for-conf-password').val()) {
      $.post("https://api.myshoperoo.com/public/change_password",
        {
          phone: $('#get-otp-phone').val(),
          password: $('#for-password').val(),
          confirm_password: $('#for-conf-password').val()
        },
        function (data, status) {
          if (data.error) {
            alert(data.message);
          } else {
            $("#forgotPass_opt").css({ "display": "none" });
            $("#enter_opt").css({ "display": "none" });
            $("#newuser_login").css({ "display": "none" });
            $("#forgot_pass").css({ "display": "none" });
            $("#reg_enter_opt").css({ "display": "none" });
            $("#reg_forgot_pass").css({ "display": "none" });
            $("#newuser_login").css({ "display": "none" });
            $("#user_login").css({ "display": "block" });
            $("#forgot_pass").css({ "display": "none" });
          }
        });
    } else {
      alert('Password Mismach');
    }


  })

  function login(phone, password) {
    $.post("https://api.myshoperoo.com/public/admin_login",
      {
        phone: phone,
        password: password
      },
      function (data, status) {
        if (data.error) {
          alert(data.message)
        } else {
          localStorage.setItem('adminloginData', JSON.stringify(data.data));
          window.location.href = 'dashboard.html';
        }
      });
  }

  $("#forgotPass_opt").css({ "display": "none" });
  $("#enter_opt").css({ "display": "none" });
  $("#newuser_login").css({ "display": "none" });
  $("#forgot_pass").css({ "display": "none" });
  $("#reg_enter_opt").css({ "display": "none" });
  $("#reg_forgot_pass").css({ "display": "none" });
  $(".newuser_login").click(function () {
    $("#forgotPass_opt").css({ "display": "none" });
    $("#enter_opt").css({ "display": "none" });
    $("#newuser_login").css({ "display": "none" });
    $("#forgot_pass").css({ "display": "none" });
    $("#reg_enter_opt").css({ "display": "none" });
    $("#reg_forgot_pass").css({ "display": "none" });
    $("#reg_forgot_pass").css({ "display": "block" });
    $("#user_login").css({ "display": "none" });
  });
  $(".forgot_pass").click(function () {
    $("#forgotPass_opt").css({ "display": "none" });
    $("#enter_opt").css({ "display": "none" });
    $("#newuser_login").css({ "display": "none" });
    $("#forgot_pass").css({ "display": "none" });
    $("#reg_enter_opt").css({ "display": "none" });
    $("#reg_forgot_pass").css({ "display": "none" });
    $("#newuser_login").css({ "display": "none" });
    $("#user_login").css({ "display": "none" });
    $("#forgot_pass").css({ "display": "block" });
  });
  $(".user_login").click(function () {
    $("#forgotPass_opt").css({ "display": "none" });
    $("#enter_opt").css({ "display": "none" });
    $("#newuser_login").css({ "display": "none" });
    $("#forgot_pass").css({ "display": "none" });
    $("#reg_enter_opt").css({ "display": "none" });
    $("#reg_forgot_pass").css({ "display": "none" });
    $("#newuser_login").css({ "display": "none" });
    $("#user_login").css({ "display": "block" });
    $("#forgot_pass").css({ "display": "none" });
  });

  // $(".go_otp").click(function(){
  //   $("#newuser_login").css({"display":"none"});
  //   $("#user_login").css({"display":"none"});
  //   $("#forgot_pass").css({"display":"none"});
  //   $("#enter_opt").css({"display":"block"});
  // });

  $(".goto_forgotpassotp").click(function () {
    $("#newuser_login").css({ "display": "none" });
    $("#user_login").css({ "display": "none" });
    $("#forgot_pass").css({ "display": "none" });
    $("#enter_opt").css({ "display": "none" });
    $("#forgotPass_opt").css({ "display": "block" })
  });





  //home page jquery started

  function sendmail() {
    // var userFetcheddata = {};
    // var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
    //   userFetcheddata[key] = value;
    // });
    // console.log(userFetcheddata);
    //var loginData = JSON.parse(localStorage.loginData);
    $.post("https://api.myshoperoo.com/public/send_mail",
      {
        msg: $('.shopping_list').val(),
        email: $('#customeremail').html(),
        name: $('#currentName').html(),
        phone: $('#customerphoneno').html(),
        company_code:$('#company_code').html(),
        date: $('#caledar').val(),

      },
      function (data, status) {
        $('#alert-modal').modal('show');
      });

    // $.get("../../mail.php?from="loginData.email_id+'&msg='+$('.shopping_list').val(), function(data, status){
    //     alert("Thanks for order.");
    // });
  }

  function sendsms() {
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
function send_draft_sms_function() {
if(confirm("Are You Sure To Send Messages?")){
$.post("https://api.myshoperoo.com/public/send_reminder_message",
    {
      status: 'save',
      date : $('#caledar_reminder').val()
    },
    function (data, status) {
      alert("Performed draft message for "+data.phone.length+" customers on "+data.date);
      //alert("Messages Sent.")
    });
}
};

function send_ordered_sms_function(){
if(confirm("Are You Sure To Send Messages?")){
  $.post("https://api.myshoperoo.com/public/send_reminder_message",
    {
      status: 'ordered',
      date : $('#caledar_reminder').val()
    },
    function (data, status) {
      alert("Performed Ordered message for "+data.phone.length+" customers on "+data.date);
    });
}
};

function dateFormat(date){
  switch(parseInt(date.getMonth())){
    case 0 : return date.getDate()+'-'+'Jan'+'-'+date.getFullYear();
    case 1 : return date.getDate()+'-'+'Feb'+'-'+date.getFullYear();
    case 2 : return date.getDate()+'-'+'Mar'+'-'+date.getFullYear();
    case 3 : return date.getDate()+'-'+'Apr'+'-'+date.getFullYear();
    case 4 : return date.getDate()+'-'+'May'+'-'+date.getFullYear();
    case 5 : return date.getDate()+'-'+'Jun'+'-'+date.getFullYear();
    case 6 : return date.getDate()+'-'+'Jul'+'-'+date.getFullYear();
    case 7 : return date.getDate()+'-'+'Aug'+'-'+date.getFullYear();
    case 8 : return date.getDate()+'-'+'Sep'+'-'+date.getFullYear();
    case 9 : return date.getDate()+'-'+'Oct'+'-'+date.getFullYear();
    case 10 : return date.getDate()+'-'+'Nov'+'-'+date.getFullYear();
    case 11 : return date.getDate()+'-'+'Dec'+'-'+date.getFullYear();
  }
}
