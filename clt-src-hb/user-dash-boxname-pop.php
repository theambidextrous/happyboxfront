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

        <title>HappyBox :: User Dashboard Box Name Pop Up</title>

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
  <div class="modal fade" id="userDashBox">
    <div class="modal-dialog general_pop_dialogue booklet_dialogue">
      <div class="modal-content">
   
                       <div class="modal-body">
                           <div class="row">
                                       <div class="col-md-8">
				
                       <div id="modalSlider" class="carousel slide" data-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
    <img class="d-block w-100" src="shared/img/modal_slide_img.jpg" alt="Second slide">
     <div class="carousel-caption">
      <p>Box Specific Booklet</p>
  
  </div>
    </div>
    <div class="carousel-item">
        <img class="d-block w-100" src="shared/img/modal_slide_img.jpg" alt="Second slide">
         <div class="carousel-caption">

   <p>Box Specific Booklet</p>
  </div>
    </div>
  
  </div>
  <a class="carousel-control-prev" href="#modalSlider" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#modalSlider" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
                        </div>
                            <div class="col-md-4 blue_border_left">
                                <a href="" data-dismiss="modal"> <img class="modal_close" src="shared/img/icons/icn-close-window-blue.svg"></a>
                                <div class="modal_parent">
                                            <div class="modal_child text-center">
                                                <h6>  SPA EXPERIENCE</h6>
                                                <br>
                                                <a href="" class="bold_txt pink_bg btn text-white">KES 20 000.00</a>
                                                <p>
              Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
                                                <div>
                                                     <img class="" src="shared/img/icons/btn-add-to-cart-small-red-teal.svg">
                                                    
                                                </div>
                                            </div>
                                </div>
                               
				
                       
                        </div>
                           </div>
            
                           
      </div>
        
      </div>
    </div>
  </div>
   <script>
    $(document).ready(function(){
        $("#userDashBox").modal('show');
    });
</script>
<!-- end pop up -->


    </body>

</html>
