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

        <title>Happy Box:: User Dashboard Voucher List</title>

        <!-- Bootstrap core CSS -->
        <?php include 'shared/partials/css.php'; ?>
    </head>

 <body class="client_body">
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
			
               
                    <div class="row justify-content-center forgot-dialogue-wrap">
                     
                       
                    <div class="col-md-12">
					<h3 class="user_blue_title text-center">MY VOUCHER LIST</h3>
                                        <p class="txt-orange text-center">
                  A list of your activated vouchers              
                                        </p>
                                        <div class="table-responsive">
                                            <div class="table_radius"><table class="table  voucher_list_table table-bordered">
                <thead>
                    <tr>
                        <th class="blue_cell_th th_box">BOX NAME</th>
                        <th>BOX NUMBER</th>
                         <th>VOUCHER CODE</th>
                        <th>STATUS</th>
                   
                        <th>DATE REDEEMED</th>
                        <th>BOX VALIDITY DATE</th>
                         <th>CANCELLATION DATE</th>
                        <th>BOOKING DATE</th>
                        <th>PARTNER</th>
                        <th class="txt-blue">PARTNER RATING</th>
                        <th colspan="2" class="th_actions">ADMIN REQUESTS</th>


                    </tr>
    </thead>
    <tbody>
        <tr>
          <td class="light_blue_cell">
            SPA EXPERIENCE
          </td>
            <td>123</td>
        <td>azerty</td>
          <td class="hap_success">REDEEMED</td>
            
       
              <td>06/03/2020</td>
                <td>06/03/2020</td>
                <td class="empty_cell"></td>
                <td class="">06/03/2020</td>
                   <td class="">Super Spa</td>
                   <td class="gray_star"><i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i> </td>
           
             <td class="td_orange">
               DECLARE LOSS OR THEFT OF VOUCHER
                
            </td>
            
      </tr>
      <tr>
          <td class="light_blue_cell">
            SPA EXPERIENCE
          </td>
          <td>456</td>
        <td>qwerty</td>
         <td class="hap_danger">CANCELLED</td> 
     
           <td class="empty_cell"></td>
                       <td>06/07/2020</td>
              
                  <td>06/04/2020</td>
                  <td class="empty_cell"></td>
                    <td>Super Spa</td>
                  <td class="gray_star empty_cell"><i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i> </td>
                <td class="empty_cell">
                    
                    
           
                
            </td>
            
      </tr>
      
  
     
    </tbody>
  </table>
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
  <div class="modal fade" id="userdashTheft">
    <div class="modal-dialog general_pop_dialogue">
      <div class="modal-content">
   
                       <div class="modal-body text-center">
                    <div class="col-md-12 text-center forgot-dialogue-borderz">
					<h3 class="partner_blueh ">Your loss or theft declaration is being processed</h3>
                                      
                                           <p class=" text-center txt-orange">
            You will receive an email shortly.             
                                        </p>
                                        <div>
                                            <img src="shared/img/btn-okay-orange.svg" class="password_ok_img" data-dismiss="modal"/>
                                        </div>
                       
                        </div>
      </div>
        
      </div>
    </div>
  </div>
   <script>
    $(document).ready(function(){
        $("#userdashTheft").modal('show');
    });
</script>
<!-- end pop up -->
      
        





    </body>

</html>
