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
                      <h3 class="user_blue_title" >YOUR SHOPPING CART</h3>
                      <!--progress strip-->
                      <div class="width_100 cart_progress_strip">
                          <div class="col-md-3 cart_strip"></div>
                      </div>
                           <!--end progress strip-->
                      <table class="p-2 cart-table table-borderless">
                          
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
                                      <form><div class="form-check">
  <label class="form-check-label">
      <input type="radio" class="form-check-input" name="optradio" checked="checked"><b>Physical Delivery </b>
      <br><small>Delivered via courier to your door</small>
  </label>
</div>
<div class="form-check">
  <label class="form-check-label">
      <input type="radio" class="form-check-input" name="optradio"><b>E-Box</b>
      <br><small>Delivered via email</small>
  </label>
</div></form></td>
<td>
 
<!------ Include the above in your HEAD tag ---------->

  <div class="center">
   
     <div class="input-group">
          <span class="input-group-btn">
              <button type="button" class="btn  btn-number"  data-type="minus" data-field="quant[2]">
               <i class="fas fa-minus"></i>
              </button>
          </span>
          <input type="text" name="quant[2]" class="form-control input-number cart_value" value="10" min="1" max="100">
          <span class="input-group-btn">
              <button type="button" class="btn btn-number" data-type="plus" data-field="quant[2]">
                  <i class="fas fa-plus"></i>
              </button>
          </span>
      </div>
	
</div>
    
</td>
<td>
    <b>KES 40 000.00</b>
</td>
                                        <td><i class="fas fa-trash-alt del_icon"></i></td>
                          </tr>
                          <tr >
                              <td colspan="6">
                                  <small><i>* Physical delivery only available in Nairobi at present.</i></small>  
                              </td>
                          </tr>
                          <!--2 -->
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
                                      <form><div class="form-check">
  <label class="form-check-label">
      <input type="radio" class="form-check-input" name="optradio" ><b>Physical Delivery </b>
      <br><small>Delivered via courier to your door</small>
  </label>
</div>
<div class="form-check">
  <label class="form-check-label">
      <input type="radio" class="form-check-input" name="optradio" checked="checked"><b>E-Box</b>
      <br><small>Delivered via email</small>
  </label>
</div></form></td>
<td>
 
<!------ Include the above in your HEAD tag ---------->

  <div class="center">
   
     <div class="input-group">
          <span class="input-group-btn">
              <button type="button" class="btn  btn-number"  data-type="minus" data-field="quant[3]">
               <i class="fas fa-minus"></i>
              </button>
          </span>
          <input type="text" name="quant[3]" class="form-control input-number cart_value" value="10" min="1" max="100">
          <span class="input-group-btn">
              <button type="button" class="btn btn-number" data-type="plus" data-field="quant[3]">
                  <i class="fas fa-plus"></i>
              </button>
          </span>
      </div>
	
</div>
    
</td>
<td>
    <b>KES 40 000.00</b>
</td>
                                        <td><i class="fas fa-trash-alt del_icon"></i></td>
                          </tr>
                          <tr >
                              <td colspan="6">
                                  <small><i>* Physical delivery only available in Nairobi at present.</i></small>  
                              </td>
                          </tr>
                          <tr align="right " class="cart_totals tr_border_top">
                              <td colspan="6">
                                  <span>SHIPPING TOTAL KES</span> 300.00
                              </td>
                          </tr>
                          <tr align="right" class="cart_totals tr_border_top">
                              <td colspan="6">
                                  <span> ORDER TOTAL (Incl. VAT)</span>  KES 60 300.00
                              </td>
                          </tr>
                           <tr align="right" class="cart_totals tr_border_top cart_totals_actions">
                              <td colspan="6 ">
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
        <script>
            
    
$('.btn-number').click(function(e){
    e.preventDefault();
    
    fieldName = $(this).attr('data-field');
    type      = $(this).attr('data-type');
    var input = $("input[name='"+fieldName+"']");
    var currentVal = parseInt(input.val());
    if (!isNaN(currentVal)) {
        if(type == 'minus') {
            
            if(currentVal > input.attr('min')) {
                input.val(currentVal - 1).change();
            } 
            if(parseInt(input.val()) == input.attr('min')) {
                $(this).attr('disabled', true);
            }

        } else if(type == 'plus') {

            if(currentVal < input.attr('max')) {
                input.val(currentVal + 1).change();
            }
            if(parseInt(input.val()) == input.attr('max')) {
                $(this).attr('disabled', true);
            }

        }
    } else {
        input.val(0);
    }
});
$('.input-number').focusin(function(){
   $(this).data('oldValue', $(this).val());
});
$('.input-number').change(function() {
    
    minValue =  parseInt($(this).attr('min'));
    maxValue =  parseInt($(this).attr('max'));
    valueCurrent = parseInt($(this).val());
    
    name = $(this).attr('name');
    if(valueCurrent >= minValue) {
        $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
    } else {
        alert('Sorry, the minimum value was reached');
        $(this).val($(this).data('oldValue'));
    }
    if(valueCurrent <= maxValue) {
        $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
    } else {
        alert('Sorry, the maximum value was reached');
        $(this).val($(this).data('oldValue'));
    }
    
    
});
$(".input-number").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) || 
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
            </script>
        

        





    </body>

</html>
