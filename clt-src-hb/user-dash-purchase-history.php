<?php
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
require_once('../lib/Order.php');
require_once('../lib/Box.php');
require_once('../lib/Picture.php');
require_once('../lib/Inventory.php');
$util = new Util();
$user = new User();
if (!$util->is_client()) {
    header('Location: user-login.php');
}
$picture = new Picture();
$util->ShowErrors(1);
$box = new Box();
$token = json_decode($_SESSION['usr'])->access_token;
$order_ = new Order($token);
$user_info = json_decode($_SESSION['usr_info']);
$my_list_ = $order_->get_bycustomer($user_info->data->internal_id);
$my_list_ = json_decode($my_list_, true)['data'];
// $util->Show($my_list_);

if (isset($_POST['makecart'])) {
    try {
        $i = new Inventory();
        $stock = json_decode($i->get_purchasable('', $_POST['internal_id']))->stock;
        $ship_type = 2; //e-box
        if ($stock > 0) {
            $ship_type = 1; //p-box
        }
        $item = $_POST['internal_id'];
        $qty = 1;
        $cart_item = [$item, $qty, $ship_type, $stock];
        if (!isset($_SESSION['curr_usr_cart'])) {
            $_SESSION['curr_usr_cart'] = [$cart_item];
        } else {
            if ($util->is_in_cart($item)) {
                $util->update_cart_item($item, $qty, $stock);
            } else {
                array_push($_SESSION['curr_usr_cart'], $cart_item);
            }
        }
    } catch (Exception $e) {
    }
    header("Location: user-dash-shoppingcart.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>HappyBox :: User Dashboard Purchase History</title>

    <!-- Bootstrap core CSS -->
    <?php include 'shared/partials/css.php'; ?>
    <style>
        .user-vhistory {
            color: #c20a2b !important;
            text-decoration: none !important;
            border-bottom: solid 2px #04C1C9 !important;
        }
    </style>
</head>

<body class="client_body">
    <!-- Navigation -->
    <?php include 'shared/partials/nav.php'; ?>
    <!--user dash nav-->
    <section class="">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                </div>
            </div>
        </div>
    </section>

    <!--end user dash nav-->
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
    <!--desktop-->
    <section class="partner_voucher_list section_60 desktop_view">
        <!-- <a href="#" onclick="fdownload()">try download <=$util->tb64('http://127.0.0.1:8000/media/2ko01ggxirz059yqlvgtkreuws1lxrz5.png')?></a> -->
        <div class="container">
            <div class="row ">
                <div class="col-md-12">
                    <h3 class="user_blue_title text-center">MY PURCHASE HISTORY</h3>
                    <p class="txt-orange text-center">A list of your purchased vouchers </p>
                </div>
            </div>
            <?php

            if (count($my_list_)) {
                foreach ($my_list_ as $_list) :
                    $current_order_id = $_list['order_id'];
                    /*echo '<pre>';
                    print_r($_list);
                       echo '</pre>';*/
            ?>
                    <form action="" method="post">
                        <div class="row purch_row">
                            <div class="col-md-9">
                                <div class="table-responsive" id="invoicetodown<?= $_list['id'] ?>">
                                    <div class="purchase_hist html-content">
                                        <?= $_err ?>
                                        <input type="hidden" name="orderid" value="<?= $current_order_id ?>" />
                                        <table class="table purchase_hist table-bordered" id="<?= $current_order_id ?>">
                                            <tr class="purch_hist_tr_td">
                                                <td class="b">ORDER NUMBER</td>
                                                <td><?= $current_order_id ?></td>
                                                <td colspan="4" class="invisible_table"></td>
                                            </tr>
                                            <tr class="purch_hist_tr_td">
                                                <th class="b col_1">IMAGE</th>
                                                <th>BOX NAME</th>
                                                <th>BOX NUMBER</th>
                                                <!-- <th>VOUCHER CODE</th> -->
                                                <th>PURCHASE DATE</th>
                                                <th>BOX TYPE</th>
                                                <th>QUANTITY</th>
                                                <th class="purc_last_td">COST</th>
                                            </tr>
                                            <?php
                                            $this_order = $current_order_id;
                                            $order_full = json_decode($_list['order_string'], true);
                                            $draft_cart = [];
                                            $bx_internal_id = "";
                                            foreach ($order_full as $_cart_item) :
                                                if (isset($_cart_item['order_id'])) {
                                                } elseif (isset($_cart_item['physical_address'])) {
                                                } else {
                                                    $draft_cart[] = $_cart_item;
                                                    $bx_internal_id = $_cart_item[0];
                                                    $_box_data = json_decode($box->get_byidf('00', $_cart_item[0]))->data;
                                                    $_b_cost = floor($_cart_item[1] * $_box_data->price);
                                                    $_media = $picture->get_byitem('00', $_cart_item[0]);
                                                    $_media = json_decode($_media, true)['data'];
                                                    $_3d = 'shared/img/Box_Mockup_01-200x200@2x.png';
                                                    foreach ($_media as $_mm) {
                                                        if ($_mm['type'] == '2') {
                                                            $_3d = $_mm['path_name'];
                                                        }
                                                    }
                                                    if ($_cart_item[2] == 2) {
                                                        /** ebox */
                                            ?>
                                                        <tr>
                                                            <td class="purch_img"><img style="max-width:100px;" class="img-fluid d-block mx-auto purch_his_img" src="<?= $util->tb64($_3d) ?>"></td>
                                                            <td class="purch_blue_td"><b><?= $_box_data->name ?></b></td>
                                                            <td class="purch_blue_td"><b><?= $_box_data->internal_id ?></b></td>

                                                            <!-- <td class="purch_blue_td"><b><?= $_box_data->id ?></b></td>-->
                                                            <td class=""><b><?= date('d/m/Y', strtotime($_list['updated_at'])) ?></b></td>


                                                            <!-- <td class="purch_blue_td"><b><?= date('d/m/Y', strtotime($_list['updated_at'])) ?></b></td>-->

                                                            <td>E-box</td>
                                                            <td><?= $_cart_item[1] ?></td>
                                                            <td>KES <?= number_format($_b_cost, 2) ?></td>
                                                        </tr>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <tr>
                                                            <td class="purch_img"><img style="max-width:100px;" class="img-fluid d-block mx-auto purch_his_img" src="<?= $util->tb64($_3d) ?>"></td>
                                                            <td class="purch_blue_td"><b><?= $_box_data->name ?></b></td>

                                                            <td class="purch_blue_td"><b><?= $_box_data->internal_id ?></b></td>

                                                            <td class=""><b><?= date('d/m/Y', strtotime($_list['updated_at'])) ?></b></td>

                                                            <!--<td class="purch_blue_td"><b><?= $_box_data->internal_id ?></b></td>-->
                                                            <!--  <td class="purch_blue_td"><b><?= date('d/m/Y', strtotime($_list['updated_at'])) ?></b></td>-->
                                                            <td>Physical Box</td>
                                                            <td><?= $_cart_item[1] ?></td>
                                                            <td>KES <?= number_format($_b_cost, 2) ?></td>
                                                        </tr>
                                            <?php
                                                    }
                                                }
                                            endforeach;
                                            ?>
                                            <tr class="">
                                                <td colspan="5" class="td_noborder">
                                                    <input type="hidden" name="internal_id" value='<?= $bx_internal_id ?>' /></td>
                                                <?php
                                                // unset($draft_cart);
                                                ?>
                                                <td colspan="3" align="right" class="td_no_pad">
                                                    <table>
                                                        <tr>
                                                            <td>SUB TOTAL (Incl. VAT)</td>
                                                            <td class="purc_last_td">KES <?= number_format($_list['subtotal'], 2) ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>SHIPPING</td>
                                                            <td>KES <?= number_format($_list['shipping_cost'], 2) ?></td>
                                                        </tr>
                                                        <tr class="bold_txt">
                                                            <td>TOTAL PRICE (Incl. VAT)</td>
                                                            <td>KES <?= number_format($_list['order_totals'], 2) ?></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <!-- end col-md-9 -->
                            </div>
                            <div class="col-md-3 ">
                                <div class="purchase_hist_right">
                                    <div class="down_inv">

                                        <!--<button type="submit" name="makecart"> <img class="img-btn btn-add-to-cart" src="shared/img/btn-add-to-cart-orange.svg"> </button>-->
                                        <img class="img-btn btn-invoice-download" onclick="fdownload('<?= $current_order_id ?>')" src="shared/img/btn-download-orange.svg">

                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- end row -->
            <?php
                endforeach;
            }
            ?>
        </div>
    </section>

    <!--end desktop-->
    <!--mobile-->

    <section class=" user_account mobile_view">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h3 class="text-white user_main_title_mob">MY PURCHASE HISTORY</h3>
                </div>
            </div>
        </div>
    </section>


    <section class=" mobile_view">
        <div class="purch_list_mob  container">
            <div class="row  ">
                <div class="col-md-12 ">
                    <p class="txt-orange text-center mob_pad">A list of your purchased vouchers </p>
                    <?php
                    if (count($my_list_)) {
                        foreach ($my_list_ as $_list) :
                            $current_order_id = $_list['order_id'];
                    ?>
                            <table class="table  voucher_list_table_mob voucher_list_user_table_mob table-borderless" id="minvoicetodown<?= $_list['id'] ?>">
                                <thead>
                                    <tr class="blue_cell_th_mob blue_cell_user_th_mob text-white">
                                        <th style="width:50%;">ORDER NUMBER</th>
                                        <th>PURCHASE DATE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="voucher_list_user_table_mob_tr voucher_list_user_table_mob_tr1">
                                        <td class="v_td_a"><?= $current_order_id ?></td>
                                        <td class="green_txt_valid"><span class=""><b><?= date('d/m/Y', strtotime($_list['updated_at'])) ?></b></span></td>
                                    </tr>
                                    <?php
                                    $this_order = $current_order_id;
                                    $order_full = json_decode($_list['order_string'], true);
                                    $draft_cart = [];
                                    $bx_internal_id = "";
                                    foreach ($order_full as $_cart_item) :
                                        if (isset($_cart_item['order_id'])) {
                                        } elseif (isset($_cart_item['physical_address'])) {
                                        } else {
                                            $draft_cart[] = $_cart_item;
                                            $bx_internal_id = $_cart_item[0];
                                            $_box_data = json_decode($box->get_byidf('00', $_cart_item[0]))->data;
                                            $_b_cost = floor($_cart_item[1] * $_box_data->price);
                                            $_media = $picture->get_byitem('00', $_cart_item[0]);
                                            $_media = json_decode($_media, true)['data'];
                                            $_3d = 'shared/img/Box_Mockup_01-200x200@2x.png';
                                            foreach ($_media as $_mm) {
                                                if ($_mm['type'] == '2') {
                                                    $_3d = $_mm['path_name'];
                                                }
                                            }
                                            $box_type = '';
                                            if ($_cart_item[2] == 2) { //ebox
                                                $box_type = 'Ebox';
                                            } else { // pbox
                                                $box_type = 'Physical Box';
                                            }
                                    ?>
                                            <tr class="purch_hist_img_mob" style="background: #f0f0f0;">
                                                <td class="" colspan="2"><img class="" src="<?= $util->tb64($_3d) ?>"></td>
                                            </tr>
                                            <!--<tr class="voucher_list_user_table_mob_tr">
                                    <td class="v_td_a">Voucher Code</td>
                                    <td>N/A</td>
                                </tr>-->
                                            <tr class="voucher_list_user_table_mob_tr">
                                                <td class="v_td_a">Box Name</td>
                                                <td><?= $_box_data->name ?></td>
                                            </tr>
                                            <tr class="voucher_list_user_table_mob_tr">
                                                <td class="v_td_a">Box Number</td>
                                                <td><?= $_box_data->internal_id ?></td>
                                            </tr>
                                            <tr class="voucher_list_user_table_mob_tr">
                                                <td class="v_td_a"> Box Type</td>
                                                <td><?= $box_type ?></td>
                                            </tr>
                                            <tr class="voucher_list_user_table_mob_tr">
                                                <td class="v_td_a">Expiry Date</td>
                                                <td>N/A</td>
                                            </tr>
                                            <tr class="voucher_list_user_table_mob_tr">
                                                <td class="v_td_a">Quantity</td>
                                                <td><?= $_cart_item[1] ?></td>
                                            </tr>
                                    <?php
                                        }
                                    endforeach;
                                    ?>
                                    <tr class="purch_list_blue_order">
                                        <td class="text-center" colspan="2">Order Options</td>
                                    </tr>
                                    <tr class="v_td_p_r">
                                        <td class="v_td_p1">ADD TO CART <img class="" src="../shared/img/cartp_mob.svg"></td>
                                        <td class="v_td_p2">DOWNLOAD INVOICE <img onclick="fdownload('<?= $current_order_id ?>')" class="" src="../shared/img/downp.svg"></td>
                                    </tr>
                                    <tr class="declare_tr text-center">
                                        <td colspan="2" class="v_td_canc">DECLARE LOSS OR THEFT OF VOUCHER</td>
                                    </tr>
                                </tbody>
                            </table>
                            <!--table 2-->
                            <table class="table  voucher_list_table_mob2 table-borderless">
                                <tbody>
                                    <tr>
                                        <td class="">032598428</td>
                                        <td class="canc_mob_text">15/02/2020</td>
                                    </tr>
                                    <tr>
                                        <td class="">123456789</td>
                                        <td class="reed_mob_text">01/02/2020</td>
                                    </tr>
                                    <tr>
                                        <td class="">326598741</td>
                                        <td class="reed_mob_text">13/01/2020</td>
                                    </tr>
                                </tbody>
                            </table>
                            <!-- end row -->
                    <?php
                        endforeach;
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>
    <!--end mobile-->
    <!--end add to cart cards-->
    <!--our partners -->

    <!-- Invoice Modal -->
    <div class="modal fade" id="printableInvoice">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <!-- Modal body -->
                <div class="modal-body">
                    <div id="printable" style="width:100%;margin:0 auto;padding:0;overflow-x:hidden;background:#fff;">
                        <div style="width:90%;margin:auto;padding-top:12px;padding-bottom:12px;" class="mob_100">
                            <table style="width:100%;border:none;" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td style="width:50%;vertical-align:middle;border:none;"><span style="color:#c20a2b;font-size:49px;font-weight:bold;">INVOICE</span></td>
                                    <td style="vertical-align:middle;border:none;" align="right"><a href="<?= $util->ClientHome() ?>/" target="_blank"><img src="shared/img/happy_logo.png" alt="" style=" width:auto;float:right;height:70px;" /></a></td>
                                </tr>
                            </table>
                        </div>
                        <div style="width:90%;margin:auto;padding-top:12px;padding-bottom:12px;" class="mob_100">
                            <table style="width:100%;border:none;margin-bottom:50px;" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td style="width:35%;margin-bottom:8px;height: 26px;background:#00acb3;color:white;font-weight:bold;padding:7px 30px;border-radius:7px;border:none;"> BILL FROM </td>
                                    <td style="width:30%;border:none;"></td>
                                    <td style="width:35%;margin-bottom:8px;background:#00acb3;height:26px;color:white;font-weight:bold;padding:7px 30px;border-radius:7px;border:none;" align="right"><span style="">BILL TO </span></td>
                                </tr>
                                <tr>
                                    <td style="width:35%;vertical-align:top;border:none;"><span style="font-size:20px;font-weight:bold;">HAPPYBOX</span><br>
                                        <span>P.O. BOX 30275 – Nairobi 00100</span><br>
                                        <span><strong>PIN No.</strong> P051767160R</span></td>
                                    <td style="width:30%;border:none;"></td>
                                    <td style="width:35%;vertical-align:top;border:none;" align="right"><span style="font-size:20px;font-weight:bold;"><?= $user_info->data->fname . " " . $user_info->data->lname ?></span><br>
                                        <span><?= $user_info->data->location ?></span></td>
                                </tr>
                            </table>
                            <div style="width:100%;" id="invoiceData">

                            </div>
                            <table style="width:100%;border:none;margin-top:50px;border:none;" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td style="border:none;" align="right"><span style=" text-align:left;font:normal normal bold 20px/45px Segoe Script;letter-spacing:0px;color:#FFFFFF;text-shadow:0px 3px 6px #00000029;background:#00acb3;border-radius:6px;padding:2px 8px;">Thank you for your business! </span></td>
                                </tr>
                            </table>
                            <div style="width:100%;margin:auto;color:#999999;padding-top:70px;text-align:center;" class="mob_100">
                                <p> If you have any questions about this invoice, please contact us <br>
                                    by email <a href="mailto:customerservices@happybox.ke" style="color:#999999;">customerservices@happybox.ke</a> or by phone <a style="color:#999999;" href="tel:254112454540">+254 112 454 540 </a> </p>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close Preview</button>
                </div>

            </div>
        </div>
    </div>
    <!-- End Invoice Modal -->

    <?php include 'shared/partials/partners.php'; ?>
    <?php include 'shared/partials/footer.php'; ?>

    <!-- Bootstrap core JavaScript -->

    <?php include 'shared/partials/js.php'; ?>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.13/jspdf.plugin.autotable.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/html2canvas@1.0.0-alpha.12/dist/html2canvas.js"></script>
    <script>
        function fdownload(id) {
            $("#invoiceData").html("");
            $("#" + id).clone().appendTo("#invoiceData");
            CreatePDFfromHTML(id);
        }

        function CreatePDFfromHTML(this_order) {
            $('#printableInvoice').modal('show');
            setTimeout(function() {
                html2canvas(document.getElementById("printable")).then(canvas => {
                    var imgData = canvas.toDataURL("image/jpeg", 1);
                    var pdf = new jsPDF("p", "pt", "a4");
                    var pageWidth = pdf.internal.pageSize.getWidth();
                    var pageHeight = pdf.internal.pageSize.getHeight();
                    var imageWidth = canvas.width;
                    var imageHeight = canvas.height;

                    var ratio = imageWidth / imageHeight >= pageWidth / pageHeight ? pageWidth / imageWidth : pageHeight / imageHeight;
                    pdf.addImage(imgData, 'JPEG', 15, 20, imageWidth * ratio, imageHeight * ratio);
                    pdf.save("INV-" + this_order + ".pdf");
                    //$('#printableInvoice').modal('hide');
                });
            }, 500);
        }
    </script>
</body>

</html>