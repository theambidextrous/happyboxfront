<?php
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
require_once('../lib/Picture.php');
require_once('../lib/Box.php');
require_once('../lib/Sendy.php');
require_once('../lib/Order.php');
$util = new Util();
$user = new User();
$picture = new Picture();
$sendy = new Sendy($util->MapsKey());
$box = new Box();
$util->ShowErrors(1);
// $util->Show($_SESSION['usr_info']);
if(empty($_SESSION['curr_usr_cart'][1000]['order_id']) && empty($_SESSION['unpaid_order'])){
  header("Location: user-dash-shipping.php");
}
// if( count( $_SESSION['curr_usr_cart'][2000] ) ){
//   header("Location: user-dash-shipping.php");
// }
$token = json_decode($_SESSION['usr'])->access_token;
$current_order_id = $_SESSION['curr_usr_cart'][1000]['order_id'];
$order_physical_address = $_SESSION['curr_usr_cart'][2000]['physical_address'];

  $_err = '';
  if(isset($_POST['checkout']) && isset($_SESSION['curr_usr_cart'])){
    try{
      $o = new Order($token);
      if($_POST['has_no_ship'] > 0 ){
        //errors found
        throw new Exception('Order error(s), some of your items has no valid shipping data');
      }
      $ex_order = $o->exists($_POST['orderid']);
      if( json_decode($ex_order)->count > 0 ){
        //go to checkout
        $util->redirect_to('user-dash-checkout.php', 3);
      }else{
        //create order and go to checkout
        $body = [
          'order_id' => $_POST['orderid'],
          'customer_buyer' => $_POST['customer_buyer'],
          'order_string' => json_encode($_SESSION['curr_usr_cart']),
          'subtotal' => $_POST['subtotal'],
          'shipping_cost' => $_POST['shipping'],
          'order_totals' => $_POST['total'],
          'token' => $token
        ];
        // $util->Show($body);
        // exit;
        $create_rep = $o->create($body);
        if(json_decode($create_rep)->status == '0'){
          $_SESSION['unpaid_order'] = $_POST['orderid'];
          unset($_SESSION['curr_usr_cart']);
          // $_err = $util->success_flash('order created successfully.. proceeding payment ');
          $util->redirect_to('user-dash-checkout.php', 3);
        }else{
          throw new Exception(json_decode($create_rep)->message);
        }
      }
    }catch(Exception $e){
      $_err = $util->error_flash($e->getMessage());
    }
  }elseif(isset($_SESSION['unpaid_order']) && !isset($_SESSION['curr_usr_cart']) ){
    $util->redirect_to('user-dash-checkout.php', 3);
  }
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
    <!--meta words-->
