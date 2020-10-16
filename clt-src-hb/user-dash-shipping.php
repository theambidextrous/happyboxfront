<?php
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
require_once('../lib/Picture.php');
require_once('../lib/Box.php');
$util = new Util();
$user = new User();
// session_destroy();
$picture = new Picture();
$box = new Box();
$util->ShowErrors(1);
$has_physical_box = [];
$util->Show($_SESSION['curr_usr_cart']);
/** update shipping data */
if(isset($_POST['load']) && isset($_SESSION['curr_usr_cart'])){
  $_ll = 0;
  $_physical_  = [];
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
      array_push($_physical_, 1);
      // $_SESSION['curr_usr_cart'][$_ll][4] = $data;
      // $_SESSION['curr_usr_cart'][$_ll][5] = true;
    }
    $_ll++;
  }
  if(count($_physical_)){
    $data = [
      $_POST['physc_name'],
      $_POST['physc_address'],
      $_POST['physc_city'],
      $_POST['physc_province'],
      $_POST['physc_postal_code'],
      $_POST['physc_delivery_name'],
      $_POST['physc_delivery_phone']
    ];
    $_SESSION['curr_usr_cart'][2000]['physical_address'] = $data;
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

 <body class="client_body">
        <!-- Navigation -->
        <?php include 'shared/partials/nav.php'; ?>
   
   
        <!-- Page Content --> 

    
        <section class=" user_account_sub_banner desktop_view">
            <div class="container">
                <div class="row user_logged_in_nav">
                    <div class="col-md-12">
                    <?php include 'shared/partials/nav-mid.php'; ?>
                    </div>

                </div> </div>
        </section>




        <!--end discover our selection-->
          <!--start desktop-->
        <section class="container section_padding_top desktop_view">
            <div class="row">
                <div class="col-md-12 ">
                      <h3 class="user_blue_title" >SHIPPING METHOD</h3>
                         <!--progress strip-->
                      <div class=" cart_progress_strip row">
                          <div class="col-3 cart_strip"></div>
                          <div class="col-3 shipping_strip"></div>
                          
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
                              if(isset($_cart_item['order_id'])){

                              }elseif(isset($_cart_item['physical_address'])){

                              }else{
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
                                array_push($has_physical_box, 1);
                        ?>
                          <!--3-->
                        <tr>
                          <td class="pdt_img"> <img src="<?=$_3d?>" /></td>
                          <td class="cart_des">
                            <h6><?=$_box_data->name?></h6>
                            <span><?=$_box_data->description?></span><br><br>
                            <b>KES <?=number_format($_box_data->price, 2)?></b>
                          </td>
                          <td>
                            <h6>
                              <span class="text-orange"><b>Physical Delivery |</b></span>  Delivered via sendy
                            </h6>
                          </td>
                          <td class="shipping_comment physical_td"></td>
                        </tr> 
                        <?php 
                              }
                            }
                            endforeach;
                            /** show input for all physical boxes */
                            if(count($has_physical_box)){
                                // $cart_physical_del = $_SESSION['curr_usr_cart'][2000];
                                $cart_physical_del = $_SESSION['curr_usr_cart'][2000]['physical_address'];
                               ?>
                              <tr>
                                <td colspan="4">
                                  <hr>
                                  <h6><span class="text-orange"><b>Delivery Address for All Physical Boxes</b></span> </h6>
                                  <hr>
                                </td>
                              </tr>

                              <tr>
                                <td colspan="2">
                                  <div class="form-group">
                                    <label for="pwd">Recipient Name</label>
                                    <input required type="text" class="form-control rounded_form_control" name="physc_name" id="name" value="<?=$cart_physical_del[0]?>">
                                  </div>
                                  <div class="form-group">
                                    <label for="pwd">Address</label>
                                    <input required type="text" class="form-control rounded_form_control" name="physc_address" id="physc_address" value="<?=$cart_physical_del[1]?>"><?=$util->place_autocomplete('physc_address')?>
                                  </div>
                                  <div class="form-group">
                                    <label for="pwd">City</label>
                                    <input required type="text" class="form-control rounded_form_control" name="physc_city" id="city" value="<?=$cart_physical_del[2]?>">
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    <label for="pwd">Province</label>
                                    <input required type="text" class="form-control rounded_form_control" name="physc_province" id="province" value="<?=$cart_physical_del[3]?>">
                                  </div>
                                  <div class="form-group">  
                                    <label for="pwd">Postal Code</label>
                                    <input required type="text" class="form-control rounded_form_control" name="physc_postal_code" id="postal_code" value="<?=$cart_physical_del[4]?>">
                                  </div>
                                  <div class="form-group">
                                    <label for="pwd">Delivery Contact Name</label>
                                    <input required type="text" class="form-control rounded_form_control" name="physc_delivery_name" id="DeliveryContactName" value="<?=$cart_physical_del[5]?>">
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    <label for="pwd">Delivery Contact Number</label>
                                    <input required type="text" class="form-control rounded_form_control" name="physc_delivery_phone" id="DeliveryContactNumber" value="<?=$cart_physical_del[6]?>">
                                  </div>
                                </td>
                          </tr>

                        <?php  }
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
        <!--end desktop-->

        <!--start mobile-->
        <section class="container section_padding_top mobile_view">
            <div class="row">
                <div class="col-md-12 ">
                      <h3 class="user_blue_title" >SHIPPING METHOD</h3>
                         <!--progress strip-->
                      <div class=" cart_progress_strip row">
                          <div class="col-3 cart_strip"></div>
                          <div class="col-3 shipping_strip"></div>
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
                                array_push($has_physical_box, 1);
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
                            <h6>
                              <span class="text-orange"><b>Physical Delivery |</b></span>  Delivered via sendy
                            </h6>
                          </td>
                          <td class="shipping_comment physical_td"></td>
                        </tr> 
                        <?php 
                              }
                            }
                            endforeach;
                            /** show input for all physical boxes */
                            if(count($has_physical_box)){
                                $cart_physical_del = $_SESSION['curr_usr_cart'][2000]['physical_address'];
                                // $util->Show($_SESSION['curr_usr_cart'][2000]);
                               ?>
                              <tr>
                                <td colspan="4">
                                  <hr>
                                  <h6><span class="text-orange"><b>Delivery Address for All Physical Boxes</b></span> </h6>
                                  <hr>
                                </td>
                              </tr>

                              <tr>
                                <td colspan="2">
                                  <div class="form-group">
                                    <label for="pwd">Recipient Name</label>
                                    <input required type="text" class="form-control rounded_form_control" name="physc_name" id="name" value="<?=$cart_physical_del[0]?>">
                                  </div>
                                  <div class="form-group">
                                    <label for="pwd">Address</label>
                                    <input required type="text" class="form-control rounded_form_control" name="physc_address" id="physc_address" value="<?=$cart_physical_del[1]?>"><?=$util->place_autocomplete('physc_address')?>
                                  </div>
                                  <div class="form-group">
                                    <label for="pwd">City</label>
                                    <input required type="text" class="form-control rounded_form_control" name="physc_city" id="city" value="<?=$cart_physical_del[2]?>">
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    <label for="pwd">Province</label>
                                    <input required type="text" class="form-control rounded_form_control" name="physc_province" id="province" value="<?=$cart_physical_del[3]?>">
                                  </div>
                                  <div class="form-group">  
                                    <label for="pwd">Postal Code</label>
                                    <input required type="text" class="form-control rounded_form_control" name="physc_postal_code" id="postal_code" value="<?=$cart_physical_del[4]?>">
                                  </div>
                                  <div class="form-group">
                                    <label for="pwd">Delivery Contact Name</label>
                                    <input required type="text" class="form-control rounded_form_control" name="physc_delivery_name" id="DeliveryContactName" value="<?=$cart_physical_del[5]?>">
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    <label for="pwd">Delivery Contact Number</label>
                                    <input required type="text" class="form-control rounded_form_control" name="physc_delivery_phone" id="DeliveryContactNumber" value="<?=$cart_physical_del[6]?>">
                                  </div>
                                </td>
                          </tr>

                        <?php  }
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
        <!--end mobile-->
                <!--end add to cart cards-->
                <!--our partners -->
        <?php include 'shared/partials/partners.php'; ?>
        <?php include 'shared/partials/footer.php'; ?>

        <!-- Bootstrap core JavaScript -->

        <?php include 'shared/partials/js.php'; ?>
    </body>

</html>
