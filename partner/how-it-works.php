
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
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
<!--meta words-->
<meta name="keywords" content="vouchers,birthday gift,valentine gift,gift a gift,christmas gift,easter gift,wedding gift,anniversary gift">
<meta name="description" content="HappyBox issues vouchers to its customers via its website. Each voucher is an opportunity to suggest an appropriate set of experiences for the recipient of the voucher.">
<meta name="robots" content="index, follow">
<link rel="canonical" href="https://happybox.ke/">
<meta property="og:locale" content="en_US">
<meta property="og:type" content="website">
<meta property="og:title" content="HappyBox">
<meta property="og:description" content="HappyBox issues vouchers to its customers via its website. Each voucher is an opportunity to suggest an appropriate set of experiences for the recipient of the voucher.">
<meta property="og:url" content="https://happybox.ke/">
<meta property="og:site_name" content="HappyBox">
<meta property="og:image" content="https://happybox.ke/shared/img/logo.svg">
<meta property="og:image:width" content="320">
<meta property="og:image:height" content="88">        
        <!--end meta words -->

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
			<h4 class="">HOW IT WORKS</h4>
			</section>
  
<section class="mob_section_60" id="reset_div">
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
