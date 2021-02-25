<?php 
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
require_once('../lib/Box.php');
require_once('../lib/Inventory.php');
require_once('../lib/Order.php');
$util = new Util();
$user = new User();
$inventory = new Inventory();
$util->ShowErrors(1);
$user->is_loggedin();
$token = json_decode($_SESSION['usr'])->access_token;
$box = new Box();
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

        <title>Happy Box:: POS Sales</title>
        <!-- Bootstrap core CSS -->
        <?php include 'admin-partials/css.php'; ?>
        <style>
            .admin-pos{
                color: #c20a2b!important;
                text-decoration: none!important;
                border-bottom: solid 2px #c20a2b!important;
            }
        </style>
    </head>

    <body>

        <!-- Navigation -->
        <?php include 'admin-partials/nav.php'; ?>


        <section class="container section_padding_top top_menu">
            <div class="row">
                <div class="col-md-12">
                <?php include 'admin-partials/mid-nav.php'; ?>
                </div>

            </div>
        </section>
        <!--end discover our selection-->
        <section class=" top_blue_bar ">
            <div class="container">
                <div class="row">
                    <div class="col-6 section_title">
                        <h3>Point of Sale</h3>
                    </div>
                    <div class="col-6 text-right">
                        <!-- <a class="btn generate_rpt" href="#" data-toggle="modal" data-target="#generate_box" >GENERATE BOXES</a> -->
                    </div>
                </div>
            </div>
        </section>
        <section class=" status_bar ">
            <br>
            <div class="container justify-content-around">
                <div class="row ">
                    <div class="col-md-2">
                        <a href="admin-pos.php" class="btn generate_rpt btn-block">Make Sale</a>
                    </div>
                    <div class="col-md-2">
                        <a href="admin-pos-sales.php" class="btn generate_rpt btn-block is_active">Sales Report</a>
                    </div>
                </div>
            </div>
        </section>
        <section class=" data+table_section ">
            <div class="container">
                <div class="row ">
                    <div class="col-md-12 ">
                        <div class="table-responsive">
                        <br>
                        <h3>POS Sales Report</h3>
                        <?php 
                            $order = new Order($token);
                            $all_pos_sales = [];
                            $inv = $order->pos_find_sales();
                            if(json_decode($inv)->status == '0')
                            {
                                $all_pos_sales = json_decode($inv, true)['data'];
                            }
                            $util->Show($all_pos_sales);
                        ?>
                        <table class="table table_data1 table-bordered reportable">
                            <thead>
                                <tr>
                                    <th>Order Number</th>
                                    <th>Customer Buyer Name</th>
                                    <th>Customer Buyer Surname</th>
                                    <th>Customer Buyer Email</th>
                                    <th>Customer Buyer Phone</th>
                                    <th>Customer Buyer Payment Method</th>
                                    <th>Box Puchase Date</th>
                                    <th>Sale Type</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                foreach( $all_pos_sales as $pos ):
                            ?>
                                <tr>
                                    <td><?=$pos['order_number']?></td>
                                    <td><?=$pos['customer_buyer_id']?></td>
                                    <td><?=$pos['customer_buyer_id']?></td>
                                    <td><?=$pos['customer_buyer_id']?></td>
                                    <td><?=$pos['customer_buyer_id']?></td>
                                    <td><?=$pos['customer_payment_method']?></td>
                                    <td><?=$pos['box_purchase_date']?></td>
                                    <td><?=$pos['is_pos']?></td>
                                </tr>
                            <?php 
                                endforeach;
                            ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Order Number</th>
                                    <th>Customer Buyer Name</th>
                                    <th>Customer Buyer Surname</th>
                                    <th>Customer Buyer Email</th>
                                    <th>Customer Buyer Phone</th>
                                    <th>Customer Buyer Payment Method</th>
                                    <th>Box Puchase Date</th>
                                    <th>Sale Type</th>
                                </tr>
                            </tfoot>
                        </table>
                        </div>
                    </div>
                 </div>
            </div>
        </section>

<br><br><br>
 <?php include 'admin-partials/footer.php'; ?>
<!-- Bootstrap core JavaScript -->
<?php include 'admin-partials/js.php'; ?>
  <!-- end popup -->
 </body>
</html>
