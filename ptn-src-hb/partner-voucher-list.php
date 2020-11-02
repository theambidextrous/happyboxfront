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
// $util->Show(json_decode($_SESSION['usr_info']));
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
   <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> <!--
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#datepicker" ).datepicker();
    $("#datepicker").datepicker();
    $('#selec').click(function(){
        $(this).toggle();
    });
  } );
  </script> -->





</head>

<body>
  <!-- Navigation -->
 <?php include '../shared/partials/nav-logged-in.php'; ?>
  <section class="partner_voucher_list section_60">
    <div class="container">
      <div class="row justify-content-center forgot-dialogue-wrap">
        <div class="col-md-12">
            <div class="desktop_view">
          <h3 class="partner_blueh text-center">MY VOUCHER LIST</h3>
          <p class="forgot_des text-center">Your list of Redeemed and Cancelled vouchers</p>
            </div>
            
             </div>
          <section  class="blue_band text-center mobile_view">
			<h2 class="">HAPPYBOX PARTNER PORTAL</h2>
			</section>
   <section  class="mob_maroon_section text-center mobile_view">
			<h4 class="">MY VOUCHER LIST</h4>
			</section>
             <p class="forgot_des mobile_view mob_canc text-center">Your list of Redeemed and Cancelled vouchers</p>
          <div class="col-md-12 desktop_view">
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
                    $ptn_pay = 0;
                    $date_redeemed = date('d/m/Y', strtotime($_list['redeemed_date']));
                    /** booking */
                    if($_list['box_voucher_status'] != 4){
                      $ptn_pay = $_list['partner_pay_amount'];
                      $date_booked = '<td>'.date('d/m/Y', strtotime($_list['booking_date'])).'</td>';
                    }else{
                      $date_booked = '<td class="empty_cell"></td>';
                    }
                    /** cancellation */
                    if($_list['box_voucher_status'] == 4){
                      $date_cancelled = '<td>'.date('d/m/Y', strtotime($_list['cancellation_date'])).'</td>';
                    }else{
                      $date_cancelled = '<td class="empty_cell"></td>';
                    }
                    /** partner paid */
                    if($_list['box_voucher_status'] != 4){
                      $date_ptn_paid = '<td>'.date('d/m/Y', strtotime($_list['partner_pay_due_date'])).'</td>';
                    }else{
                      $date_ptn_paid = '<td class="empty_cell"></td>';
                    }
                    /** */
                    $box_idf = $_list['box_internal_id'];
                    $box_voucher_code = $_list['box_voucher'];
                    $m_voucher = "'". $box_voucher_code . "'";
                    $box_voucher_status = $_list['box_voucher_status'];
                    $admin_func = '';
                    if($box_voucher_status == 3){
                      $m_partner = "'".json_decode($_SESSION['usr_info'])->data->internal_id."'";
                      $b_v_status = '<td class="hap_success">REDEEMED</td>';
                     /* $admin_func = ' <td class="hap_danger">
                      <a href="#" class="text-white" onclick="cancell_voucher_pop('.$m_voucher.')" title="Hooray!">CANCEL VOUCHER </a>  
                      </td>
                      <td id="datepilckerx" class="hap_primary">
                       <button type="button" class="modify_img_btn" data-toggle="modal" data-target="#myModal">MODIFY DATE  <img src="../shared/img/icons/icn-edit-teal.svg" class="td_edit_img"/></button>
                      <input type="text" class="datepicker" name="newdate" placeholder="" onchange="modify_date(this.value,'.$m_voucher.','.$m_partner.')" onfocus="(this.type=\'date\')"></td>
                      ';*/
                       $admin_func = ' <td class="hap_danger">
                      <a href="#" class="text-white" onclick="cancell_voucher_pop('.$m_voucher.')" title="Hooray!">CANCEL VOUCHER </a>  
                      </td>
                      <td id="datepilckerx" class="hap_primary">
                       <button type="button" class="modify_img_btn" data-toggle="modal" data-target="#myModal">MODIFY DATE  <img src="../shared/img/icons/icn-edit-teal.svg" class="td_edit_img"/></button>
                      </td>
                      ';
  

                    }elseif($box_voucher_status == 4){
                      $admin_func = '
                      <td class="empty_cell"></td>
                      <td class="empty_cell"></td>';
                      $b_v_status = '<td class="hap_danger">CANCELLED</td>';
                    }else{
                      $b_v_status = '<td class="empty_cell"></td>';
                    }
                    $box_data = json_decode($box->get_byidf($token, $box_idf))->data;
                    $c_user_data = json_decode($user->get_details_byidf($_list['customer_user_id']))->data;
                  ?>
                  <tr>
                    <td class="light_blue_cell"><?=$box_data->name?></td>
                    <td><?=$box_voucher_code?></td>
                    <?=$b_v_status?>
                    <td><?=$c_user_data->fname?></td>
                    <td><?=$c_user_data->sname?></td>
                    <td><?=$date_redeemed?></td>
                    <?=$date_cancelled?>
                    <?=$date_booked?>
                    <?=$date_ptn_paid?>
                    <td>Ksh <?=number_format($ptn_pay,2)?></td>
                    <?=$admin_func?>
                  </tr>
                  <?php
                  endforeach;
                  ?>
                </tbody>
              </table>
                <!-- Button to Open the Modal -->



            </div>
          </div> 
          <br>
          <br>

         

          </div>  </div>
             <div class="voucher_list_mob mobile_view">
                     <div class="row  ">
        <div class="col-md-12 ">
             <table class="table  voucher_list_table_mob table-borderless">
                <thead>
                  <tr class="blue_cell_th_mob text-white">
                    <th >BOX NAME</th>
                    <th>STATUS</th>
                  </tr>
                </thead>
                <tbody>
                    <tr class="voucher_list_table_mob_tr">
                        <td class="v_td_a">SPA EXPERIENCE</td>  <td class="v_td_valid">VALID</td>
                    </tr>
                     <tr class="voucher_list_table_mob_tr">
                        <td class="v_td_a">Voucher Code</td>  <td>AZERTY001</td>
                    </tr>
                    <tr class="voucher_list_table_mob_tr">
                        <td class="v_td_a">Customer Name</td>  <td>Joe</td>
                    </tr>
                     <tr class="voucher_list_table_mob_tr">
                        <td class="v_td_a">Customer Surname</td>  <td>Bloggs</td>
                    </tr>
                     <tr class="voucher_list_table_mob_tr">
                        <td class="v_td_a">Date Redeemed</td>  <td>06/03/2020</td>
                    </tr>
                      <tr class="voucher_list_table_mob_tr">
                        <td class="v_td_a">Date Cancelled</td>  <td>_</td>
                    </tr>
                     <tr class="voucher_list_table_mob_tr">
                        <td class="v_td_a">Booking Date</td>  <td>_</td>
                    </tr>
                     <tr class="voucher_list_table_mob_tr">
                        <td class="v_td_a">Partner Payment Date</td>  <td>_</td>
                    </tr>
                    <tr class="voucher_list_table_mob_tr">
                        <td class="v_td_a">Partner Reimbursement</td>  <td>ksh5000.00</td>
                    </tr>
                     <tr class="v_td_100">
                         <td class="" colspan="2">Voucher Administration</td>  
                    </tr>
                    <tr class="voucher_list_table_mob_tr text-center">
                        <td class="v_td_canc">CANCEL VOUCHER</td>  <td class="v_td_modi"> MODIFY DATE<a ><img src="../shared/img/icons/icn-edit-teal.svg" class="td_edit_img td_edit_img_mob"/></a></td>
                    
               </tr>
                </tbody>
             </table>
            <!--table 2-->
            <br>
             <table class="table  voucher_list_table_mob2 table-borderless">
                
                <tbody>
                    <tr>
                        <td class="">SPA EXPERIENCE</td>  <td class="canc_mob_text">CANCELLED</td>
                    </tr>
                     <tr>
                        <td class="">SPORTS & ADVENTURE</td>  <td class="reed_mob_text">REDEEMED</td>
                    </tr>
                    <tr>
                        <td class="">GASTRONOMY</td>  <td class="reed_mob_text">REDEEMED</td>
                    </tr>
                    <tr  style="background:white !important">
                          <td  colspan="2" align="center" class=><button type="button" name=""  class="btn btn_rounded btn-dark-blue">SAVE MY CHANGES</button></td>  
                    </tr>
                    
                </tbody>
             </table>
       
  
        </div>
           
                     </div></div>
     
    </div>
  </section>
