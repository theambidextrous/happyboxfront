<?php
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
require_once('../lib/Picture.php');
$util = new Util();
$user = new User();
$picture = new Picture();
$util->ShowErrors(1);
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Happy Box:: User Order Summary</title>

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
        <section class="container section_padding_top ">
            <div class="row">
                <div class="col-md-12 ">
                      <h3 class="user_blue_title" >ORDER SUMMARY</h3>
                        <!--progress strip-->
                      <div class=" cart_progress_strip row">
                          <div class="col-md-3 cart_strip"></div>
                          <div class="col-md-3 shipping_strip"></div>
                           <div class="col-md-3 summary_strip"></div>
                          
                      </div>
                        <br>
                           <!--end progress strip-->
                      <div class="table-responsive">
                                            <div class=""><table class="table order_summary   table-bordered">
                                                     <tr class="order_summary_tr_td">
                        <td class="b">ORDER NUMBER</td>
                        <td>0123456</td>
                        <td colspan="4" class="invisible_table"></td>
                        
                     
                      


                    </tr>
          
                    <tr class="order_summary_tr_td">
                        <th class="b col_1">IMAGE</th>
                        <th>BOX NAME</th>
                         <th>BOX TYPE</th>
                         <th>RECIPIENT NAME</th>
                        <th>DELIVERY ADDRESS</th>               
                
                       
                         <th>COST</th>                   
                    </tr>
                                      
  
  
        <tr>
          <td class="">
             <img class="order_summary_tr_td_img" src="shared/img/Box_Mockup_01-200x200@2x.png">
          </td>
          <td><b>SPA EXPERIENCE</b></td>
            <td>E-BOX</td>
          <td>JANE BLOGGS</td>
          <td>abc@delivermybox.ke</td>
         <td>KES 20 000.00</td>                 
            
      </tr>
        <tr>
          <td class="">
             <img class="order_summary_tr_td_img" src="shared/img/Box_Mockup_01-200x200@2x.png">
          </td>
          <td><b>OTHER SPA EXPERIENCE</b></td>
            <td>E-BOX</td>
          <td>JANE BLOGGS</td>
          <td>abc@delivermybox.ke</td>
         <td>KES 20 000.00</td>                 
            
      </tr>
        <tr>
          <td class="">
             <img class="order_summary_tr_td_img" src="shared/img/Box_Mockup_01-200x200@2x.png">
          </td>
          <td><b>OTHER SPA EXPERIENCE</b></td>
            <td>E-BOX</td>
          <td>JANE BLOGGS</td>
          <td>123 Box Street, Nairobi, Kenya,1234</td>
         <td>KES 10 000.00</td>                 
            
      </tr>
      
      <tr class="">
                        <td colspan="4" class="">
                                              
                                              
                                          </td>
                                          <td colspan="2" align="right" class="">
                                              
                                              <table>
                                                  <tr>
                                                      <td>SUB TOTAL (Incl. VAT)</td>
                                                          <td>KES 70 000.00</td>
                                                  </tr>
                                                   <tr>
                                                      <td>SHIPPING</td>
                                                          <td>KES 300.00</td>
                                                  </tr>
                                                  <tr class="bold_txt">
                                                      <td>TOTAL PRICE (Incl. VAT)</td>
                                                          <td>KES 70 300.00</td>
                                                  </tr>
                                              </table>
                                          </td>
                        
                     
                      


                    </tr>
                    <tr align="right" class="cart_totals tr_border_top cart_totals_actions">
                              <td colspan="6 ">
                                <a href="<?=$util->ClientHome()?>/user-dash-shipping.php"><img src="shared/img/btn-back-to-shipping-orange.svg"></a>
                                <a href="<?=$util->ClientHome()?>/user-dash-checkout.php"><img src="shared/img/btn-checkout-blue.svg"></a>
                              </td>
                          </tr>
      
  
     

  </table>
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
        




    </body>

</html>
