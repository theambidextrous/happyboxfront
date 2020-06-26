<?php
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
require_once('../lib/Picture.php');
require_once('../lib/Order.php');
$util = new Util();
$user = new User();
$picture = new Picture();
$util->ShowErrors(1);
if(!isset(json_decode($_SESSION['usr'])->access_token)){
    $_SESSION['next'] = 'user-dash-checkout.php';
    header("Location: user-login.php");
}
if(empty($_SESSION['unpaid_order'])){
    header("Location: user-dash-shipping.php");
}
$token = json_decode($_SESSION['usr'])->access_token;
$order = new Order($token);
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Happy Box:: User Checkout</title>

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
        <section class="container section_padding_top  ">
            <div class="row">
                <div class="col-md-12">
                     <h3 class="user_blue_title" >ORDER PAYMENT</h3>
                </div>
                 
            </div>
            <!--progress strip-->
            <div class=" cart_progress_strip row">
                <div class="col-md-3 cart_strip"></div>
                <div class="col-md-3 shipping_strip"></div>
                <div class="col-md-3 summary_strip"></div>
                <div class="col-md-3 payment_strip"></div>
            </div><br>
            <!--end progress strip-->
            <div class="row justify-content-center section_padding_top">
                <div class="col-md-7 text-center">
                    <div class="card border_card_checkout">
                        <?php
                        $order_data = json_decode($order->get_one_byorder_limited($_SESSION['unpaid_order']), true)['data'];
                        // $util->Show($order_data);
                        ?>
                        <b> UNPAID ORDER: <?=$_SESSION['unpaid_order']?></b> 
                        <b> AMOUNT: KES <?=number_format(($order_data['shipping_cost']+$order_data['subtotal']), 2)?></b> 
                        <!-- <b> SUB-TOTAL: <=number_format($order_data['subtotal'], 2)?></b> 
                        <b> SHIPPING: KES<=number_format($order_data['shipping_cost'], 2)?></b>
                        <b> TOTAL: KES <=number_format(($order_data['shipping_cost']+$order_data['subtotal']), 2)?></b>  -->
                        <br>Choose your preferred payment method to continue
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="pay_strip">
                        <!-- <a href="" class="btn btn-sm btn-orange text-white">MPESA</a> 
                        <a href="" class="btn btn-sm btn-orange text-white">CREDIT CARD</a> -->
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active btn btn-sm" id="mpesa-tab" data-toggle="tab" href="#mpesa" role="tab" aria-controls="mpesa" aria-selected="true">MPesa</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link btn btn-sm" id="creditcard-tab" data-toggle="tab" href="#creditcard" role="tab" aria-controls="creditcard" aria-selected="false">Credit Card</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="mpesa" role="tabpanel" aria-labelledby="mpesa-tab">
                                <!-- debug -->
                                    <div id="c2b"></div>
                                    <hr>
                                    <div id="express"></div>
                                <!-- end debug -->
                                <br><br>
                                <form class="form_register_user" id="mpesa_pay_frm" name="mpesa_pay_frm">
                                    <div class="form-group col-md-6">
                                        <input type="hidden" value="<?=$_SESSION['unpaid_order']?>" name="ordernumber">
                                        <input type="hidden" value="<?=floor($order_data['shipping_cost']+$order_data['subtotal'])?>" name="orderamount">
                                        <input type="text" name="mpesaphone" class="form-control rounded_form_control" placeholder="enter your mpesa phone e.g 07XX">
                                    </div>
                                    <p class="text-right col-md-4"><button type="button" onclick="mpesaPay('mpesa_pay_frm')" class="btn btn_rounded">Pay Now</button></p>
                                </form>
                                <!-- instructions area -->
                                <div id="msg"></div>
                                <div id="inst"></div>
                                <!-- instructions end -->
                            </div>
                            <div class="tab-pane fade" id="creditcard" role="tabpanel" aria-labelledby="creditcard-tab">
                                <p>Credit Card</p>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
            <div class="row justify-content-around section_padding_top">
                <div class="col-md-12">
                    <div class="payment_back ">
                        <a href="<?=$util->ClientHome()?>/user-dash-order-summary.php"><img src="shared/img/icn-arrow-teal.svg"> BACK TO ORDER SUMMARY</a>
                    </div>
                </div>
            </div>
        </section>
        <!--end add to cart cards-->
         <!-- pop up mpesa-->
        <!-- <button type="button" id="popupid" style="display:none;" class="btn btn_rounded" data-toggle="modal" data-target="#mpesaModal"></button>
        <div class="modal fade" id="mpesaModal">
            <div class="modal-dialog general_pop_dialogue">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <div class="col-md-12 text-center forgot-dialogue-borderz">
                            <h3 class="partner_blueh">THANK YOU!</h3>
                            <p class="forgot_des text-center txt-orange"><span id="vvv"></span></p>
                        <div>
                        <img src="shared/img/btn-okay-orange.svg" class="password_ok_img" data-dismiss="modal"/>
                    </div>
                </div>
            </div>
        </div> -->
        <!--our partners -->
        <?php include 'shared/partials/partners.php'; ?>
        <?php include 'shared/partials/footer.php'; ?>
        <!-- Bootstrap core JavaScript -->
        <?php include 'shared/partials/js.php'; ?>
    <script>
        $(document).ready(function(){
            mpesaPay = function(FormId){
            waitingDialog.show('sending... Please wait',{headerText:'',headerSize: 6,dialogSize:'sm'});
            var dataString = $("form[name=" + FormId + "]").serialize();
            $.ajax({
                type: 'post',
                url: '<?=$util->AjaxHome()?>?activity=make-payment-mpesa',
                data: dataString,
                success: function(res){
                    // console.log(res);
                    var rtn = JSON.parse(res);
                    if(rtn.hasOwnProperty("MSG")){
                        $('#c2b').text(rtn.c2b);
                        $('#express').text(rtn.exp);
                        $('#inst').html(rtn.inst);
                        $('#msg').html(rtn.MSG);
                        waitingDialog.hide();
                        return;
                    }
                    else if(rtn.hasOwnProperty("ERR")){
                        $('#msg').html(rtn.ERR);
                        waitingDialog.hide();
                        return;
                    }
                }
            });
            }

        });
  </script>
    </body>
</html>