<?php  include '../shared/partials/loggedin-footer.php';?>
  <!-- Page Content -->
  <!-- Bootstrap core JavaScript -->
<?php include '../shared/partials/js.php';?>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#pickDate" ).datepicker();
  } );
  </script> 
</body>
<!-- pop up -->
<!-- The Modal -->
<div class="modal modify_date" id="myModal">
  <div class="modal-dialog  modal-sm  ">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title partner_blueh text-center">Modify Date</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
          <div class="row">
             <div class="col-md-12">
                 <div class="form-group" >
                     <input type="text" id="pickDate" class="form-control rounded_form_control" placeholder="Pick date">    
                 </div>
                 <button class="btn btn_rounded btn-dark-blue">Save</button>
              
              
          </div> 
              
          </div>
  
  
      </div>

     

    </div>
  </div>
</div>
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
        <form name="voucher_val" method="post">
        <?=$util->msg_box()?>
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
          <button type="button" onclick="cancell_voucher('voucher_val')" class="btn btn_rounded">Cancel Voucher</button>
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
<!-- modify booking modal -->
<div class="modal fade" id="modif_booking_modal">
  <div class="modal-dialog general_pop_dialogue">
    <div class="modal-content">
      <div class="modal-body text-center">
      <div class="col-md-12 text-center forgot-dialogue-borderz">
      <h3 class="partner_blueh">Modify Booking Date</h3>
      <p class="forgot_des text-center">
        Do you want to change the booking date to the following ?             
      </p>
      <form name="modify_book_frm" method="post">
      <?=$util->msg_box('m')?>
        <div class="row">
          <div class="col-md-4 offset-md-4">
            <div class="form-group">
              <label>Change booking to</label>
              <input type="hidden" name="partner" value="<?=json_decode($_SESSION['usr_info'])->data->internal_id?>">
              <input type="hidden" name="modi_voucher" id="modi_voucher" />
              <input type="text" readonly id="new_booking_date" name="new_booking_date" class="form-control rounded_form_control">
            </div>
          </div>
        </div>
        <button type="button" data-dismiss="modal" class="btn btn_rounded">Not now</button>
        <button type="button" onclick="modify_voucher_booking('modify_book_frm')" class="btn btn_rounded">Yes, I want to modify</button>
      </form>   
      <div>
      </div>
      </div>
    </div>
    </div>
