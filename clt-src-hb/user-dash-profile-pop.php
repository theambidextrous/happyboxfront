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

        <title>HappyBox :: User Dashboard My Profile</title>

        <!-- Bootstrap core CSS -->
        <?php include 'shared/partials/css.php'; ?>
    </head>

<body class="client_body">
        <!-- Navigation -->
        <?php include 'shared/partials/nav.php'; ?>
        <!-- Page Content --> 

     
        




        <!--end discover our selection-->
        <section class="container section_padding_top contact_content">
              <div class="row ">
                         <div class="col-md-12">
                        
                        <h3 class="user_blue_title text-center">MY PROFILE DETAILS</h3>
                                        <p class="txt-orange text-center">
               Update your profile and delivery details here.      
                                        </p>
                         </div>
                    </div>
            <div class="row justify-content-center user_profile_edit">
              
                <div class="col-md-5  ">
                    <div class=" ">
                        <h5 class="blue_text">PROFILE DETAILS</h5>

                        
                            <form class="form_register_user">
                                <div class="form-group">
                                    <label>
                                        First Name
                                    </label>
                                    <input type="text" name="Fname" class="form-control rounded_form_control" placeholder="Required Field">
                                </div>
                                 <div class="form-group">
                                    <label>
                                      Surname
                                    </label>
                                     <input type="text" name="Surname" class="form-control rounded_form_control" placeholder="Required Field">
                                </div>
                                  <div class="form-group">
                                    <label>
                                     Email Address
                                    </label>
                                     <input type="email" name="Email" class="form-control rounded_form_control" placeholder="Required Field">
                                </div>
                                   <div class="form-group">
                                    <label>
                                      Mobile
                                    </label>
                                     <input type="text" name="Mobile" class="form-control rounded_form_control" placeholder="Required Field">
                                </div>
                                   <div class="form-group">
                                    <label>
                                      Surname
                                    </label>
                                     <input type="text" name="Surname" class="form-control rounded_form_control" placeholder="Required Field">
                                </div>
                                
                               
                                <div class="form-group">
                                    <label>
                                        Password
                                    </label>

                                    <input type="password" class="form-control rounded_form_control" placeholder="Required Field">
                                </div>
                                  <div class="form-group">
                                    <label>
                                       Confirm password
                                    </label>

                                    <input type="Cpassword" class="form-control rounded_form_control" placeholder="Required Field">
                                </div>
                                
                                <p class="text-right">
                                    <button type="submit" class="btn btn_rounded">UPDATE MY DETAILS</button>   
                                </p>



                            </form>


                       

                    </div>

                </div>
                <div class="col-md-5 user_profile_right">
                    <div class=" ">
                         <h5 class="text-orange">PHYSICAL DELIVERY DETAILS</h5>

                        
                            <form class="form_register_user">
                              
                                 <div class="form-group">
                                    <label>
                                  Address
                                    </label>
                                     <input type="text" name="Address" class="form-control rounded_form_control" placeholder="Required Field">
                                </div>
                                  <div class="form-group">
                                    <label>
                                  City
                                    </label>
                                     <input type="text" name="City" class="form-control rounded_form_control" placeholder="Required Field">
                                </div>
                                   <div class="form-group">
                                    <label>
                                      Province
                                    </label>
                                     <input type="text" name="Province" class="form-control rounded_form_control" placeholder="Required Field">
                                </div>
                                   <div class="form-group">
                                    <label>
                                      Postal Code
                                    </label>
                                     <input type="text" name="PostalCode" class="form-control rounded_form_control" placeholder="Required Field">
                                </div>
                                
                               
                                
                                  
                                
                                <p class="text-right">
                                    <button type="submit" class="btn btn_rounded  btn-orange">UPDATE MY DELIVERY DETAILS</button>   
                                </p>



                            </form>


                       

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

<div class="modal fade" id="userCreatedModal">
<div class="modal-dialog general_pop_dialogue">
<div class="modal-content">

<div class="modal-body text-center">
<div class="col-md-12 text-center forgot-dialogue-borderz">
<h3 class="partner_blueh">THANK YOU!</h3>
<p class="forgot_des text-center txt-orange">
Your details have been updated.                
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
$("#userCreatedModal").modal('show');
});
</script>
<!-- end pop up -->





    </body>

</html>
