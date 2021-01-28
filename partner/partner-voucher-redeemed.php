<?php
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
$util = new Util();
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

  <title>Happy Box:: Partner Voucher Redeemed</title>
  <!-- Bootstrap core CSS -->
 <?php include '../shared/partials/css.php'; ?>

</head>

<body class="partner_wrap">
  <!-- Navigation -->
 <?php include '../shared/partials/nav-logged-in.php'; ?>
 
<section class="section_60">
            <div class="container">
			
               
                    <div class="row partner_booking ">
                        <div class="col-md-5">
                            <div class=" how_it_work">                                
                                         <img src="../shared/img/howitworks.svg" class=""/>  
                                   
                                
                            </div>
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
                              <div class="row justify-content-center">
                                  <div class="col-md-7">
                                    <h3 class="partner_blueh">CHECK VOUCHER VALIDITY</h3>
                                        <p class="forgot_des text-center">
                     To make a booking, enter the customer voucher code below to check it’s validity.                
                                        </p>
                                              <form class="voucher_val">
						<div class="form-group">

  <input type="text" class="form-control rounded_form_control" placeholder="Enter customer voucher code here">
</div>
                                    <button type="submit" class="btn btn_rounded">CHECK VALIDITY</button>
                               
                         
							</form>   
                                      
                                  </div>
                                   
                                   </div>
					
                                        
                       
                        </div>
                       
                

                </div>
              </div>
        </section>

<?php  include '../shared/partials/loggedin-footer.php';?>
  <!-- Page Content -->

  <!-- Bootstrap core JavaScript -->
  
<?php include '../shared/partials/js.php';?>
  <div class="modal fade" id="voucherRedeemed">
    <div class="modal-dialog redeemed_dialogue">
      <div class="modal-content">
      
   
        
        <!-- Modal body -->
        <div class="modal-body text-center">
            <h3 class="dark_blue">THE VOUCHER HAS BEEN REDEEMED</h3>
            <p class="light_blue">
            You can access this booking under My Voucher List  
            </p>
             <div>
                                            <img src="../shared/img/btn-okay-blue.svg" data-dismiss="modal" class="password_ok_img"/>
                                        </div>
        </div>
        
      
        
      </div>
    </div>
  </div>
   <script>
    $(document).ready(function(){
        $("#voucherRedeemed").modal('show');
    });
</script>
  
 
 

</body>

</html>
