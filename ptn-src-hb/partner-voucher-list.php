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
$list = $inventory->get_by_partner(json_decode($_SESSION['usr_info'])->data->internal_id);
$list = json_decode($list, true)['data'];
$util->Show($list);
?>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Happy Box:: Partner Voucher List</title>
  <!-- Bootstrap core CSS -->
 <?php include '../shared/partials/css.php'; ?>
 <style>
   .t-voucher{
      color: #c20a2b!important;
      text-decoration: none!important;
      border-bottom: solid 2px #c20a2b!important;
   }
 </style>
   <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    //$( "#datepicker" ).datepicker();
    $("#datepicker").datepicker();
$('#selec').click(function(){
    $('#datepicker').toggle();
});
  } );
  </script>





</head>

<body>
  <!-- Navigation -->
 <?php include '../shared/partials/nav-logged-in.php'; ?>
  <section class="partner_voucher_list section_60">
    <div class="container">
      <div class="row justify-content-center forgot-dialogue-wrap">
        <div class="col-md-12">
          <h3 class="partner_blueh text-center">MY VOUCHER LIST</h3>
          <p class="forgot_des text-center">Your list of Redeemed and Cancelled vouchers</p>
          <div class="table-responsive">
            <div class="table_radius">
              <table class="table  voucher_list_table table-bordered">
                <thead>
                  <tr>
                    <th class="blue_cell_th th_box">BOX NAME</th>
                    <th>VOUCHER CODE</th>
                    <th>STATUS</th>
                    <th class="">CUSTOMER NAME</th>
                    <th>CUSTOMER SURNAME</th>
                    <th>DATE REDEEMED</th>
                    <th>DATE CANCELLED</th>
                    <th>BOOKING DATE</th>
                    <th>PARTNER PAYMENT DATE</th>
                    <th>PARTNER REIMBURSEMENT</th>
                    <th colspan="2" class="th_actions">VOUCHER ADMINISTRATION</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  foreach ( $list as $_list ):
                    $date_redeemed = date('m/d/Y', strtotime($_list['redeemed_date']));
                    /** cancellation */
                    if(!is_null($_list['booking_date'])){
                      $date_booked = '<td>'.date('m/d/Y', strtotime($_list['booking_date'])).'</td>';
                    }else{
                      $date_booked = '<td class="empty_cell"></td>';
                    }
                    /** booking */
                    if(!is_null($_list['cancellation_date']) && $_list['box_voucher_status'] == 4){
                      $date_cancelled = '<td>'.date('m/d/Y', strtotime($_list['cancellation_date'])).'</td>';
                    }else{
                      $date_cancelled = '<td class="empty_cell"></td>';
                    }
                    /** partner paid */
                    if(!is_null($_list['partner_pay_due_date'])){
                      $date_ptn_paid = '<td>'.date('m/d/Y', strtotime($_list['partner_pay_due_date'])).'</td>';
                    }else{
                      $date_ptn_paid = '<td class="empty_cell"></td>';
                    }
                    /** */
                    $box_idf = $_list['box_internal_id'];
                    $box_voucher_code = $_list['box_voucher'];
                    if(!is_null($_list['box_voucher_new'])){
                      $box_voucher_code = $_list['box_voucher_new'];
                    }
                    $voucher = "'". $box_voucher_code . "'";
                    $box_voucher_status = $_list['box_voucher_status'];
                    $admin_func = '';
                    if($box_voucher_status == 3){
                      $b_v_status = '<td class="hap_success">REDEEMED</td>';
                      $admin_func = '
                      <td class="hap_danger">
                      <a href="#" class="text-white" onclick="cancell_voucher_pop('.$voucher.')" title="Hooray!">CANCEL VOUCHER </a>  
                      </td>
                      <td class="hap_primary">
                      MODIFY DATE <a href=""><img src="../shared/img/icons/icn-edit-teal.svg" class="td_edit_img"/></a>  
                      </td>';
                    }elseif($box_voucher_status == 4){
                      $admin_func = '
                      <td class="empty_cell"></td>
                      <td class="empty_cell"></td>';
                      $b_v_status = '<td class="hap_danger">CANCELLED</td>';
                    }else{
                      $b_v_status = '<td class="empty_cell"></td>';
                    }
                    $box_data = json_decode($box->get_byidf($token, $box_idf))->data;
                  ?>
                  <tr>
                    <td class="light_blue_cell"><?=$box_data->name?></td>
                    <td><?=$box_voucher_code?></td>
                    <?=$b_v_status?>
                    <td>Name 1</td>
                    <td>Name 2</td>
                    <td><?=$date_redeemed?></td>
                    <?=$date_cancelled?>
                    <?=$date_booked?>
                    <?=$date_ptn_paid?>
                    <td>Ksh <?=number_format($_list['partner_pay_amount'],2)?></td>
                    <?=$admin_func?>
                  </tr>
                  <?php
                  endforeach;
                  ?>
                </tbody>
              </table>
            </div>
          </div> 
          <br>          <br>
          <div class="table-responsive">
            <div class="table_radius">
              <table class="table  voucher_list_table table-bordered">
                <thead>
                  <tr>
                    <th class="blue_cell_th th_box">BOX NAME</th>
                    <th>VOUCHER CODE</th>
                    <th>STATUS</th>
                    <th class="">CUSTOMER NAME</th>
                    <th>CUSTOMER SURNAME</th>
                    <th>DATE REDEEMED</th>
                    <th>DATE CANCELLED</th>
                    <th>BOOKING DATE</th>
                    <th>PARTNER PAYMENT DATE</th>
                    <th>PARTNER REIMBURSEMENT</th>
                    <th colspan="2" class="th_actions">VOUCHER ADMINISTRATION</th>
                  </tr>
                </thead>
                <tbody>
               <tr>
          <td class="light_blue_cell">
            SPA EXPERIENCE
          </td>
        <td>azerty</td>
        <td class="hap_danger">CANCELLED</td>
         
           <td>Bloggs</td>
            <td>Joe</td>
              <td>06/03/2020</td>
                <td>06/03/2020</td>
                <td class="empty_cell"></td>
                   <td class="empty_cell"></td>
                    <td>Ksh5 000.00</td>
            <td class="empty_cell">
               
                
            </td>
             <td class="empty_cell">
               
                
            </td>
            
      </tr>
      <tr>
          <td class="light_blue_cell">
            SPA EXPERIENCE
          </td>
        <td>qwerty</td>
        <td class="hap_success">REDEEMED</td>
         
           <td>Smith</td>
            <td>Joe</td>
              <td>15/02/2020</td>
                <td class="empty_cell"></td>
                  <td>15/02/2020</td>
                   <td>31/03/2020</td>
                    <td>31/03/2020</td>
                    <td class="hap_danger" >
              
                        <a href="#" class="text-white" data-toggle="tooltip" data-placement="top" title="Hooray!">CANCEL VOUCHER </a>     
            </td>
                <td id="datepickerx" class="hap_primary">
                    
                    MODIFY DATE  <a href=""><img src="../shared/img/icons/icn-edit-teal.svg" class="td_edit_img"/></a> <input type="text" id="datepicker" > 
           
                
            </td>
            
      </tr>
                </tbody>
              </table>
            </div>
          </div> 
        <p class="text-center pad_top20"><button type="submit" class="btn btn_rounded btn-dark-blue btn-sm"> SAVE MY CHANGES</button></p>
        </div>
      </div>
    </div>
  </section>