<!-- end mb modal -->

<!--cancel modal-->
<!-- The Modal -->
<div class="modal" id="canc_vouch2">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Modal Heading</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        Modal body..
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>
<!--end cancel modal-->


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
      console.log(dataString);
      $.ajax({
          type: 'post',
          url: '<?=$util->AjaxHome()?>?activity=cancel-ptn-voucher',
          data: dataString,
          success: function(res){
              // console.log(res);
              var rtn = JSON.parse(res);
              if(rtn.hasOwnProperty("MSG")){
                  $('#err').hide();
                  $("#succ").text(rtn.MSG);
                  $('#succ').show();
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

      modify_date = function(date, voucher, partner){
        if(date !== undefined && voucher !== undefined ){
          $('#modi_voucher').val(voucher);
          $('#new_booking_date').val(date);
          $('#modif_booking_modal').modal('show');
          // alert(date);
        }
        return;
      }
      modify_voucher_booking = function(FormId){
      waitingDialog.show('modifying... Please wait',{headerText:'',headerSize: 6,dialogSize:'sm'});
      var dataString = $("form[name=" + FormId + "]").serialize();
      $.ajax({
          type: 'post',
          url: '<?=$util->AjaxHome()?>?activity=modify-voucher-booking',
          data: dataString,
          success: function(res){
              console.log(res);
              var rtn = JSON.parse(res);
              if(rtn.hasOwnProperty("MSG")){
                  $('#merr').hide();
                  $("#msucc").text(rtn.MSG);
                  $('#msucc').show();
                  waitingDialog.hide();
                  setTimeout(function() {
                    window.location.replace("partner-voucher-list.php");
                  }, 3000);
                  return;
              }
              else if(rtn.hasOwnProperty("ERR")){
                  $('#merr').text(rtn.ERR);
                  $('#merr').show(rtn.ERR);
                  waitingDialog.hide();
                  return;
              }
          }
      });
      }


  });  
</script>

</html>
