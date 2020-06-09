<?php
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
require_once('../lib/Picture.php');
require_once('../lib/Order.php');
$util = new Util();
$user = new User();
$picture = new Picture();
$util->ShowErrors(1);
if(!isset(json_decode($_SESSION['usr'])->access_token)){
    $_SESSION['next'] = 'user-dash-checkout.php';
    header("Location: user-login.php");
}
if(empty($_SESSION['unpaid_order'])){
    header("Location: user-dash-shipping.php");
}
$token = json_decode($_SESSION['usr'])->access_token;
$order = new Order($token);
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
                    <?php include 'shared/partials/nav-mid.php'; ?>
                    </div>

                </div> </div>
        </section>
       




        <!--end discover our selection-->
        <section class="container section_padding_top  ">
            <div class="row">
                <div class="col-md-12">
                     <h3 class="user_blue_title" >ORDER PAYMENT</h3>
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
                          <?php
                            $order_data = json_decode($order->get_one_byorder_limited($_SESSION['unpaid_order']), true)['data'];
                            // $util->Show($order_data);
                          ?>
                         <b> UNPAID ORDER: <?=$_SESSION['unpaid_order']?></b> <br>
                         <b> SUB-TOTAL: <?=number_format($order_data['subtotal'], 2)?></b> <br>
                         <b> SHIPPING: KES<?=number_format($order_data['shipping_cost'], 2)?></b> <br>
                         <b> TOTAL: KES <?=number_format(($order_data['shipping_cost']+$order_data['subtotal']), 2)?></b> <br>
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
                                                <a href="<?=$util->ClientHome()?>/user-dash-order-summary.php"><img src="shared/img/icn-arrow-teal.svg"> BACK TO ORDER SUMMARY</a>
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