<?php include '../shared/partials/loggedin-footer.php';?>
  <!-- Page Content -->
  <!-- Bootstrap core JavaScript -->
<?php include '../shared/partials/js.php';?>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#datepickerx" ).datepicker();
  } );
  </script>
</body>
<!-- pop up -->
<button type="button" id="popupid" style="display:none;" class="btn btn_rounded" data-toggle="modal" data-target="#voucher_c"></button>
  <div class="modal fade" id="voucher_c">
    <div class="modal-dialog general_pop_dialogue">
      <div class="modal-content">
        <div class="modal-body text-center">
        <div class="col-md-12 text-center forgot-dialogue-borderz">
        <h3 class="partner_blueh">CANCEL VOUCHER?</h3>
        <p class="forgot_des text-center">
          You are about to cancel this voucher. This cannot be undone, perhaps you should reconsider.                
        </p>
        <form class="voucher_val" method="post">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Voucher</label>
                <input type="hidden" name="partner" value="<?=json_decode($_SESSION['usr_info'])->data->internal_id?>">
                <input type="text" readonly id="vcode" name="vcode" class="form-control rounded_form_control" value="Enter customer voucher code here">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Reason for Cancellation</label>
                <input type="text" name="vreason" class="form-control rounded_form_control" placeholder="Why you are cancelling this voucher">
              </div>
            </div>
          </div>
          <button type="button" data-dismiss="modal" class="btn btn_rounded">Not now</button>
          <button type="button" onclick="cancell_voucher()" class="btn btn_rounded">Cancel Voucher</button>
        </form>   
        <div>
        <!-- <img src="../shared/img/btn-okay-blue.svg" class="password_ok_img" data-dismiss="modal"/> -->
        </div>
        </div>
      </div>
      </div>
    </div>
  </div>
<!-- end pop up -->
</body>
 
   
<script>  
    $(document).ready(function(){
      cancell_voucher_pop = function(vcode){
      waitingDialog.show('opening... Please wait',{headerText:'',headerSize: 6,dialogSize:'sm'});
      $("#vcode").val(vcode);
      $('#popupid').trigger('click');
      waitingDialog.hide();
      }

      cancell_voucher = function(FormId){
      waitingDialog.show('updating... Please wait',{headerText:'',headerSize: 6,dialogSize:'sm'});
      var dataString = $("form[name=" + FormId + "]").serialize();
      $.ajax({
          type: 'post',
          url: '<?=$util->AjaxHome()?>?activity=cancel-ptn-voucher',
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
