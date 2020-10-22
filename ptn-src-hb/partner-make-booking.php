<?php
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
require_once('../lib/Inventory.php');
require_once('../lib/Box.php');
$util = new Util();
$user = new User();
$inventory = new Inventory();
$box = new Box();
$token = json_decode($_SESSION['usr'])->access_token;
?>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Happy Box:: Partner Booking</title>
  <!-- Bootstrap core CSS -->
 <?php include '../shared/partials/css.php'; ?>
 <style>
   .t-booking{
      
      text-decoration: none!important;
      border-bottom: solid 2px #c20a2b!important;
   }
 </style>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">

</head>
<body>
  <!-- Navigation -->
 <?php include '../shared/partials/nav-logged-in.php'; ?>
  
  <!--start desktop-->
<section class="section_60 desktop_view" id="reset_div">
      <div class="container">
      <div class="row  ">
        <div class="col-md-5">
          <div class=" how_it_work">
            <img src="../shared/img/howitworks.svg" class=""/>  </div>
          <div class="card how_it_work_card">
              <div class="">
                <p class="step_p"> <span class="step_span">STEP 1 </span>  Customer calls for a booking </p>                                
                <p class="step_p"> <span class="step_span">STEP 2 </span> <b>YOU</b> request customer voucher code </p>
                <p class="step_p"> <span class="step_span">STEP 3 </span>  <b>YOU</b> check the voucher code validity online </p>
                <p class="step_p"> <span class="step_span">STEP 4 </span>  <b>YOU</b> indicate the booking date </p> 
                <p class="step_p step_span_last"> <span class="step_span">STEP 5 </span>  <b>YOU</b> redeem & confirm booking to customer </p>
              </div>
          </div>
      </div>
        <div class="col-md-7 text-center ">
            <div class="how_it_work_border">
                
           
            <?php
              $_redeem_v_table = null;
              $obj = null;
              if(isset($_POST['VALIDITY']) && !empty(trim($_POST['vcode']))){
                  $voucher_code = strtoupper(trim($_POST['vcode']));
                  $res = $obj = $inventory->get_by_voucher($token, $voucher_code);
                  // print $util->Show($res);
                  $res = json_decode($res, true)['data'];
                  if( $res['box_voucher_status'] == 1 )
                  {
                    $data_0 = $data_1 = [
                      'Invalid',
                      'Invalid',
                      1
                    ];
                  }
                  // print $util->Show($res);
                  elseif(isset($res['box_internal_id'])){
                      $idf = $res['partner_internal_id'];
                      $box_idf = $res['box_internal_id'];
                      $_b_data = $box->get_byidf($token, $box_idf);
                      $box_data = json_decode($_b_data)->data;
                      // $util->Show($box_data);
                      // exit;
                      $_bx_services = json_decode(json_decode($_b_data, true)['data']['partners'], true);
                      $_bx_price = json_decode(json_decode($_b_data, true)['data']['price'], true);
                      // $util->Show($util->format_box_services($_bx_services));
                      if(!$box_data){
                        $data_0 = $data_1 = [
                          'Invalid',
                          'Invalid'
                        ];
                      }else{
                        if($res['box_voucher_new']){
                          $res['box_voucher'] = $res['box_voucher_new'];
                        }
                        $data_0 = [
                          $res['box_voucher'],
                          $res['box_voucher_status']
                        ];
                        $data_1 = [
                          $box_data->name,
                          $box_data->description,
                          json_decode($_SESSION['usr_info'])->data->internal_id,
                          $_bx_services,
                          floor($_bx_price*0.7)
                        ];
                      }
                  }else{
                      $data_0 = $data_1 = [
                          'Invalid',
                          'Invalid'
                      ];
                  }
                  $_redeem_v_table = $util->ptn_v_validity($data_0, $data_1, json_decode($obj));
              }
            ?>
            <div class="row justify-content-center">
                <div class="col-md-7">
                  <h3 class="partner_blueh">CHECK VOUCHER VALIDITY</h3>
                      <p class="forgot_des text-center">To make a booking, enter the customer voucher code below to check it’s validity.                </p>
                      <form class="voucher_val" method="post">
                        <div class="form-group">
                          <input type="text" name="vcode" class="form-control rounded_form_control" placeholder="Enter customer voucher code here">
                        </div>
                        <button type="submit" name="VALIDITY" class="btn btn_rounded">CHECK VALIDITY</button>
                      </form>   
                    </div>
                  </div>
                </div>
             </div>
              </div>
                <!-- <form method="post" id="redeem_v" name="redeem_v"> -->
                <form id="redeem_v" action="" name="redeem_v" method="post">
                  <hr><br>
                  <?=$util->msg_box()?>
                  <?=$_redeem_v_table?>
                </form>
              </div>
            </div><!-- result-->
          </div>
        </section>
    <!--end desktop-->
    <!--start mobile-->
    <section  class="blue_band text-center mobile_view">
			<h2 class="">HAPPYBOX PARTNER PORTAL</h2>
			</section>
   <section  class="mob_maroon_section text-center mobile_view">
			<h4 class="">HOW IT WORKS</h4>
			</section>
  
