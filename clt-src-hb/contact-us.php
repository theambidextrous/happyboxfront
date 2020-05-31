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

  <title>Happy Box:: Contact Us</title>

  <!-- Bootstrap core CSS -->
 <?php include 'shared/partials/css.php'; ?>
</head>

<body>
  <!-- Navigation -->
 <?php include 'shared/partials/nav.php'; ?>
  <!-- Page Content --> 

  <section class=" contact_banner">
      <div class="container">
      <div class="row">
          <div class="col-md-12 text-center">
              <h3 class="text-white">GET IN TOUCH</h3>         
          </div>
          
      </div> </div>
      </section>
    <section class=" contact_sub_banner">
      <div class="container">
      <div class="row justify-content-center">
          <div class="col-md-9 text-center">
              <h4 class="">
                  Do you have a special request? Are you looking at a tailored gift for large numbers? Ready to make a very personalised gift?<br> Tell us about it!
              </h4>

          </div>
          
      </div> </div>
      </section>
  
  
    

<!--end discover our selection-->
 <section class="container section_padding_top contact_content">
      <div class="row justify-content-center">
          <div class="col-md-6  contact_details">
              <h4 class="contact_title">Contact HAPPYBOX</h4>
              <div class="row">
                  
                  <div class="col-md-6 contact_p_txt">
                      <p>
                          <span class="contact_p"> <b>Contact Details</b></span><br> <b>Email:</b> hello@happybox.ke
                      </p>
                        <p>
                            <span class="contact_p"><b> Postal Address</b></span><br>
                            P.O. Box 123456<br> 001122<br>  Nairobi<br>  Kenya
                      </p>
                  </div>
                    <div class="col-md-6 contact_p_txt">
                      <p>
                          <span class="contact_p">  <b>Business Hours </b></span><br>
                          <b>Monday – Friday:</b> 7am- 4:30pm<br> <b>Saturday:</b> 8am – 2:30pm <br><b>Sunday & National holidays:</b> Closed
                      </p>
                      
                  </div>
              </div>
              
          </div>
            <div class="col-md-4 contact_form">
                
                    <div class="form-group">
  <label for="name">Name</label>
  <input type="text" class="form-control contact_control" id="name" placeholder="Required Field">
</div>
                          <div class="form-group">
  <label for="email">Email Address</label>
  <input type="email" class="form-control contact_control" id="email" placeholder="Required Field">
</div>                     <div class="form-group">
  <label for="Enquiry">Enquiry</label>
  <input type="Enquiry" class="form-control contact_control" id="Enquiry" placeholder="Required Field">
</div>
 <div class="form-group">
  <label for="Details">Details</label>
  <textarea class="form-control contact_control" rows="3" id="Details" placeholder="Please give us the details of your enquiry"></textarea>
</div>
<div class="form-group text-right">
    <button type="submit" class="btn btn_contact" data-toggle="modal" data-target="#contactPop" >Send</button>
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
  <div class="modal fade" id="contactPop">
    <div class="modal-dialog general_pop_dialogue">
      <div class="modal-content">
   
                       <div class="modal-body text-center">
                    <div class="col-md-12 text-center forgot-dialogue-borderz">
					<h3 class="partner_blueh pink_title">THANK YOU! YOUR ENQUIRY HAS BEEN SENT.</h3>
                                        <p class="forgot_des text-center">
                    We will get back to you via email shortly.                   
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
