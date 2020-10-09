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
// $util->Show($_SESSION);
unset($_SESSION['next']);
if(!isset(json_decode($_SESSION['usr'])->access_token)){
  $_SESSION['next'] = 'user-dash-order-summary.php';
  header("Location: user-login.php");
}
if(empty($_SESSION['curr_usr_cart'][1000]['order_id']) && empty($_SESSION['unpaid_order'])){
  header("Location: user-dash-shipping.php");
}
if( count( $_SESSION['curr_usr_cart'][2000] ) ){
  header("Location: user-dash-shipping.php");
}
$token = json_decode($_SESSION['usr'])->access_token;
$current_order_id = $_SESSION['curr_usr_cart'][1000]['order_id'];
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Happy Box:: User Order SummarSy</title>
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
              </div>
            </div>
        </section>

        <!--end discover our selection-->
        <section class="container section_padding_top desktop_view">
            <div class="row">
                <div class="col-md-12 ">
                  <h3 class="user_blue_title" >ORDER SUMMARY</h3>
                  <!--progress strip-->
                  <div class=" cart_progress_strip row">
                    <div class="col-3 cart_strip"></div>
                    <div class="col-3 shipping_strip"></div>
                    <div class="col-3 summary_strip"></div>
                  </div><br>
                  <!--end progress strip-->
                  <div class="table-responsive">
                    <div class="">
                    <?php
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
                              $util->timed_redirect('user-dash-checkout.php');
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
                              $create_rep = $o->create($body);
                              if(json_decode($create_rep)->status == '0'){
                                $_SESSION['unpaid_order'] = $_POST['orderid'];
                                unset($_SESSION['curr_usr_cart']);
                                $_err = $util->success_flash('order created successfully.. proceeding payment ');
                                $util->timed_redirect('user-dash-checkout.php');
                              }else{
                                throw new Exception(json_decode($create_rep)->message);
                              }
                            }
                          }catch(Exception $e){
                            $_err = $util->error_flash($e->getMessage());
                          }
                        }elseif(isset($_SESSION['unpaid_order']) && !isset($_SESSION['curr_usr_cart']) ){
                          $util->timed_redirect('user-dash-checkout.php');
                        }
                    ?>
                    <form action="" method="post">
                      <?=$_err?>
                      <input type="hidden" name="orderid" value="<?=$current_order_id?>"/>
                      <table class="table order_summary table-bordered">
                        <tr class="order_summary_tr_td">
                          <td class="b">ORDER NUMBER</td>
                          <td><?=$current_order_id?></td>
                          <td colspan="4" class="invisible_table"></td>
                        </tr>
                        <tr class="order_summary_tr_td">
                          <th class="b col_1">IMAGE</th>
                          <th>BOX NAME</th>
                          <th>BOX TYPE</th>
                          <th>RECIPIENT NAME</th>
                          <th>DELIVERY ADDRESS</th>               
                          <th>COST</th>
                        </tr>
                        <?php
                          $this_order = $current_order_id;
                          // $util->Show($_SESSION['curr_usr_cart']);
                          // $util->Show($sendy->get_lat_long('Riruta Satellite Primary School, Nairobi City, Kenya'));
                          $_has_p_box = $_has_no_ship = [];
                          if(!empty($_SESSION['curr_usr_cart'])){
                            // $util->Show($_SESSION['curr_usr_cart']);
                            /**  */
                            foreach($_SESSION['curr_usr_cart'] as $_cart_item ):
                              if(!isset($_cart_item['order_id'])){
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
                                $_total_shipping[] = 0;

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
                                try{
                                  $sendy_resp = $sendy->post_fields($_cart_item, $this_order, $box, 'quote');
                                  // $util->Show($sendy_resp);
                                  $errr = '';
                                  // $s_amt = 10;
                                  if(json_decode($sendy_resp)->status){
                                    $s_amt = json_decode($sendy_resp)->data->amount;
                                    // $errr = 'Cost of delivering: KES ' . $s_amt;
                                    // $_total_shipping[] = $s_amt;
                                  }elseif(isset(json_decode($sendy_resp)->data)){
                                    $errr = $util->error_flash(json_decode($sendy_resp)->data);
                                    array_push($_has_no_ship, 1);
                                    $_total_shipping[] = 0;
                                  }else{
                                    $errr = $util->error_flash(json_decode($sendy_resp)->description);
                                    array_push($_has_no_ship, 1);
                                    $_total_shipping[] = 0;
                                  }
                                }catch(Exception $e){
                                  $errr = $util->error_flash($e->getMessage());
                                  $_total_shipping[] = 0;
                                  array_push($_has_no_ship, 1);
                                }
                                $_address_string = ucwords(strtolower($_cart_item[4][1])).', '. strtoupper($_cart_item[4][2]).', '. $_cart_item[4][4];
                        ?>
                        <tr>
                          <td class="">
                            <img class="order_summary_tr_td_img" src="shared/img/Box_Mockup_01-200x200@2x.png">
                          </td>
                          <td><b><?=$_box_data->name?></b></td>
                          <td>Physical box</td>
                          <td><?=$_cart_item[4][0]?></td>
                          <td><?=$_address_string?><br><i>*<?=$errr?></i></td>
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
                        <tr class="">
                          <td colspan="4" class=""></td>
                          <td colspan="2" align="right" class="">
                            <table>
                              <tr>
                                <td>SUB TOTAL (Incl. VAT)</td>
                                <td>KES <?=number_format(array_sum($_total_cart), 2)?></td>
                              </tr>
                              <tr>
                                <td>SHIPPING</td>
                                <td>KES <?=number_format(array_sum($_total_shipping),2)?></td>
                              </tr>
                              <tr class="bold_txt">
                                <td>TOTAL PRICE (Incl. VAT)</td>
                                <td>KES <?=number_format((array_sum($_total_cart)+array_sum($_total_shipping)), 2)?></td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                        <!-- hiddens -->
                        <input type="hidden" name="customer_buyer" value="<?=json_decode($_SESSION['usr_info'])->data->internal_id?>"/>
                        <input type="hidden" name="has_p_box" value="<?=array_sum($_has_p_box)?>"/>
                        <input type="hidden" name="has_no_ship" value="<?=array_sum($_has_no_ship)?>"/>
                        <input type="hidden" name="subtotal" value="<?=array_sum($_total_cart)?>"/>
                        <input type="hidden" name="shipping" value="<?=array_sum($_total_shipping)?>"/>
                        <input type="hidden" name="total" value="<?=(array_sum($_total_cart)+array_sum($_total_shipping))?>"/>
                        <tr align="right" class="cart_totals tr_border_top cart_totals_actions">
                          <td colspan="6 ">
                            <a href="<?=$util->ClientHome()?>/user-dash-shipping.php"><img src="shared/img/btn-back-to-shipping-orange.svg"></a>
                            <?php 
                            if(!isset(json_decode($_SESSION['usr'])->access_token)){
                            ?>
                              <a href="<?=$util->ClientHome()?>/user-login.php">Login To Complete Order</a>
                            <?php }else{ ?>
                              <button type="submit" class="invisible_btn" name="checkout"><img src="shared/img/btn-checkout-blue.svg"></button> 
                              <!-- <a href="<=$util->ClientHome()?>/user-dash-checkout.php"><img src="shared/img/btn-checkout-blue.svg"></a> -->
                            <?php } ?>
                          </td>
                        </tr>
                      </table>
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
                    
                     
                           <!--end progress strip-->
                      <table class="p-2 cart-table table-borderless shipping_table">
                          
                          <tr>
                              <td class="pdt_img_mob"> <img src="../shared/img/Box_Mockup_01-200x200new.png" /></td>
                              <td class="cart_des">
                                  <h6>Box One</h6>
                                  <h6><span class="text-orange"><b>E-Box |</b></span>  deliver to:</h6>
                                  <span>
                                      Jane Bloggs <br>abc@delivermybox.ke
                                  </span>
                                  <br>  <br>
                                  <b>KES20 000.00</b>
                              </td>
                          </tr>
                          <tr>
                          
                              
      </tr>
 

  </form>  


                                        
                       
                      </table>
                           <!-- box 2-->
                           <table class="p-2 cart-table table-borderless shipping_table">
                          
                          <tr>
                              <td class="pdt_img_mob"> <img src="../shared/img/Box_Mockup_01-200x200new.png" /></td>
                              <td class="cart_des">
                                  <h6>Box Two</h6>
                                   <h6><span class="text-orange"><b>Physical Delivery |</b></span> <b> deliver to:</b></h6>
                                <span>
                                     Joe Bloggs <br>123 Box Street, Nairobi, Kenya, 1234
                                  </span>
                                  <br>  <br>
                                  <b>KES20 000.00</b>
                              </td>
                          </tr>
                          <tr>
                          
                              
      </tr>
 

  </form>  


                                        
                       
                      </table>
                           <!--3-->
                            <table class="p-2 cart-table table-borderless shipping_table">
                          
                          <tr>
                              <td class="pdt_img_mob"> <img src="../shared/img/Box_Mockup_01-200x200new.png" /></td>
                              <td class="cart_des">
                                  <h6>Box Three</h6>
                                  <h6><span class="text-orange"><b>E-Box |</b></span>  deliver to:</h6>
                                  <span>
                                      Jane Bloggs <br>abc@delivermybox.ke
                                  </span>
                                  <br>  <br>
                                  <b>KES20 000.00</b>
                              </td>
                          </tr>
                          <tr>
                          
                              
      </tr>
 

  </form>  


                                        
                       
                      </table>
                               <table>
                            <tr align="right" class="cart_totals tr_border_top cart_totals_actions">
                          <td colspan="6 ">
                                 <?php 
                            if(!isset(json_decode($_SESSION['usr'])->access_token)){
                            ?>
                              <a href="<?=$util->ClientHome()?>/user-login.php">Login To Complete Order</a>
                            <?php }else{ ?>
                              <button type="submit" class="invisible_btn" name="checkout"><img src="shared/img/checkout_mob.svg"></button> 
                          
                            <?php } ?>
                            <a href="<?=$util->ClientHome()?>/user-dash-shipping.php"><img src="shared/img/btn-back-to-shipping-orange.svg"></a>
                         
                          </td>
                        </tr>
                        </table>
                        
                           
                </div></div></section>
         <!-- end mobile -->
            <!--end add to cart cards-->
            <!--our partners -->
        <?php include 'shared/partials/partners.php'; ?>
        <?php include 'shared/partials/footer.php'; ?>

        <!-- Bootstrap core JavaScript -->

        <?php include 'shared/partials/js.php'; ?>
        




    </body>

</html>
