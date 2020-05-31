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
        <section class="container section_padding_top ">
            <div class="row">
                <div class="col-md-12 ">
                      <h3 class="user_blue_title" >SHIPPING METHOD</h3>
                         <!--progress strip-->
                      <div class=" cart_progress_strip row">
                          <div class="col-md-3 cart_strip"></div>
                          <div class="col-md-3 shipping_strip"></div>
                          
                      </div>
                           <!--end progress strip-->
                      <table class="p-2 cart-table table-borderless shipping_table">
                          
                          <tr>
                              <td class="pdt_img"> <img src="shared/img/cart_img.png" /></td>
                              <td class="cart_des">
                                  <h6>Box One</h6>
                                  <span>
                                      Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore.
                                  </span>
                                  <br>
                                  <b>KES20 000.00</b>
                              </td>
                                  <td>
                                      <h6><span class="text-orange"><b>E-Box |</b></span>  Delivered via email</h6>
                                     <form action="ship_form">
    <div class="form-group">
      <label for="usr">Email Address</label>
      <input type="email" class="form-control rounded_form_control" id="email" placeholder="Required Field">
    </div>
    <div class="form-group">
      <label for="pwd">Recipient Name</label>
        <input type="text" class="form-control rounded_form_control" id="RecipientName" placeholder="Required Field">
    </div>
  
  
                                      
                                  </td>
                                  <td class="shipping_comment">
    <div class="form-group">
        <label for="comment">Personalised message to recipient <span class="form-italic">(max characters 230)</span></label>
  <textarea class="form-control rounded_form_control" rows="5" id="comment" placeholder="Optional"></textarea>
</div>
 

  </form>  
</td>

                                        
                          </tr>
                          <!--2-->
                          <tr>
                              <td class="pdt_img"> <img src="shared/img/cart_img.png" /></td>
                              <td class="cart_des">
                                  <h6>Box Two</h6>
                                  <span>
                                      Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore.
                                  </span>
                                  <br>
                                  <b>KES20 000.00</b>
                              </td>
                                  <td>
                                      <h6><span class="text-orange"><b>E-Box |</b></span>  Delivered via email</h6>
                                     <form action="ship_form">
    <div class="form-group">
      <label for="usr">Email Address</label>
      <input type="email" class="form-control rounded_form_control" id="email" placeholder="Required Field">
    </div>
    <div class="form-group">
      <label for="pwd">Recipient Name</label>
        <input type="text" class="form-control rounded_form_control" id="RecipientName" placeholder="Required Field">
    </div>
  
  
                                      
                                  </td>
                                  <td class="shipping_comment">
    <div class="form-group">
        <label for="comment">Personalised message to recipient <span class="form-italic">(max characters 230)</span></label>
  <textarea class="form-control rounded_form_control" rows="5" id="comment" placeholder="Optional"></textarea>
</div>
 

  </form>  
</td>

                                        
                          </tr>
                          
                          <!--3-->
                        <tr>
                              <td class="pdt_img"> <img src="shared/img/cart_img.png" /></td>
                              <td class="cart_des">
                                  <h6>Box Three</h6>
                                  <span>
                                      Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore.
                                  </span>
                                  <br>
                                  <b>KES10 000.00</b>
                              </td>
                                  <td>
                                      <h6><span class="text-orange"><b>Physical Delivery |</b></span>  Delivered via email</h6>
                                     <form action="ship_form">

    <div class="form-group">
      <label for="pwd">Recipient Name</label>
        <input type="text" class="form-control rounded_form_control" id="RecipientName" placeholder="Required Field">
    </div>
                                          <div class="form-group">
      <label for="pwd">Address</label>
        <input type="text" class="form-control rounded_form_control" id="Address" placeholder="Required Field">
    </div>
                                          <div class="form-group">
      <label for="pwd">City</label>
        <input type="text" class="form-control rounded_form_control" id="City" placeholder="Required Field">
    </div>
                                          <div class="form-group">
      <label for="pwd">Province</label>
        <input type="text" class="form-control rounded_form_control" id="Province" placeholder="Required Field">
    </div>
  
  
                                      
                                  </td>
                                  <td class="shipping_comment physical_td">
                                      <div class="form-group">  
      <label for="pwd">Postal Code</label>
        <input type="text" class="form-control rounded_form_control" id="PostalCode" placeholder="Required Field">
    </div>
                                          <div class="form-group">
      <label for="pwd">Delivery Contact Name</label>
        <input type="text" class="form-control rounded_form_control" id="DeliveryContactName" placeholder="Required Field">
    </div>
                                          <div class="form-group">
      <label for="pwd">Delivery Contact Number</label>
        <input type="text" class="form-control rounded_form_control" id="DeliveryContactNumber" placeholder="Required Field">
    </div>
         
 

  </form>  
</td>

                                        
                          </tr> 
                          <tr>
                              <td class="pdt_img"> <img src="shared/img/cart_img.png" /></td>
                              <td class="cart_des">
                                  <h6>Box Four</h6>
                                  <span>
                                      Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore.
                                  </span>
                                  <br>
                                  <b>KES10 000.00</b>
                              </td>
                                  <td>
                                      <h6><span class="text-orange"><b>Physical Delivery |</b></span>  Delivered via email</h6>
                                     <form action="ship_form">

    <div class="form-group">
      <label for="pwd">Recipient Name</label>
        <input type="text" class="form-control rounded_form_control" id="RecipientName" placeholder="Required Field">
    </div>
                                          <div class="form-group">
      <label for="pwd">Address</label>
        <input type="text" class="form-control rounded_form_control" id="Address" placeholder="Required Field">
    </div>
                                          <div class="form-group">
      <label for="pwd">City</label>
        <input type="text" class="form-control rounded_form_control" id="City" placeholder="Required Field">
    </div>
                                          <div class="form-group">
      <label for="pwd">Province</label>
        <input type="text" class="form-control rounded_form_control" id="Province" placeholder="Required Field">
    </div>
  
  
                                      
                                  </td>
                                  <td class="shipping_comment physical_td">
                                      <div class="form-group">  
      <label for="pwd">Postal Code</label>
        <input type="text" class="form-control rounded_form_control" id="PostalCode" placeholder="Required Field">
    </div>
                                          <div class="form-group">
      <label for="pwd">Delivery Contact Name</label>
        <input type="text" class="form-control rounded_form_control" id="DeliveryContactName" placeholder="Required Field">
    </div>
                                          <div class="form-group">
      <label for="pwd">Delivery Contact Number</label>
        <input type="text" class="form-control rounded_form_control" id="DeliveryContactNumber" placeholder="Required Field">
    </div>
         
 

  </form>  
</td>

                                        
                          </tr>
                          <tr class="cart_totals_actions shipping_action_strip">
                          <hr>
                              <td colspan="4" align="right">
                                     <img src="shared/img/btn-continue-shopping.svg">
                                  <img src="shared/img/btn-shipping-method-blue.svg"> 
                              </td>
                          </tr>
                         
                         
                          
                         
                      </table>
               
                    


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
