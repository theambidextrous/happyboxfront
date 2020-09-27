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
                border-bottom: solid 2px #04C1C9 !important;
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

    
        <section class=" user_account_sub_banner desktop_view">
            <div class="container">
                <div class="row user_logged_in_nav">
                    <div class="col-md-12">
                    <?php include 'shared/partials/nav-mid.php'; ?>
                    </div>

                </div> </div>
        </section>




        <!--end discover our selection-->
        
           



    <section class="partner_voucher_list section_60 desktop_view">
           <div class="container">
                    <div class="row justify-content-center forgot-dialogue-wrap">
                    <div class="col-md-12">
                      <h3 class="user_blue_title text-center">MY VOUCHER LIST</h3>
                      <p class="txt-orange text-center">A list of your activated vouchers
                        <br>
                        <div id="err" style="display:none;width:30%;margin: 0px auto;" class="text-center alert alert-danger"></div>
                      </p>
                      <!--start desktop-->
                      <div class="table-responsive ">
                      <div class="table_radius table_radius_voucher_ls">
                        <table class="table  voucher_list_table table-bordered">
                          <thead>
                            <tr>
                                <th class="blue_cell_th th_box">BOX<br> NAME</th>
                              <th class="voucher_list_table_th">BOX<br> NUMBER</th>
                              <th class="voucher_list_table_th">VOUCHER<br> CODE</th>
                              <th class="voucher_list_table_th">STATUS</th>
                              <th class="voucher_list_table_th">DATE <br>REDEEMED</th>
                              <th class="voucher_list_table_th">BOX VALIDITY<br> DATE</th>
                              <th class="voucher_list_table_th">CANCELLATION<br> DATE</th>
                              <th class="voucher_list_table_th">BOOKING<br> DATE</th>
                              <th class="voucher_list_table_th">PARTNER</th>
                              <th class="txt-blue"><!--<a href="" class="tooltips">
        <span>PARTNER RATING</span>
        
        </a>-->
                           <!-- <a href="#" class="text-black tooltips2">
         PARTNER RATING <span>Please rate this partner based on your experience</span>
        
        </a>-->
                           PARTNER RATING 
                              
                              </th>
                              <th colspan="2" class="th_actions voucher_list_table_th">ADMIN REQUESTS</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                              if(count($my_list_)){
                                foreach( $my_list_ as $my_l):
                                  $admin_func_ = '<td class="empty_cell"></td>';
                                  if($my_l['box_voucher_status'] == 6){
                                    $_voucher = "'".$my_l['box_voucher']."'";
                                    $admin_func_ = '
                                    <td class="td_orange" onclick="declare_lost('.$_voucher.')">DECLARE LOSS OR THEFT OF VOUCHER</td>
                                    ';
                                  }
                                  $_box_data = json_decode($box->get_byidf('00', $my_l['box_internal_id']))->data;
                                  $redeemed_date = $my_l['redeemed_date'];
                                  $redeem_div = '<td class="empty_cell"></td>';
                                  if(!empty($redeemed_date)){
                                    $redeem_div = '<td>'.date('d/m/Y',strtotime($redeemed_date)).'</td>';
                                  }
                                  $cancellation_date = $my_l['cancellation_date'];
                                  $cancellation_div = '<td class="empty_cell"></td>';
                                  if($my_l['box_voucher_status'] == 4){
                                    $cancellation_div = '<td>'.date('d/m/Y',strtotime($cancellation_date)).'</td>';
                                  }
                                  $booking_date = $my_l['booking_date'];
                                  $booking_div = '<td class="empty_cell"></td>';
                                  if($my_l['box_voucher_status'] == 3){
                                    $booking_div = '<td>'.date('d/m/Y',strtotime($booking_date)).'</td>';
                                  }
                                  $validity_date = '';
                                  if($my_l['box_voucher_status'] != 4){
                                    $validity_date = date('d/m/Y',strtotime($my_l['box_validity_date']));
                                  }
                                  $partner_name = $my_l['partner_internal_id'];
                                  $rating_value = 0;
                                  if(!empty($partner_name)){
                                    $ptn = $user->get_details_byidf($my_l['partner_internal_id']);
                                    $partner_name = json_decode($ptn)->data->business_name;
                                    $rating_value = json_decode($rating->get_ptn_value($my_l['partner_internal_id']))->data;
                                    if(!$rating_value){
                                      $rating_value = 0;
                                    }
                                  }
                            ?>
                            <tr>
                              <td class="light_blue_cell bold_txt"><?=strtoupper($_box_data->name)?></td>
                              <td><?=strtoupper($my_l['id'])?></td>
                              <td><?=$my_l['box_voucher']?></td>
                              <?=$util->voucher_div($my_l['box_voucher_status'])?>
                              <?=$redeem_div?>
                              <td><?=$validity_date?></td>
                              <?=$cancellation_div?>
                              <?=$booking_div?>
                              <td class=""><?=$partner_name?></td>
                              <td class="gray_star">
                                <?=$util->patner_rating($rating_value)?>
                              </td>
                              <?=$admin_func_?>
                            </tr>
                            <?php 
                                endforeach;
                              }
                            ?>
                          </tbody>
                        </table>
                </div>
                </div> 
                           </section>
                      <!--end desktop-->
                      <!--start mobile view-->
                        <!--mobile header start-->
         <section class=" user_account mobile_view">
      <div class="container">
      <div class="row">
          <div class="col-md-12 text-center">
              <h3 class="text-white user_main_title_mob">MY VOUCHER LIST</h3>  
             
          </div>
          
      </div> </div>
      </section>
          <!--mobile header end-->
                         <div class="voucher_list_mob mobile_view container">
                     <div class="row  ">
        <div class="col-md-12 ">
               
              <p class="txt-orange text-center mob_pad">A list of your activated vouchers
                      
                      
                      </p>
             <table class="table  voucher_list_table_mob voucher_list_user_table_mob table-borderless">
                <thead>
                  <tr class="blue_cell_th_mob blue_cell_user_th_mob text-white">
                    <th >BOX NAME</th>
                    <th>STATUS</th>
                  </tr>
                </thead>
                <tbody>
                    <tr class="voucher_list_user_table_mob_tr voucher_list_user_table_mob_tr1">
                        <td class="v_td_a">SPA EXPERIENCE</td>  <td class="green_txt_valid"><span class=""><b>VALID</b></span></td>
                    </tr>
                     <tr class="voucher_list_user_table_mob_tr">
                        <td class="v_td_a">Voucher Code</td>  <td>AZERTY001</td>
                    </tr>
                      <tr class="voucher_list_user_table_mob_tr">
                        <td class="v_td_a">Box Number</td>  <td>456</td>
                    </tr>
                    
                     <tr class="voucher_list_user_table_mob_tr">
                        <td class="v_td_a">Date Redeemed</td>  <td>06/03/2020</td>
                    </tr>
                      <tr class="voucher_list_user_table_mob_tr">
                        <td class="v_td_a">Expiry Date</td>  <td>06/03/2020</td>
                    </tr>
                     <tr class="voucher_list_user_table_mob_tr">
                        <td class="v_td_a">Date Cancelled</td>  <td>_</td>
                    </tr>
                     <tr class="voucher_list_user_table_mob_tr">
                        <td class="v_td_a">Booking Date</td>  <td>_</td>
                    </tr>
                     <tr class="voucher_list_user_table_mob_tr">
                        <td class="v_td_a">Partner</td>  <td>Super Spa</td>
                    </tr>
                    <tr class="voucher_list_user_table_mob_tr">
                        <td class="v_td_a">Partner Rating</td>  <td class="txt_gray"><i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i>
                         <i class="far fa-star"></i> <i class="far fa-star"></i></td>
                    </tr>
                     
                     <tr class="v_td_100">
                         <td class="" colspan="2">Voucher Admin Requests</td>  
                    </tr>
                    
                    <tr class="declare_tr text-center">
                        <td colspan="2" class="v_td_canc">DECLARE LOSS OR THEFT OF VOUCHER</td>  
                    </tr>
                </tbody>
             </table>
            <!--table 2-->
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
                    
                    
                </tbody>
             </table>
       
  
        </div>
           
                     </div></div>
                      <!--end mobile view-->
              </div>
                </div>
              </div>
   
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
                <p class=" text-center txt-orange">You will receive an email shortly.</p>
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
