<?php
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
$util = new Util();
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Happy Box:: User Login Page</title>

  <!-- Bootstrap core CSS -->
 <?php include 'shared/partials/css.php'; ?>
</head>

<body>
  <!-- Navigation -->
 <?php include 'shared/partials/nav.php'; ?>
  <!-- Page Content --> 

  <section class=" user_account">
      <div class="container">
      <div class="row">
          <div class="col-md-12 text-center">
              <h3 class="text-white">REGISTER YOUR HAPPYBOX VOUCHER</h3>         
          </div>
          
      </div> </div>
      </section>
    <section class=" user_account_sub_banner">
      <div class="container">
      <div class="row justify-content-center">
          <div class="col-md-9 text-center">
              <h5 class="">
           To register your HAPPYBOX voucher you will need an account. Please login or create one. </h5>

          </div>
          
      </div> </div>
      </section>
  
  
    

<!--end discover our selection-->
 <section class="container section_padding_top contact_content">
      <div class="row justify-content-center">
          <div class="col-md-5 user_login_l  ">
              <h3 class="user_account_title text-center">HAPPYBOX ACCOUNT LOGIN</h3>
              <form class="user_login">
						<div class="form-group">

  <input type="text" class="form-control rounded_form_control" placeholder="Email address">
</div>
<div class="form-group">
 
  <input type="password" class="form-control rounded_form_control" placeholder="Password">
</div>
                <div class="form-group user_blue_border">  <div class="form-check">
  <label class="form-check-label">
      <input type="checkbox" class="form-check-input" value=""> <span class="span_blue"> Stay Connected</span> 
  </label>
                        <br>
                        <small class="text-orange">Sign-up for news on latest deals and new boxes</small>
</div></div>
                  <p class="text-center">
                       <button type="submit" class="btn btn_rounded">LOGIN</button>   
                  </p>
                                
                                <p class="text-center gray_text small_p_margin_top">
                                    <a href="user-forgot.php">Forgot password?</a>
									
								</p>
                                                                <p class="text-orange text-center">
                                                                    Don’t have an account yet?
                                                                </p>
                         <p class="text-center">
                             <a href="user-create-account.php" class="btn btn_rounded">CREATE YOUR ACCOUNT
                             </a>
                       
                  </p>
							</form>
            
          </div>
           <div class="col-md-5  user_login_r">
              <div class="card user_login_card">
                  <div class="card-header bg_card_blue text-center text-white"><b>Why register your voucher early?</b></div>
                  <div class="card-body">
                      <div class="row user_login_card_col"> <div class="col-2"><img src="shared/img/icons/check_orange.svg" class="list_icon"> </div>
                          <div class="col-10">Consult the validity status of your box</div></div>
               
                   <div class="row user_login_card_col"> <div class="col-2"><img src="shared/img/icons/check_orange.svg" class="list_icon"> </div>
                          <div class="col-10">Receive an email reminder to book your experience before your voucher expires</div></div>
                            <div class="row user_login_card_col"> <div class="col-2"><img src="shared/img/icons/check_orange.svg" class="list_icon"> </div>
                          <div class="col-10">Activate the loss and theft warranty</div></div>
                           
                    
                      
                      
                  </div>
  
</div>
            
          </div>
                
              </div>
        
          
 
      </section>
<!--end add to cart cards-->
<!--our partners -->




       <?php include 'shared/partials/partners.php';?>
      <?php include 'shared/partials/footer.php';?>
  
  <!-- Bootstrap core JavaScript -->
  
<?php include 'shared/partials/js.php';?>
   
  
 
 

</body>

</html>
