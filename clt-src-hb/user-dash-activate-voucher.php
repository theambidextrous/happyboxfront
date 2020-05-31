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

        <title>Happy Box:: User Create Account Pop Up</title>

        <!-- Bootstrap core CSS -->
        <?php include 'shared/partials/css.php'; ?>
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
                  <ul class="">
                            <li><a href="">Register Your Voucher</a></li>
                              <li><a href="">My Voucher List</a></li>
                               <li><a href="">My Purchase History</a></li>
                                <li><a href="">My Profile</a></li>
                             
                                 
                        </ul>

                    </div>

                </div> </div>
        </section>




        <!--end discover our selection-->
        <section class="container section_60 ">
            <div class="row justify-content-center">
                <div class="col-md-5  text-center user_activate_l">
                      <h3 class="user_blue_title ">REGISTER YOUR VOUCHER</h3>
                        <p class="txt-orange">
                            Enter your voucher code and click activate code
                        </p>
               
                    <div class="card border_blue_radius text-center user_activate_card">

                        <div class="row">
                         <div class="col-md-8">
                            
                                  
                                    <input type="text" name="Fname" class="form-control rounded_form_control" placeholder="Required Field">
                              
                                
                            </div>
                             <div class="col-md-4">
                                  
              <button type="submit" class="btn btn_rounded btn-orange" data-toggle="modal" data-target="#userVoucherActivate">ACTIVATE</button>   
                            
                                
                            </div>
                        </div>

                    </div>


                </div>
                <div class="col-md-5">
                    <div class="user_activate_r">
                        

                                 
                                 <div class="user_activate_steps">
                                     <img src="shared/img/user_iwant.svg" class="w-100"/>
                                     <div class="border_blue_radius card_v_steps">
                                     <div class="user_activate_steps_i">
                                         
                                         <div class="row">
                                              <div class="col-1">  <span class="inline_div inline_div_first">1</span></div>
                                                <div class="col-11"> <b>ACTIVATE</b>  your voucher  </div>
                                          </div>
                                     </div>
                                      <div class="user_activate_steps_i user_activate_steps_i_mid">
                                      
                                           <div class="row">
                                              <div class="col-1">  <span class="inline_div">2</span></div>
                                                <div class="col-11"> <b>SELECT</b> one experience in the booklet   </div>
                                          </div>
                                     </div>
                                      <div class="user_activate_steps_i user_activate_steps_i_mid">
                                          <div class="row">
                                              <div class="col-1">  <span class="inline_div ">3</span></div>
                                                <div class="col-11"><b>BOOK</b> your experience with the partner and share your voucher code with them</div>
                                          </div>
                                          
                                     </div>
                                      <div class="user_activate_steps_i user_activate_steps_i_last">
                                 
                                           <div class="row">
                                              <div class="col-1">  <span class="inline_div_last inline_div ">4</span></div>
                                                <div class="col-11"><b> ENJOY</b> your experience   </div>
                                          </div>
                                     </div>
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
  <div class="modal fade" id="userVoucherActivate">
    <div class="modal-dialog general_pop_dialogue">
      <div class="modal-content">
   
                       <div class="modal-body text-center">
                    <div class="col-md-12 text-center forgot-dialogue-borderz">
					<h3 class="partner_blueh ">YOUR VOUCHER HAS BEEN SUCCESSFULLY ACTIVATED!</h3>
                                        <p class="forgot_des text-center txt-orange">
              You will receive an email confirming your voucher activation.                
                                        </p>
                                           <p class="forgot_des text-center txt-orange">
              Remember to redeem your experience before DD/MM/YYYY               
                                        </p>
                                        <div>
                                            <img src="shared/img/btn-okay-orange.svg" class="password_ok_img" data-dismiss="modal"/>
                                        </div>
                       
                        </div>
      </div>
        
      </div>
    </div>
  </div>

<!-- end pop up -->
        





    </body>

</html>