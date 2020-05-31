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

        <title>Happy Box:: User Checkout</title>

        <!-- Bootstrap core CSS -->
        <?php include 'shared/partials/css.php'; ?>
    </head>

    <body>
        <!-- Navigation -->
        <?php include 'shared/partials/nav.php'; ?>
       
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
        <section class="container section_padding_top  ">
            <div class="row">
                <div class="col-md-12">
                     <h3 class="user_blue_title" >ORDER SUMMARY</h3>
                </div>
                 
            </div>
              <!--progress strip-->
                      <div class=" cart_progress_strip row">
                          <div class="col-md-3 cart_strip"></div>
                          <div class="col-md-3 shipping_strip"></div>
                           <div class="col-md-3 summary_strip"></div>
                           <div class="col-md-3 payment_strip"></div>
                          
                      </div>
                        <br>
                           <!--end progress strip-->
            <div class="row justify-content-center section_padding_top">
                <div class="col-md-7 text-center">
                     
                      <div class="card border_card_checkout">
                          
                          Choose your preferred payment method to continue
                      </div>                              
              </div>
               

            </div>
                              <div class="row justify-content-around section_padding_top">
                <div class="col-md-4">
                     
                     
                    <div class=" pay_strip">
                          <a href="" class="btn btn-sm btn-orange text-white">MPESA</a> 
                    
                    
                 
                              
                
                      
                    


                </div>
                                  <div class="col-md-4">
                                         <a href="" class="btn btn-sm btn-orange text-white">CREDIT CARD</a>  
                    </div>
                                      
                                      
                                  </div>
                                        <div class="col-md-8">
                                                 <div class="payment_back ">
                        <img src="shared/img/icn-arrow-teal.svg"> BACK TO ORDER SUMMARY
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
        




    </body>

</html>