<section class="mob_section_60 mobile_view" id="reset_div">
      <div class="container">
      <div class="row  ">
        <div class="col-12 how_steps_mob_wrap">
          
          <div class="card how_it_work_card mob_no_border">
                 <div class="row step_p">
                  <div class="col-3 no_padd">
                    <span class="step_span">STEP 1 </span>  
                  </div>
                      <div class="col-9 howmob_top no_pad_left">
                       Customer calls for a booking
                  </div>
                       </div>
                  <div class="row step_p">
                  <div class="col-3 no_padd">
                    <span class="step_span">STEP 2 </span>
                  </div>
                      <div class="col-9 howmob_top no_pad_left">
                      <b>YOU</b> request customer voucher code
                  </div>
                       </div>
                  <div class="row step_p">
                  <div class="col-3 no_padd">
                    <span class="step_span">STEP 3 </span>  
                  </div>
                      <div class="col-9 no_pad_left howmob_top">
                       <b>YOU</b> check the voucher code validity online
                  </div>
                       </div>
                  <div class="row step_p">
                  <div class="col-3 no_padd">
                    <span class="step_span">STEP 4 </span>  
                  </div>
                      <div class="col-9 no_pad_left howmob_top">
                     <b>YOU</b> indicate the booking date
                  </div>
                       </div>
                  <div class="row step_p">
                  <div class="col-3 no_padd">
                    <span class="step_span">STEP 5 </span>  
                  </div>
                      <div class="col-9 no_pad_left howmob_top">
                      <b>YOU</b> redeem & confirm booking to customer
                  </div>
                       </div>
             
          </div>
      </div>
        
              </div>
                
              </div>
    
            </div><!-- result-->
          </div>
        </section>
  <section id="mob-val" class="check_voucher_s mobile_view" >
      <div class="mob_relative">     <img src="../shared/img/icn-arrow-blue-mob.svg" class="floating_arrow"/></div>
 
      <div class="container">
      <div class="row  text-center">
        <div class="col-12">
            <h3 class="mob_blue check_voucher_s_h">CHECK VOUCHER VALIDITY</h3>
          
          <div class="check_voucher_s_p">
              <p class="mob_light_blue mob_font16">
                  To make a booking, enter the customer voucher code below to check it’s validity.
              </p>
          </div>
            <form class="voucher_val" method="post">
                        <div class="form-group">
           <input type="text" name="vcode" class="form-control rounded_form_control" placeholder="Enter customer voucher code here">
                        </div>
                        <button type="submit" name="VALIDITY" class="btn btn_rounded">CHECK VALIDITY</button>
                      </form>
      </div>
        
              </div>
                
              </div>
    
            </div><!-- result-->
          </div>
        </section>
    <!--end mobile-->
<?php  include '../shared/partials/loggedin-footer.php';?>
  <!-- Page Content -->
  <!-- Bootstrap core JavaScript -->
<!-- pop up -->
<button type="button" id="popupid" style="display:none;" class="btn btn_rounded" data-toggle="modal" data-target="#partnerEdit"></button>
  <div class="modal fade" id="partnerEdit">
    <div class="modal-dialog general_pop_dialogue">
      <div class="modal-content">
        <div class="modal-body text-center">
        <div class="col-md-12 text-center forgot-dialogue-borderz">
        <h3 class="partner_blueh">THANK YOU!</h3>
        <p class="forgot_des text-center">
          Your voucher <span id="vvv"></span> has been redeemed and service boooked for customer.                
        </p>
        <div>
        <img src="../shared/img/btn-okay-blue.svg" class="password_ok_img" data-dismiss="modal"/>
        </div>
        </div>
      </div>
      </div>
    </div>
  </div>
<!-- end pop up -->
<?php include '../shared/partials/js.php';?>
</body>
<script>  
    $(document).ready(function(){
      redeem_voucher = function(FormId){
      waitingDialog.show('redeeming... Please wait',{headerText:'',headerSize: 6,dialogSize:'sm'});
      var dataString = $("form[name=" + FormId + "]").serialize();
      $.ajax({
          type: 'post',
          url: '<?=$util->AjaxHome()?>?activity=redeem-ptn-voucher',
          data: dataString,
          success: function(res){
              // console.log(res);
              var rtn = JSON.parse(res);
              if(rtn.hasOwnProperty("MSG")){
                  // $("#reset_div").load(window.location.href + " #reset_div" );
                  $("#vvv").text(rtn.V);
                  $("#err").hide();
                  $('#popupid').trigger('click');
                  waitingDialog.hide();
                  setTimeout(function() {
                    window.location.replace("partner-voucher-list.php");
                  }, 5000);
                  return;
              }
              else if(rtn.hasOwnProperty("ERR")){
                  $('#err').text(rtn.ERR);
                  $('#err').show(rtn.ERR);
                  waitingDialog.hide();
                  return;
              }
          }
      });
      }
  });  
</script>
  
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#booking_date" ).datepicker();
  } );
  </script>

</html>
