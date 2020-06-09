<?php
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
require_once('../lib/Picture.php');
require_once('../lib/Box.php');
$util = new Util();
$user = new User();
$picture = new Picture();
$box = new Box();
$util->ShowErrors(1);
/** update shipping data */
if(isset($_POST['load']) && isset($_SESSION['curr_usr_cart'])){
  $_ll = 0;
  foreach($_SESSION['curr_usr_cart'] as $_c_item ){
    if($_c_item[2] == 2){
      $data = [
        $_POST[$_c_item[0] . '__email'],
        $_POST[$_c_item[0] . '__name'],
        $_POST[$_c_item[0] . '__comment']
      ];
      // print_r($data);
      $_SESSION['curr_usr_cart'][$_ll][4] = $data;
      $_SESSION['curr_usr_cart'][$_ll][5] = true;
    }elseif($_c_item[2] == 1){
      $data = [
        $_POST[$_c_item[0] . '__name'],
        $_POST[$_c_item[0] . '__address'],
        $_POST[$_c_item[0] . '__city'],
        $_POST[$_c_item[0] . '__province'],
        $_POST[$_c_item[0] . '__postal_code'],
        $_POST[$_c_item[0] . '__delivery_name'],
        $_POST[$_c_item[0] . '__delivery_phone'],
      ];
      // print_r($data);
      $_SESSION['curr_usr_cart'][$_ll][4] = $data;
      $_SESSION['curr_usr_cart'][$_ll][5] = true;
    }
    $_ll++;
  }
  if(isset($_SESSION['curr_usr_cart'])){
    $_SESSION['curr_usr_cart'][1000]['order_id'] = $util->createCode(10);
  }
  header("Location: user-dash-order-summary.php");
}elseif(isset($_SESSION['unpaid_order']) && !isset($_SESSION['curr_usr_cart']) ){
  header("Location: user-dash-order-summary.php");
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Happy Box:: Shipping</title>

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
                      <h3 class="user_blue_title" >SHIPPING METHOD</h3>
                         <!--progress strip-->
                      <div class=" cart_progress_strip row">
                          <div class="col-md-3 cart_strip"></div>
                          <div class="col-md-3 shipping_strip"></div>
                          
                      </div>
                      <!--end progress strip-->
                      <table class="p-2 cart-table table-borderless shipping_table">
                        <form action="" method="post">
                        <?php
                            // $util->Show($_SESSION['unpaid_order']);
                          if(!empty($_SESSION['curr_usr_cart'])){
                            // $util->Show($_SESSION['curr_usr_cart']);
                            /**  */
                            foreach($_SESSION['curr_usr_cart'] as $_cart_item ):
                              if(!isset($_cart_item['order_id'])){
                              $_box_data = json_decode($box->get_byidf('00', $_cart_item[0]))->data;
                              $_b_cost = floor($_cart_item[1]*$_box_data->price);
                              $_total_cart[] = $_b_cost;
                              $_total_shipping = 0;
                              $_media = $picture->get_byitem('00', $_cart_item[0]);
                              $_media = json_decode($_media, true)['data'];
                              $_3d = 'shared/img/cart_img.png';
                              foreach( $_media as $_mm ){
                                  if($_mm['type'] == '2'){$_3d = $_mm['path_name'];}
                              }
                              if($_cart_item[2] == 2){ /** ebox */
                        ?>
                        <tr>
                          <td class="pdt_img"> <img src="<?=$_3d?>" /></td>
                          <td class="cart_des">
                            <h6><?=$_box_data->name?></h6>
                            <span><?=$_box_data->description?></span><br>
                            <b>KES <?=number_format($_box_data->price, 2)?></b>
                          </td>
                          <td>
                            <h6><span class="text-orange"><b>E-Box |</b></span>  Delivered via email</h6>
                              <div class="form-group">
                                <label for="usr">Recipient Email Address</label>
                                <input required type="email" class="form-control rounded_form_control" name="<?=$_cart_item[0]?>__email" id="email" value="<?=$_cart_item[4][0]?>">
                              </div>
                              <div class="form-group">
                                <label for="pwd">Recipient Name</label>
                                <input required type="text" class="form-control rounded_form_control" name="<?=$_cart_item[0]?>__name" id="name" value="<?=$_cart_item[4][1]?>">
                              </div>
                            </td>
                            <td class="shipping_comment">
                              <div class="form-group">
                                <label for="comment">Personalised message to recipient <span class="form-italic">(max characters 230)</span></label>
                                <textarea class="form-control rounded_form_control" rows="5" name="<?=$_cart_item[0]?>__comment" id="comment" placeholder=""><?=$_cart_item[4][2]?></textarea>
                              </div>
                          </td>
                        </tr>
                        <?php
                              }else{
                        ?>
                          <!--3-->
                        <tr>
                          <td class="pdt_img"> <img src="<?=$_3d?>" /></td>
                          <td class="cart_des">
                            <h6><?=$_box_data->name?></h6>
                            <span><?=$_box_data->description?></span><br>
                            <b>KES <?=number_format($_box_data->price, 2)?></b>
                          </td>
                          <td>
                            <h6><span class="text-orange"><b>Physical Delivery |</b></span>  Delivered via sendy</h6>
                              <div class="form-group">
                                <label for="pwd">Recipient Name</label>
                                <input required type="text" class="form-control rounded_form_control" name="<?=$_cart_item[0]?>__name" id="name" value="<?=$_cart_item[4][0]?>">
                              </div>
                              <div class="form-group">
                                <label for="pwd">Address</label>
                                <input required type="text" class="form-control rounded_form_control" name="<?=$_cart_item[0]?>__address" id="<?=$_cart_item[0]?>__address" value="<?=$_cart_item[4][1]?>">
                                <?=$util->place_autocomplete($_cart_item[0].'__address')?>
                              </div>
                              <div class="form-group">
                                <label for="pwd">City</label>
                                <input required type="text" class="form-control rounded_form_control" name="<?=$_cart_item[0]?>__city" id="city" value="<?=$_cart_item[4][2]?>">
                              </div>
                              <div class="form-group">
                                <label for="pwd">Province</label>
                                <input required type="text" class="form-control rounded_form_control" name="<?=$_cart_item[0]?>__province" id="province" value="<?=$_cart_item[4][3]?>">
                              </div>
                            </td>
                            <td class="shipping_comment physical_td">
                              <div class="form-group">  
                                <label for="pwd">Postal Code</label>
                                <input required type="text" class="form-control rounded_form_control" name="<?=$_cart_item[0]?>__postal_code" id="postal_code" value="<?=$_cart_item[4][4]?>">
                              </div>
                              <div class="form-group">
                                <label for="pwd">Delivery Contact Name</label>
                                <input required type="text" class="form-control rounded_form_control" name="<?=$_cart_item[0]?>__delivery_name" id="DeliveryContactName" value="<?=$_cart_item[4][5]?>">
                              </div>
                              <div class="form-group">
                                <label for="pwd">Delivery Contact Number</label>
                                <input required type="text" class="form-control rounded_form_control" name="<?=$_cart_item[0]?>__delivery_phone" id="DeliveryContactNumber" value="<?=$_cart_item[4][6]?>">
                              </div>
                          </td>
                        </tr> 
                        <?php 
                              }
                            }
                            endforeach;
                          }else{
                            print '
                            <tr>
                                <td colspan="6">
                                    <small>*No items in cart.</small>
                                </td>
                            </tr>';
                          }
                        
                        ?>
                        <tr class="cart_totals_actions shipping_action_strip">
                          <hr>
                          <td colspan="4" align="right">
                            <a href="<?=$util->ClientHome()?>/"><img src="shared/img/btn-continue-shopping.svg"></a>
                            <button type="submit" class="invisible_btn" name="load"><img src="shared/img/btn-order-summary-blue.svg"></button> 
                            <!-- <a href="<=$util->ClientHome()?>/user-dash-order-summary.php"><img src="shared/img/btn-order-summary-blue.svg"></a>  -->
                          </td>
                        </tr>
                        </form>
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
