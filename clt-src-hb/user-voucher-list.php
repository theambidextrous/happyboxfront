<?php
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
require_once('../lib/Inventory.php');
require_once('../lib/Box.php');
require_once('../lib/Picture.php');
require_once('../lib/Rating.php');
$util = new Util();
$user = new User();
$rating = new Rating();
if(!$util->is_client()){
    header('Location: user-login.php');
}
$picture = new Picture();
$util->ShowErrors(1);
$inventory = new Inventory();
$box = new Box();
$token = json_decode($_SESSION['usr'])->access_token;
$my_list_ = $inventory->get_by_cust_user(json_decode($_SESSION['usr_info'])->data->internal_id);
$my_list_ = json_decode($my_list_, true)['data'];
// $util->Show($my_list_);
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Happy Box:: User Dashboard Voucher List</title>

        <!-- Bootstrap core CSS -->
        <?php include 'shared/partials/css.php'; ?>
        <style>
            .user-vlist{
                color: #c20a2b!important;
                text-decoration: none!important;
                border-bottom: solid 2px #c20a2b!important;
            }
        </style>
    </head>

    <body>
        <!-- Navigation -->
        <?php include 'shared/partials/nav.php'; ?>
        <!--user dash nav-->
           <section class="">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                     
                    </div>

                </div> </div>
        </section>
        
         <!--end user dash nav-->
        <!-- Page Content --> 

    
        <section class=" user_account_sub_banner">
            <div class="container">
                <div class="row user_logged_in_nav">
                    <div class="col-md-12">
                    <?php include 'shared/partials/nav-mid.php'; ?>
                    </div>

                </div> </div>
        </section>




        <!--end discover our selection-->
        
           



    <section class="partner_voucher_list section_60">
           <div class="container">
                    <div class="row justify-content-center forgot-dialogue-wrap">
                    <div class="col-md-12">
                      <h3 class="user_blue_title text-center">MY VOUCHER LIST</h3>
                      <p class="txt-orange text-center">A list of your activated vouchers
                        <br>
                        <div id="err" style="display:none;width:30%;margin: 0px auto;" class="text-center alert alert-danger"></div>
                      </p>
                      <div class="table-responsive">
                      <div class="table_radius">
                        <table class="table  voucher_list_table table-bordered">
                          <thead>
                            <tr>
                              <th class="blue_cell_th th_box">BOX NAME</th>
                              <th>BOX NUMBER</th>
                              <th>VOUCHER CODE</th>
                              <th>STATUS</th>
                              <th>DATE REDEEMED</th>
                              <th>BOX VALIDITY DATE</th>
                              <th>CANCELLATION DATE</th>
                              <th>BOOKING DATE</th>
                              <th>PARTNER</th>
                              <th class="txt-blue">PARTNER RATING</th>
                              <th colspan="2" class="th_actions">ADMIN REQUESTS</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                              if(count($my_list_)){
                                foreach( $my_list_ as $my_l):
                                  if($my_l['box_voucher_new']){
                                    $my_l['box_voucher'] = $my_l['box_voucher_new'];
                                  }
                                  $_box_data = json_decode($box->get_byidf('00', $my_l['box_internal_id']))->data;
                                  $redeemed_date = $my_l['redeemed_date'];
                                  $redeem_div = '<td class="empty_cell"></td>';
                                  if(!empty($redeemed_date)){
                                    $redeem_div = '<td>'.date('d/m/Y',strtotime($redeemed_date)).'</td>';
                                  }
                                  $cancellation_date = $my_l['cancellation_date'];
                                  $cancellation_div = '<td class="empty_cell"></td>';
                                  if(!empty($cancellation_date) && !$my_l['box_voucher_new'] ){
                                    $cancellation_div = '<td>'.date('d/m/Y',strtotime($cancellation_date)).'</td>';
                                  }
                                  $booking_date = $my_l['booking_date'];
                                  $booking_div = '<td class="empty_cell"></td>';
                                  if(!empty($booking_date)){
                                    $booking_div = '<td>'.date('d/m/Y',strtotime($booking_date)).'</td>';
                                  }
                                  $partner_name = $my_l['partner_internal_id'];
                                  $rating_value = 0;
                                  $rating_value = json_decode($rating->get_ptn_value('PT-DD97R3YGJZ'))->data;
                                  if(!empty($partner_name)){
                                    $ptn = $user->get_details_byidf($my_l['partner_internal_id']);
                                    $partner_name = json_decode($ptn)->data->business_name;
                                    $rating_value = json_decode($rating->get_ptn_value($my_l['partner_internal_id']))->data;
                                  }
                            ?>
                            <tr>
                              <td class="light_blue_cell"><?=strtoupper($_box_data->name)?></td>
                              <td><?=strtoupper($my_l['id'])?></td>
                              <td><?=$my_l['box_voucher']?></td>
                              <?=$util->voucher_div($my_l['box_voucher_status'])?>
                              <?=$redeem_div?>
                              <td><?=date('d/m/Y',strtotime($my_l['box_validity_date']))?></td>
                              <?=$cancellation_div?>
                              <?=$booking_div?>
                              <td class=""><?=$partner_name?></td>
                              <td class="gray_star">
                                <?=$util->patner_rating($rating_value)?>
                              </td>
                              <td class="td_orange" onclick="declare_lost('<?=$my_l['box_voucher']?>')">DECLARE LOSS OR THEFT OF VOUCHER</td>
                            </tr>
                            <?php 
                                endforeach;
                              }
                            ?>
                          </tbody>
                        </table>
                </div>
                </div> 
              </div>
                </div>
              </div>
        </section>
        <!--end add to cart cards-->
        <!--our partners -->
        <?php include 'shared/partials/partners.php'; ?>
        <?php include 'shared/partials/footer.php'; ?>
        <!-- Bootstrap core JavaScript -->
        <?php include 'shared/partials/js.php'; ?>
      <!-- pop up -->
      <div class="modal fade" id="userdashTheft">
      <div class="modal-dialog general_pop_dialogue">
      <div class="modal-content">
      <div class="modal-body text-center">
      <div class="col-md-12 text-center forgot-dialogue-borderz">
      <h3 class="partner_blueh ">Your loss or theft declaration is being processed</h3>
      <p class=" text-center txt-orange">
      You will receive an email shortly.             
      </p>
      <div>
      <img src="shared/img/btn-okay-orange.svg" class="password_ok_img" data-dismiss="modal"/>
      </div>

      </div>
      </div>

      </div>
      </div>
      </div>

  <script>  
    $(document).ready(function(){
      declare_lost = function(v){
      waitingDialog.show('requesting... Please wait',{headerText:'',headerSize: 6,dialogSize:'sm'});
      var dataString = "voucher=" + v + "&customer_user_id=<?=json_decode($_SESSION['usr_info'])->data->internal_id?>";
      $.ajax({
          type: 'post',
          url: '<?=$util->AjaxHome()?>?activity=declare-lost-voucher',
          data: dataString,
          success: function(res){
              console.log(res);
              var rtn = JSON.parse(res);
              if(rtn.hasOwnProperty("MSG")){
                  $('#err').hide();
                  $('#userdashTheft').modal('show');
                  waitingDialog.hide();
                  return;
              }
              else if(rtn.hasOwnProperty("ERR")){
                  $('#err').text(rtn.ERR);
                  $('#err').show();
                  waitingDialog.hide();
                  return;
              }
          }
      });
      }
  });  
</script>
<!-- end pop up -->
      
        





    </body>

</html>