<meta name="keywords" content="vouchers,birthday gift,valentine gift,gift a gift,christmas gift,easter gift,wedding gift,anniversary gift">
<meta name="description" content="HappyBox issues vouchers to its customers via its website. Each voucher is an opportunity to suggest an appropriate set of experiences for the recipient of the voucher.">
<meta name="robots" content="index, follow">
<link rel="canonical" href="https://happybox.ke/">
<meta property="og:locale" content="en_US">
<meta property="og:type" content="website">
<meta property="og:title" content="HappyBox">
<meta property="og:description" content="HappyBox issues vouchers to its customers via its website. Each voucher is an opportunity to suggest an appropriate set of experiences for the recipient of the voucher.">
<meta property="og:url" content="https://happybox.ke/">
<meta property="og:site_name" content="HappyBox">
<meta property="og:image" content="https://happybox.ke/shared/img/logo.svg">
<meta property="og:image:width" content="320">
<meta property="og:image:height" content="88">        
        <!--end meta words -->
        <title>HappyBox :: User Order Summary</title>
        <!-- Bootstrap core CSS -->
        <?php include '../shared/partials/css.php'; ?>
    </head>
  <body class="client_body">
        <!-- Navigation -->
        <?php include '../shared/partials/nav.php'; ?>
        <!-- Page Content --> 
        <section class=" user_account_sub_banner desktop_view">
            <div class="container">
              <div class="row user_logged_in_nav">
                <div class="col-md-12">
                  <?php include '../shared/partials/nav-mid.php'; ?>
                </div>
              </div>
            </div>
        </section>

        <!--end discover our selection-->
        <section class="container section_padding_top desktop_view">
           
                  <h3 class="user_blue_title" >ORDER SUMMARY</h3>
                  <!--progress strip-->
                     <div class="row">
                <div class="col-md-12 no_pad_lr_desk">
                  <div class=" cart_progress_strip row">
                    <div class="col-3 cart_strip"></div>
                    <div class="col-3 shipping_strip"></div>
                    <div class="col-3 summary_strip"></div>
                      </div>    </div></div><br>
                  <!--end progress strip-->
                   <div class="row">
                <div class="col-md-12 col_rl_no ">
                  <div class="table-responsive">
                    <div class="">
                    <form action="" method="post">
                      <?=$_err?>
                      <input type="hidden" name="orderid" value="<?=$current_order_id?>"/>
                      <div class="table_radius_order_sum">
                      <table class="table order_summary table-bordered">
                        <tr class="order_summary_tr_td">
                          <td class="b">ORDER NUMBER</td>
                          <td><?=$current_order_id?></td>
                          <td colspan="4" class="invisible_table"></td>
                        </tr>
                        <tr class="order_summary_tr_td order_summary_tr_td2">
                          <th class="b col_1">IMAGE</th>
                          <th>BOX NAME</th>
                          <th>BOX TYPE</th>
                          <th>RECIPIENT NAME</th>
                          <th class="delivery_th">DELIVERY ADDRESS</th>               
                          <th class="w_118">COST</th>
                        </tr>
                        <?php
                          $this_order = $current_order_id;
                          // $util->Show($_SESSION['curr_usr_cart']);
                          // $util->Show($sendy->get_lat_long('Riruta Satellite Primary School, Nairobi City, Kenya'));
                          $_has_p_box = $_has_no_ship = $_total_cart = [];
                          if(!empty($_SESSION['curr_usr_cart'])){
                            // $util->Show($_SESSION['curr_usr_cart']);
                            /**  */
                            $_total_shipping = 0;
                            foreach($_SESSION['curr_usr_cart'] as $_cart_item ):
                              if(isset($_cart_item['order_id'])){

                              }elseif(isset($_cart_item['physical_address'])){

                              }else{
                              $_box_data = json_decode($box->get_byidf('00', $_cart_item[0]))->data;
                              $_b_cost = floor($_cart_item[1]*$_box_data->price);
                              $_total_cart[] = $_b_cost;
                              $_media = $picture->get_byitem('00', $_cart_item[0]);
                              $_media = json_decode($_media, true)['data'];
                              $_3d = 'shared/img/Box_Mockup_01-200x200@2x.png';
                              foreach( $_media as $_mm ){
                                  if($_mm['type'] == '2'){$_3d = $_mm['path_name'];}
                              }
                              if($_cart_item[2] == 2){ /** ebox */
                                $_total_shipping = 0;

                        ?>
                        <tr>
                          <td class="">
                            <img class="order_summary_tr_td_img" src="<?=$_3d?>">
                          </td>
                          <td><b><?=$_box_data->name?></b></td>
                          <td>E-box</td>
                          <td><?=$_cart_item[4][1]?></td>
                          <td><?=$_cart_item[4][0]?></td>
                          <td>KES <?=number_format($_b_cost, 2)?></td>
                        </tr>
                        <?php
                              }else{
                                array_push($_has_p_box, 1);
                                $errr = '';
                                // $s_amt = 10;
                                if(!count($order_physical_address)){
                                  $errr = "No delivery address for this physical box";
                                  array_push($_has_no_ship, 1);
                                  $_total_shipping = 0;
                                }
                                $_address_string = $order_physical_address[1];
                        ?>
                        <tr>
                          <td class="">
                            <img class="order_summary_tr_td_img" src="<?=$_3d?>">
                          </td>
                          <td><b><?=$_box_data->name?></b></td>
                          <td>Physical box</td>
                          <td><?=$order_physical_address[0]?></td>
                          <td><?=$_address_string?><br><i><?=$errr?></i></td>
                          <td>KES <?=number_format($_b_cost, 2)?></td>
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
                        
                      </table>
                          <div class="table_radius_order_sum2">
                          <?php
                            if (count($_has_p_box)) {
                              $_total_shipping = $util->AppShipping();
                            }
                          ?>
                          <table class="cart_order_summ table-bordered">
                              <tr>
                                <td>SUB TOTAL (Incl. VAT)</td>
                                <td class="w_11" style="width:118px;">KES <?=number_format(array_sum($_total_cart), 2)?></td>
                              </tr>
                              <tr>
                                <td>SHIPPING</td>
                                <td >KES <?=number_format($_total_shipping,2)?></td>
                              </tr>
                              <tr class="bold_txt">
                                <td>TOTAL PRICE (Incl. VAT)</td>
                                <td>KES <?=number_format((array_sum($_total_cart)+$_total_shipping), 2)?></td>
                              </tr>
                            </table>
                          </div>
                      
                        <!-- hiddens -->
                        <input type="hidden" name="customer_buyer" value="<?=json_decode($_SESSION['usr_info'])->data->internal_id?>"/>
                        <input type="hidden" name="has_p_box" value="<?=array_sum($_has_p_box)?>"/>
                        <input type="hidden" name="has_no_ship" value="<?=array_sum($_has_no_ship)?>"/>
                        <input type="hidden" name="subtotal" value="<?=array_sum($_total_cart)?>"/>
                        <input type="hidden" name="shipping" value="<?=$_total_shipping?>"/>
                        <input type="hidden" name="total" value="<?=(array_sum($_total_cart)+$_total_shipping)?>"/>
                        <table class="order_summ_actions">
                        <tr align="right" class="cart_totals  cart_totals_actions ">
                          <td colspan="6 ">
                            <a href="<?=$util->ClientHome()?>/user-dash-shipping.php"><img src="<?=$util->AppHome()?>/shared/img/btn-back-to-shipping-orange.png"></a>
                            <?php 
                            if(!isset(json_decode($_SESSION['usr'])->access_token)){
                            ?>
                              <a href="<?=$util->ClientHome()?>/user-login.php">Login To Complete Order</a>
                            <?php }else{ ?>
                              <button type="submit" class="invisible_btn" name="checkout"><img src="<?=$util->AppHome()?>/shared/img/btn-checkout-blue.png"></button> 
                              <!-- <a href="<=$util->ClientHome()?>/user-dash-checkout.php"><img src="<?=$util->AppHome()?>/shared/img/btn-checkout-blue.svg"></a> -->
                            <?php } ?>
                          </td>
                        </tr>
                        </table>
                      </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </section>
         <!--start mobile-->
        <section class="container section_padding_top mobile_view" id="yourDiv">
            <div class="row">
                <div class="col-md-12 no_padd">
                    <h3 class="user_blue_title cart_yellow_h_mob order_summ_mob" >ORDER SUMMARY</h3>
                    <!--progress strip-->
                    
                    <!--end progress strip-->
                    <div>
                    
                    </div>
                </div>
            </div>
              <div class=" container">
            <div class=" cart_progress_strip row">
                    <div class="col-3 cart_strip"></div>
                    <div class="col-3 shipping_strip"></div>
                    <div class="col-3 summary_strip"></div>
                  </div> </div>
        </section>
          <section class="container mobile_view ">
            <div class="row">
                <div class="col-md-12 ">
                <form method="post">
                  <!--end progress strip-->
                  <?php
                $this_order = $current_order_id;
                // $util->Show($_SESSION['curr_usr_cart']);
                // $util->Show($sendy->get_lat_long('Riruta Satellite Primary School, Nairobi City, Kenya'));
                $_has_p_box = $_has_no_ship = $_total_cart = [];
                if(!empty($_SESSION['curr_usr_cart'])){
                  // $util->Show($_SESSION['curr_usr_cart']);
                  /**  */
                  $_total_shipping = 0;
                  foreach($_SESSION['curr_usr_cart'] as $_cart_item ):
                    if(isset($_cart_item['order_id'])){

                    }elseif(isset($_cart_item['physical_address'])){

                    }else{
                    $_box_data = json_decode($box->get_byidf('00', $_cart_item[0]))->data;
                    $_b_cost = floor($_cart_item[1]*$_box_data->price);
                    $_total_cart[] = $_b_cost;
                    $_media = $picture->get_byitem('00', $_cart_item[0]);
                    $_media = json_decode($_media, true)['data'];
                    $_3d = 'shared/img/Box_Mockup_01-200x200@2x.png';
                    foreach( $_media as $_mm ){
                      if($_mm['type'] == '2'){$_3d = $_mm['path_name'];}
                    }
                    $box_type = '';
                    $addressing_name = $addressing_address = '';
                    if($_cart_item[2] == 2){ /** ebox */
                      $box_type = 'E-box';
                      $_total_shipping = 0;
                      $addressing_name = $_cart_item[4][1];
                      $addressing_address = $_cart_item[4][0];
                    }
                    else{
                      array_push($_has_p_box, 1);
                      $errr = '';
                      // $s_amt = 10;
                      if(!count($order_physical_address)){
                        $errr = "No delivery address for this physical box";
                        array_push($_has_no_ship, 1);
                        $_total_shipping = 0;
                      }
                      $_address_string = $order_physical_address[1];
                      $addressing_name = $order_physical_address[0];
                      $addressing_address = $order_physical_address[1];
                      $box_type = 'Physical Box';
                    }
                      ?>
                      <table class="p-2 cart-table table-borderless shipping_table">
                          <tr>
                              <td class="pdt_img_mob"> <img src="<?=$_3d?>" /></td>
                              <td class="cart_des">
                                  <h6><?=$_box_data->name?></h6>
                                  <h6><span class="text-orange"><b><?=$box_type?> |</b></span>  deliver to:</h6>
                                  <span>
                                     <?=$addressing_name?> <br><?=$addressing_address?>
                                  </span>
                                  <br>  <br>
                                  <b>KES <?=number_format($_b_cost, 2)?></b>
                              </td>
                          </tr>
                      </table>
                        <?php 
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

                            if (count($_has_p_box)) {
                              $_total_shipping = $util->AppShipping();
                            }
                          
                          ?>
                          <!-- hiddens -->
                          <input type="hidden" name="orderid" value="<?=$current_order_id?>"/>
                        <input type="hidden" name="customer_buyer" value="<?=json_decode($_SESSION['usr_info'])->data->internal_id?>"/>
                        <input type="hidden" name="has_p_box" value="<?=array_sum($_has_p_box)?>"/>
                        <input type="hidden" name="has_no_ship" value="<?=array_sum($_has_no_ship)?>"/>
                        <input type="hidden" name="subtotal" value="<?=array_sum($_total_cart)?>"/>
                        <input type="hidden" name="shipping" value="<?=$_total_shipping?>"/>
                        <input type="hidden" name="total" value="<?=(array_sum($_total_cart)+$_total_shipping)?>"/>
                        <table>
                          <tr align="right" class="cart_totals tr_border_top cart_totals_actions">
                            <td colspan="6 ">
                                  <?php 
                              if(!isset(json_decode($_SESSION['usr'])->access_token)){
                              ?>
                                <a href="<?=$util->ClientHome()?>/user-login.php">Login To Complete Order</a>
                              <?php }else{ ?>
                                <button type="submit" class="invisible_btn" name="checkout"><img src="<?=$util->AppHome()?>/shared/img/checkout_mob.png"></button> 
                            
                              <?php } ?>
                              <a href="<?=$util->ClientHome()?>/user-dash-shipping.php"><img src="<?=$util->AppHome()?>/shared/img/btn-back-to-shipping-orange.png"></a>
                          
                            </td>
                          </tr>
                        </table>
                        </form>
                </div></div></section>
         <!-- end mobile -->
            <!--end add to cart cards-->
            <!--our partners -->
        <?php include '../shared/partials/partners.php'; ?>
        <?php include '../shared/partials/footer.php'; ?>

        <!-- Bootstrap core JavaScript -->

        <?php include '../shared/partials/js.php'; ?>
        




    </body>

</html>
