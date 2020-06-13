<?php 
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
require_once('../lib/Box.php');
require_once('../lib/Inventory.php');
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
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Happy Box:: Admin Portal</title>
        <!-- Bootstrap core CSS -->
        <?php include 'admin-partials/css.php'; ?>
        <style>
            .admin-b-inventory{
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
                        <h3>BOX INVENTORY</h3>
                    </div>
                    <div class="col-6 text-right">
                        <a class="btn generate_rpt" href="#" data-toggle="modal" data-target="#generate_box" >GENERATE BOXES</a>
                    </div>
                </div>
            </div>
        </section>
        <section class=" status_bar ">
            <br>
            <div class="container justify-content-around">
                <div class="row ">
                    <div class="col-md-2">
                        <a href="admin-box-inventory.php" class="btn generate_rpt btn-block is_active">Purchased</a>
                    </div>
                    <div class="col-md-2">
                        <a href="admin-box-inventory-activated.php" class="btn generate_rpt btn-block">Activated</a>
                    </div>
                    <div class="col-md-2">
                        <a href="admin-box-inventory-redeemed.php" class="btn generate_rpt btn-block">Redeemed</a>
                    </div>
                    <div class="col-md-2">
                        <a href="admin-box-inventory-cancelled.php" class="btn generate_rpt btn-block">Cancelled</a>
                    </div>
                    <div class="col-md-2">
                        <a href="admin-box-inventory-expired.php" class="btn generate_rpt btn-block">Expired</a>
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
                        <?php 
                            $all_happyboxes_inventory = json_decode($inventory->get_by_vstatus($token, '2'), true)['data'];
                            // $util->show($all_happyboxes_inventory);
                            try{
                                if(isset($_POST['generate'])){
                                    if($_POST['boxname'] == 'nn'){
                                        throw new Exception('You must select a box');
                                    }
                                    if($_POST['quantity'] < 1){
                                        throw new Exception('Invalid Quantity');
                                    }
                                    $qty = $_POST['quantity'] + 1;
                                    $counter = 1;
                                    $created_cnt = [];
                                    while( $counter < $qty){
                                        $inventory = new Inventory($_POST['boxname'], '00');
                                        $rs = $inventory->create($token);
                                        if(json_decode($rs)->status != '0'){
                                            throw new Exception('Error occured. Inventory generation did not complete, only ' . array_sum($created_cnt) . ' boxes were generated');
                                        }
                                        array_push($created_cnt, 1);
                                        $counter++;
                                    }
                                    print $util->success_flash(array_sum($created_cnt) .'Inventory Items generated!');
                                }
                            }catch(Exception $e ){
                                print $util->error_flash($e->getMessage());
                            }
                        ?>
                        <table class="table table_data1 table-bordered">
                            <thead>
                                <tr>
                                    <th>Order Number</th>
                                    <th>Customer Buyer Name</th>
                                    <th>Customer Buyer Surname</th>
                                    <th>Customer Buyer Email</th>
                                    <th>Customer Buyer Phone</th>
                                    <th>Customer Buyer Payment Method</th>
                                    <th>Box Delivery Address</th>
                                    <th>Box Puchase Date</th>
                                    <th>Box Validity Date</th>
                                    <th>Customer Buyer Invoice Number</th>
                                    <th>Box Barcode</th>
                                    <th>Box Name</th>
                                    <th>Voucher Code</th>
                                    <th>New Voucher Code</th>
                                    <th>Voucher Status</th>
                                    <th>Voucher Activation Date</th>
                                    <th>Customer User Name</th>
                                    <th>Customer User Surname</th>
                                    <th>Customer User Email</th>
                                    <th>Customer User Phone</th>
                                    <th>Redeemed Date</th>
                                    <th>Cancellation Date</th>
                                    <th>Booking Date</th>
                                    <th>Box Price</th>
                                    <th>Partner Reimbursment Due Date</th>
                                    <th>Partner Reimbursment Effective Date</th>
                                    <th>Partner Reimbursment</th>
                                    <th>Partner Identity</th>
                                    <th>Partner Invoice number</th>
                                    <th>Administrative Functions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach($all_happyboxes_inventory as $hbox ):
                                    $customer_buyer = !isset(json_encode($user->get_details($hbox['customer_buyer_id']))->data)?json_encode($user->get_details($hbox['customer_buyer_id']))->data:json_decode(json_encode(['object']));
                                    $customer_user = json_encode( $user->get_details($hbox['customer_user_id']) )->data;
                                    $box_data = json_decode($box->get_byidf($token, $hbox['box_internal_id']))->data;
                                    /** customer buyer */
                                    $cb_name = $customer_buyer->fname . ' ' . $customer_buyer->mname;
                                    $cb_sname = $customer_buyer->sname;
                                    $cb_email = $customer_buyer->email;
                                    $cb_phone = $customer_buyer->email;
                                    /** customer user */
                                    $cu_name = $customer_user->fname . ' ' . $customer_user->mname;
                                    $cu_sname = $customer_user->sname;
                                    $cu_email = $customer_user->email;
                                    $cu_phone = $customer_user->email;
                                    /** box status */
                                    $box_v_status_name = null;
                                    if($hbox['box_voucher_status'] == '1'){
                                        $box_v_status_name = 'In stock';
                                    }elseif($hbox['box_voucher_status'] == '2'){
                                        $box_v_status_name = 'Purchased';
                                    }elseif($hbox['box_voucher_status'] == '3'){
                                        $box_v_status_name = 'Redeemed';
                                    }elseif($hbox['box_voucher_status'] == '4'){
                                        $box_v_status_name = 'Cancelled';
                                    }elseif($hbox['box_voucher_status'] == '4'){
                                        $box_v_status_name = 'Expired';
                                    }
                                ?>
                                <tr>
                                    <td>
                                        <?=!is_null($hbox['order_number'])?$hbox['order_number']:'null'?>
                                    </td>
                                    <!-- customer buyer -->
                                    <td>
                                        <?=!is_null($cb_name)?$cb_name:'null'?>
                                    </td>
                                    <td>
                                        <?=!is_null($cb_sname)?$cb_sname:'null'?>
                                    </td>
                                    <td>
                                        <?=!is_null($cb_email)?$cb_email:'null'?>
                                    </td>
                                    <td>
                                        <?=!is_null($cb_phone)?$cb_phone:'null'?>
                                    </td>
                                    <!-- end -->
                                    <td>
                                        <?=!is_null($hbox['customer_payment_method'])?$hbox['customer_payment_method']:'null'?>
                                    </td>
                                    <td>
                                        <?=!is_null($hbox['box_delivery_address'])?$hbox['box_delivery_address']:'null'?>
                                    </td>
                                    <td>
                                        <?=!is_null($hbox['box_purchase_date'])?$hbox['box_purchase_date']:'null'?>
                                    </td>
                                    <td>
                                        <?=!is_null($hbox['box_validity_date'])?$hbox['box_validity_date']:'null'?>
                                    </td>
                                    <td>
                                        <?=!is_null($hbox['customer_buyer_invoice'])?$hbox['customer_buyer_invoice']:'null'?>
                                    </td>
                                    <td>
                                        <?=!is_null($hbox['box_barcode'])?$hbox['box_barcode']:'null'?>
                                    </td>
                                    <td>
                                        <?=!is_null($box_data->name)?$box_data->name:'null'?>
                                    </td>
                                    <td>
                                        <?=!is_null($hbox['box_voucher'])?$hbox['box_voucher']:'null'?>
                                    </td>
                                    <td>
                                        <?=!is_null($hbox['box_voucher_new'])?$hbox['box_voucher_new']:'null'?>
                                    </td>
                                    <td>
                                        <?=!is_null($box_v_status_name)?$box_v_status_name:'null'?>
                                    </td>
                                    <td>
                                        <?=!is_null($hbox['voucher_activation_date'])?$hbox['voucher_activation_date']:'null'?>
                                    </td>
                                    <!-- customer user -->
                                    <td>
                                        <?=!is_null($cu_name)?$cu_name:'null'?>
                                    </td>
                                    <td>
                                        <?=!is_null($cu_sname)?$cu_sname:'null'?>
                                    </td>
                                    <td>
                                        <?=!is_null($cu_email)?$cu_email:'null'?>
                                    </td>
                                    <td>
                                        <?=!is_null($cu_phone)?$cu_phone:'null'?>
                                    </td>
                                    <!-- end -->
                                    <td>
                                        <?=!is_null($hbox['redeemed_date'])?$hbox['redeemed_date']:'null'?>
                                    </td>
                                    <td>
                                        <?=!is_null($hbox['cancellation_date'])?$hbox['cancellation_date']:'null'?>
                                    </td>
                                    <td>
                                        <?=!is_null($hbox['booking_date'])?$hbox['booking_date']:'null'?>
                                    </td>
                                    <td>
                                        KES <?=!is_null($box_data->price)?$box_data->price:'null'?>
                                    </td>
                                    <td>
                                        <?=!is_null($hbox['partner_pay_due_date'])?$hbox['partner_pay_due_date']:'null'?>
                                    </td>
                                    <td>
                                        <?=!is_null($hbox['partner_pay_effec_date'])?$hbox['partner_pay_effec_date']:'null'?>
                                    </td>
                                    <td>
                                        <?=!is_null($hbox['partner_pay_amount'])?$hbox['partner_pay_amount']:'null'?>
                                    </td>
                                    <td>
                                        <?=!is_null($hbox['partner_internal_id'])?$hbox['partner_internal_id']:'null'?>
                                    </td>
                                    <td>
                                        <?=!is_null($hbox['partner_invoice'])?$hbox['partner_invoice']:'null'?>
                                    </td>
                                    <td class="inner_table_wrap">
                                        <table class="text-white inner_table">
                                            <tr>
                                                <td class="td_a">
                                                    <a href="#" class="light">View Detail</a>
                                                </td>
                                                <!-- <td class="td_b">
                                                    <a href="#" class="light">
                                                        Cancell Voucher & Generate New
                                                    </a>    
                                                </td> -->
                                            </tr>
                                        </table>  
                                    </td>
                                </tr>
                                <?php 
                                endforeach;
                                ?>
                            </tbody>
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
<div class="modal fade" id="generate_box">
    <div class="modal-dialog general_pop_dialogue">
      <div class="modal-content">
        <div class="modal-body text-center">
          <div class="col-md-12 text-center forgot-dialogue-borderz">
            <h4 class="">Add Box Inventory</h4>
            <div>
                <form class="filter_form" method="post">
                    <div class="form-group row">
                        <label for="BoxType" class="col-form-label">Quantity</label>
                         <input type="number" min="1" placeholder="Enter Quantity here" name="quantity" class="form-control rounded_form_control" id="select_box_type"/>
                    </div>
                    <div class="form-group row">
                        <label for="BoxType" class="col-form-label">Box Name</label><br>
                        <select class="form-control" name="boxname" id="">
                            <option value="nn">Select box name</option>
                            <?php 
                                $boxes = json_decode($box->get($token), true)['data'];
                                foreach( $boxes as $ppp ){
                                        print '<option value="'.$ppp['internal_id'].'">'.$ppp['name'].'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <hr>
                    <div class=" row">
                        <div class="col-md-12 text-right text-white">
                            <button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
                            <button type="submit" name="generate" class="btn btn_view_report">Generate</button>
                        </div>
                    </div>
                </form>
            </div>
          </div>
      </div>
      </div>
    </div>
  </div>
  <!-- end popup -->
 </body>
</html>
