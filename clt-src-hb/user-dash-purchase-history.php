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

        <title>Happy Box:: User Dashboard Purchase History</title>

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
        
           



    <section class="partner_voucher_list section_60">
           <div class="container">
			
               
                    <div class="row ">
                         <div class="col-md-12">
                        
                        <h3 class="user_blue_title text-center">MY PURCHASE HISTORY</h3>
                                        <p class="txt-orange text-center">
                  A list of your activated vouchers              
                                        </p>
                         </div>
                    </div>
                     
                        <div class="row ">
                    <div class="col-md-9">
					
                                        <div class="table-responsive">
                                            <div class="purchase_hist"><table class="table purchase_hist   table-bordered">
                                                     <tr class="purch_hist_tr_td">
                        <td class="b">ORDER NUMBER</td>
                        <td>0123456</td>
                        <td colspan="6" class="invisible_table td_noborder"></td>
                        
                     
                      


                    </tr>
          
                    <tr class="purch_hist_tr_td">
                        <th class="b">IMAGE</th>
                        <th>BOX NAME</th>
                         <th>BOX<br> NUMBER</th>
                        <th>VOUCHER <br>CODE</th>
                   
                        <th>PURCHASE DATE</th>
                        <th>BOX TYPE</th>
                         <th>QUANTITY</th>
                        <th>COST</th>
                     
                      


                    </tr>
                                      
  
  
        <tr>
          <td class="">
             <img class="d-block mx-auto purch_his_img" src="shared/img/Box_Mockup_01-200x200@2x.png">
          </td>
          <td><b>SPA EXPERIENCE</b></td>
          <td><b>12345</b></td>
          <td class=""><b>QWERTY</b></td>
            
       
              <td>06/03/2020</td>
                <td>E-BOX</td>
                <td class="">2</td>
                <td class="">KES 20 000.00</td>
                   
            
      </tr>
      <tr>
          <td class="">
             <img class="d-block mx-auto purch_his_img" src="shared/img/Box_Mockup_01-200x200@2x.png">
          </td>
          <td><b>SPA EXPERIENCE</b></td>
          <td><b>12345</b></td>
          <td class=""><b>QWERTY</b></td>
            
       
              <td>06/03/2020</td>
                <td>E-BOX</td>
                <td class="">2</td>
                <td class="">KES 20 000.00</td>
                   
            
      </tr>
      <tr class="">
                        <td colspan="5" class="td_noborder">
                                              
                                              
                                          </td>
                                          <td colspan="3" align="right" class="">
                                              
                                              <table>
                                                  <tr>
                                                      <td style="width:50%;">SUB TOTAL (Incl. VAT)</td>
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
      
  
     

  </table>
                                                </div>
                </div> 
                                   
                        </div>
                        <div class="col-md-3 purchase_hist_right">
                           
                           <img class=" " src="shared/img/btn-add-to-cart-orange.svg">  
                            <img class="purchase_hist_right_mid_img " src="shared/img/btn-add-to-cart-orange.svg"> 
                               <img class=" " src="shared/img/btn-download-orange.svg">
                            
                             
                            
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
