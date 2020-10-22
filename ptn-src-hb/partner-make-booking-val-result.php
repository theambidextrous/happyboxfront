<?php
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
$util = new Util();
?>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Happy Box:: Partner Booking</title>
  <!-- Bootstrap core CSS -->
 <?php include '../shared/partials/css.php'; ?>

</head>

<body>
  <!-- Navigation -->
 <?php include '../shared/partials/nav-logged-in.php'; ?>
    <section  class="mob_maroon_section text-center">
			<h4 class="">VALIDITY RESULT</h4>
			</section>
 
<section class="section_60">
            <div class="container">
			
               
                    <div class="row  ">
                        <div class="col-md-5 desktop_view">
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
                          <div class="col-md-7 text-center how_it_work_border desktop_view">
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
                       
                

                </div><div class="row text-center desktop_view">
                     <div class="voucher_result_bar validity_bar">
                     <div class="voucher_no">
                         VOUCHER NUMBER
                     </div> 
                     <div class="voucher_no_value ">
                         QWERTY0125
                     </div>
                     <div class="voucher_status">
                         STATUS
                     </div>
                     <div class="voucher_status_value">
                         VALID
                     </div>
                     <div class="box_name_select col-4">
                         
                      
       <ul class="nav nav-pills">
    
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">BOX NAME | DESCRIPTION  </a>
      <div class="dropdown-menu">
               <a class="dropdown-item" href="#">Hot-Stone Massage , Body-Scrub & Pedicure</a>
                           <a class="dropdown-item" href="#">Hot-Stone Massage , Body-Scrub & Pedicure</a>
                          <a class="dropdown-item" href="#">Moroccan Bath , Swedish Massage & Manicure, Pedicure</a>
                              <a class="dropdown-item" href="#">Deep Tissue Massage & Deep Cleansing Facial</a>
                             
      
      </div>
    </li>
   
   
  </ul>

                     </div>
                         
                     <div class="booking_date col-md-2 border_right nomargin_lr">
                         <span class=""> <img src="../shared/img/icons/icn-calendar-blue.svg" class="booking_date_input"/></span>
                     <input type="text" class="form-control" placeholder="Enter booking date">
                     </div>
                     <div class="voucher_partner2 col-md-2 hap_success">
                         
                       REDEEM VOUCHER
                     </div>
                         </div>
                        
                    </div>
                <div class="  mobile_view">
                     <div class="voucher_result_bar_mob ">
                         <div  class="row voucher_result_bar_mob_row">
                             <div class="col-8" >
                                VOUCHER NUMBER 
                             </div>  
                              <div class="col-4 text-right" >
                               QWERTY0125
                             </div>
                             
                         </div>
                            <div class="voucher_result_bar_mob ">
                         <div  class="row voucher_result_bar_mob_row">
                             <div class="col-8" >
                                BOX NAME | DESCRIPTION
                             </div>  
                              <div class="col-4 text-right" >
                         
  
  <select class="form-control-sm" id="des_sel">
      <option value="">SELECT</option>
    <option>2</option>
    <option>3</option>
    <option>4</option>
  </select>

                             </div>
                             
                         </div>
                        
                    </div>
                          <div class="voucher_result_bar_mob ">
                         <div  class="row voucher_result_bar_mob_row">
                             <div class="col-8" >
                                ENTER A BOOKING DATE
                             </div>  
                              <div class="col-4 text-right" >
                                  
                                  
                            <img src="../shared/img/icn-calendar-blue.svg" class="val_date_icon"/>
                               
                             </div>
                             
                         </div>
                            
                        
                    </div>
                           <div  class="row ">
                             <div class="col-12" >
                                 <button class="btn-block btn_rounded btn_no_border btn-lg">REDEEM THIS VOUCHER</button>
                                 <br>
                             </div>  
                             
                             
                         </div>
                     </div>  </div>
                
                 <section class="check_voucher_s mobile_view" >
      <div class="mob_relative">     <img src="../shared/img/icn-arrow-blue-mob.svg" class="floating_arrow"/></div>
 
      <div class="container">
      <div class="row  text-center">
        <div class="col-12">
            <h3 class="mob_blue check_voucher_s_h">CHECK ANOTHER VOUCHER</h3>
          
          <div class="check_voucher_s_p">
              <p class="mob_light_blue mob_font16">
                  To make a booking, enter the customer voucher code below to check it’s validity.
              </p>
          </div>
            <form class="voucher_val" method="post">
                        <div class="form-group">
           <input type="text" name="vcode" class="form-control rounded_form_control" placeholder="Enter customer voucher code here">
                        </div>
                        <button type="submit" name="VALIDITY" class="btn btn_rounded">CHECK VALIDITY</button>
                      </form>
      </div>
        
              </div>
                
              </div>
    
            </div><!-- result-->
          </div>
        </section>
                <!-- result-->
                   
                
                
              </div>
        </section>

<?php  include '../shared/partials/loggedin-footer.php';?>
  <!-- Page Content -->

  <!-- Bootstrap core JavaScript -->
  
<?php include '../shared/partials/js.php';?>
   
  
 
 

</body>

</html>
