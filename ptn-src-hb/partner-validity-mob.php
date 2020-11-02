
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
<body class="partner_wrap">
  <!-- Navigation -->
 <?php include '../shared/partials/nav-logged-in.php'; ?>
   <section  class="blue_band text-center">
			<h2 class="">HAPPYBOX PARTNER PORTAL</h2>
			</section>
   <section  class="mob_maroon_section text-center">
			<h4 class="">VALIDITY RESULT</h4>
			</section>
  
<section class="mob_section_60" id="reset_div">
      <div class="container">
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
                        <td class="v_td_canc">CANCEL VOUCHER</td>  <td class="v_td_modi"> MODIFY DATE<a href="##"><img src="../shared/img/icons/icn-edit-teal.svg" class="td_edit_img td_edit_img_mob"/></a></td>
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
                    <tr  style="background:white !important">
                          <td  colspan="2" align="center" class=><button type="button" name=""  class="btn btn_rounded btn-dark-blue">SAVE MY CHANGES</button></td>  
                    </tr>
                    
                </tbody>
             </table>
       
  
        </div>
           
                     </div>
    
            </div><!-- result-->
          </div>
        </section>
  <section class="check_voucher_s" >
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
  
<?php  include '../shared/partials/loggedin-footer.php';?>

<!-- end pop up -->
<?php include '../shared/partials/js.php';?>
</body>

</html>
