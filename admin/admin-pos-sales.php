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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/css/tempusdominus-bootstrap-4.min.css" integrity="sha512-3JRrEUwaCkFUBLK1N8HehwQgu8e23jTH4np5NHOmQOobuC4ROQxFwFgBLTnhcnQRMs84muMh0PnnwXlPq5MGjg==" crossorigin="anonymous" />
        <style>
            .admin-pos{
                color: #c20a2b!important;
                text-decoration: none!important;
                border-bottom: solid 2px #c20a2b!important;
            }
            .table_absimg {
                position: relative!important;
            }
            .animatable{
                width: 26px!important;
                cursor: pointer;
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
                        <h3>POINT OF SALE</h3>
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
                        <br> 
                        <?php 
                            if(isset($_POST['modify-box']))
                            {
                                $ord = new Order($token);
                                $modif_response = $ord->pos_edit_sale($_POST, $_POST['id']);
                                if(json_decode($modif_response)->status == '0')
                                {
                                    print '<div class="alert alert-success">'.json_decode($modif_response)->message.'</div>';
                                }
                                else
                                {
                                    print '<div class="alert alert-danger">'.json_decode($modif_response)->message.'</div>';
                                }

                            }
                            if(isset($_POST['sendto-stock']))
                            {
                                $ord = new Order($token);
                                $stock_response = $ord->pos_unsell_sale($_POST['id']);
                                // $util->Show($stock_response);
                                if(json_decode($stock_response)->status == '0')
                                {
                                    print '<div class="alert alert-success">'.json_decode($stock_response)->message.'</div>';
                                    // $util->timed_redirect('admin-pos-sales.php');
                                }
                                else
                                {
                                    print '<div class="alert alert-danger">'.json_decode($stock_response)->message.'</div>';
                                }
                            }
                        /** Fetch data */
                            $order = new Order($token);
                            $all_pos_sales = [];
                            $inv = $order->pos_find_sales();
                            if(json_decode($inv)->status == '0')
                            {
                                $all_pos_sales = json_decode($inv, true)['data'];
                            }
                            // $util->Show($all_pos_sales);
                        ?>
                        <table class="table display reportable">
                            <thead>
                                <tr>
                                    <!-- <th>Order Number</th> -->
                                    <th>Box</th>
                                    <th>Bar Code</th>
                                    <th>Voucher</th>
                                    <th>Buyer Name</th>
                                    <th>Buyer Surname</th>
                                    <th>Buyer Email</th>
                                    <th>Buyer Phone</th>
                                    <th>Payment Method</th>
                                    <th>Puchase Date</th>
                                    <th>Valid Until</th>
                                    <th>Sale Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                foreach( $all_pos_sales as $pos ):
                                    $c_buyer = json_decode($user->get_details_byidf($pos['customer_buyer_id']));
                                    $customer_buyer = $c_buyer->data;
                                    $cb = json_decode($user->get_one($customer_buyer->userid, $token))->data;
                                    $box_data = json_decode($box->get_byidf($token, $pos['box_internal_id']))->data;
                                    $box_name = '';
                            ?>
                                <tr>
                                    <!-- <td><=$pos['order_number']?></td> -->
                                    <td><?=$box_data->name?></td>
                                    <td><?=$pos['box_barcode']?></td>
                                    <td><?=$pos['box_voucher']?></td>
                                    <td><?=$customer_buyer->fname?></td>
                                    <td><?=$customer_buyer->sname?></td>
                                    <td><?=$cb->email?></td>
                                    <td><?=$customer_buyer->phone?></td>
                                    <td><?=$pos['customer_payment_method']?></td>
                                    <td><?=$util->globalDate($pos['box_purchase_date'])?></td>
                                    <td><?=$util->globalDate($pos['box_validity_date'])?></td>
                                    <td>POS</td>
                                    <td><a onclick="loadInvForm('<?=$pos['id']?>')"><img class="animatable" src="img/icn-edit-teal.svg" class="kkk"></a></td>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/js/tempusdominus-bootstrap-4.min.js" integrity="sha512-k6/Bkb8Fxf/c1Tkyl39yJwcOZ1P4cRrJu77p83zJjN2Z55prbFHxPs9vN7q3l3+tSMGPDdoH51AEU8Vgo1cgAA==" crossorigin="anonymous"></script>
<script>
 loadInvForm = function (id)
 {
     $('#inv_id').val(id);
     $('#modify_date').modal('show');
     return;
 }

//  $(document).ready(function() {
//     $('.c-date').datepicker({
//         format: 'DD/MM/YYYY'
//     });
// });
</script>
<script type="text/javascript">
    $(function () {
        $('#datetimepicker4').datetimepicker({
            format: 'L'
        });
    });
</script>
<!-- popup -->
<div class="modal fade" id="modify_date">
    <div class="modal-dialog general_pop_dialogue">
      <div class="modal-content">
        <div class="modal-body text-center">
          <div class="col-md-12 text-center forgot-dialogue-borderz">
            <h4 class="">Modify Box Voucher</h4>
            <div>
                <form class="filter_form" method="post">
                    <div class="form-group row">
                        <label for="BoxType" class="col-form-label">Pick date</label>
                        <input type="hidden" name="id" id="inv_id"/>
                        <input type="text" class="form-control rounded_form_control c-date" name="box_purchase_date" id="box_purchase_date"/>
                        
                        <div class="input-group date" id="datetimepicker4" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker4"/>
                            <div class="input-group-append" data-target="#datetimepicker4" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class=" row">
                        <div class="col-md-12 text-right text-white">
                            <button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
                            <button type="submit" name="modify-box" class="btn btn_view_report">Modify Date</button>
                            <button type="submit" name="sendto-stock" class="btn btn_danger_report">Return to Stock</button>
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
