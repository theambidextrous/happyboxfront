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
      color: #c20a2b!important;
      text-decoration: none!important;
      border-bottom: solid 2px #c20a2b!important;
   }
 </style>
</head>
<body>
  <!-- Navigation -->
 <?php include '../shared/partials/nav-logged-in.php'; ?>
<section class="section_60" id="reset_div">
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
                <p class="step_p"> <span class="step_span">STEP 5 </span>  <b>YOU</b> redeem & confirm booking to customer </p>
              </div>
          </div>
      </div>
        <div class="col-md-7 text-center how_it_work_border">
            <?php
              $_redeem_v_table = null;
              if(isset($_POST['VALIDITY']) && !empty($_POST['vcode'])){
                  $voucher_code = $_POST['vcode'];
                  $res = $inventory->get_by_voucher($token, $voucher_code);
                  // print $util->Show($res);
                  $res = json_decode($res, true)['data'];
                  // print $util->Show($res);
                  if(isset($res['box_internal_id'])){
                      $idf = $res['partner_internal_id'];
                      $box_idf = $res['box_internal_id'];
                      $box_data = json_decode($box->get_byidf($token, $box_idf))->data;
                      $data_0 = [
                          $res['box_voucher'],
                          $res['box_voucher_status']
                      ];
                      $data_1 = [
                        $box_data->name,
                        $box_data->description,
                        json_decode($_SESSION['usr_info'])->data->internal_id
                    ];
                  }else{
                      $data_0 = $data_1 = [
                          'Invalid',
                          'Invalid'
                      ];
                  }
                  $_redeem_v_table = $util->ptn_v_validity($data_0, $data_1);
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
<?php include '../shared/partials/loggedin-footer.php';?>
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
      waitingDialog.show('updating... Please wait',{headerText:'',headerSize: 6,dialogSize:'sm'});
      var dataString = $("form[name=" + FormId + "]").serialize();
      $.ajax({
          type: 'post',
          url: '<?=$util->AjaxHome()?>?activity=redeem-ptn-voucher',
          data: dataString,
          success: function(res){
              // console.log(res);
              var rtn = JSON.parse(res);
              if(rtn.hasOwnProperty("MSG")){
                  $("#reset_div").load(window.location.href + " #reset_div" );
                  $("#vvv").text(rtn.V);
                  $('#popupid').trigger('click');
                  waitingDialog.hide();
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
</html>
