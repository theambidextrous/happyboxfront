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

  <title>Happy Box:: User Login Forgot Password</title>

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
 
  
  
    

<!--end discover our selection-->
 <section class="container  contact_content section_60">
      <div class="row justify-content-center">
          <div class="col-md-5 user_login_l" >
              <h3 class="user_account_title text-center">FORGOT YOUR PASSWORD?</h3>
            
                               <p class="text-orange text-center">Enter the email address you use to sign in, and we’ll send you a link to reset your password.</p>
           
              
              <div class="user_forgot">
						<div class="form-group">

  <input type="text" class="form-control rounded_form_control" placeholder="Email address">
</div>

                
                  <p class="text-center">
                       <button type="submit" class="btn btn_rounded" data-toggle="modal" data-target="#forgotModal">SEND LINK</button>   
                  </p>
                                
                  <p class="text-center gray_text small_p_margin_top">
                      <a href="user-login.php"><b>Return to login</b></a>
                      <a href="user-create-account.php"> | Don’t have an account yet? Create your account</a>
								</p>
                                                               
                     
							</div>
            
          </div>
           <div class="col-md-5 user_login_l ">
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
   
  
  <!-- pop up -->
  <div class="modal fade" id="forgotModal">
    <div class="modal-dialog general_pop_dialogue">
      <div class="modal-content">
   
                       <div class="modal-body text-center">
                    <div class="col-md-12 text-center forgot-dialogue-borderz">
					<h3 class="partner_blueh">YOUR REQUEST HAS BEEN SENT</h3>
                                        <p class="forgot_des text-center">
                     Please check your emails for a link to reset your password                    
                                        </p>
                                        <div>
                                            <img src="shared/img/btn-okay-blue.svg" class="password_ok_img" data-dismiss="modal"/>
                                        </div>
                       
                        </div>
      </div>
        
      </div>
    </div>
  </div>
  
<!-- end pop up -->
 

</body>

</html>