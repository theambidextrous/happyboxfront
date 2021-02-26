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
$_SESSION['pos-form'] = [
    'fname' => null,
    'lname' => null,
    'email' => null,
    'phone' => null,
    'quantity' => null,
    'boxname' => null,
    'box_purchase_date' => null,
];
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
                        <a href="admin-pos.php" class="btn generate_rpt btn-block is_active">Make Sale</a>
                    </div>
                    <div class="col-md-2">
                        <a href="admin-pos-sales.php" class="btn generate_rpt btn-block ">Sales Reports</a>
                    </div>
                </div>
            </div>
        </section>
        <section class=" data+table_section ">
            <div class="container">
                <div class="row ">
                    <div class="col-md-12 ">   
                        <br> 
                        <?php 
                            if(isset($_POST['generate']))
                            {
                                $_SESSION['pos-form'] = $_POST;
                                $order = new Order($token);
                                $order_response = $order->pos_make_sale($_POST);
                                $util->Show($order_response);
                                if(json_decode($order_response)->status == '0')
                                {
                                    print '<div class="alert alert-success">'.json_decode($order_response)->message.'</div>';
                                    $_SESSION['pos-form'] = [
                                        'fname' => null,
                                        'lname' => null,
                                        'email' => null,
                                        'phone' => null,
                                        'quantity' => null,
                                        'boxname' => null,
                                        'box_purchase_date' => null,
                                    ];
                                }
                                else
                                {
                                    print '<div class="alert alert-danger">'.json_decode($order_response)->message.'</div>';
                                }

                            }
                        ?>
                        <form class="filter_form" action="" method="post">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nm" class="col-form-label">Buyer Name</label>
                                        <input required value="<?=$_SESSION['pos-form']['fname']?>" type="text" name="fname" class="form-control rounded_form_control" id="fname"/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nm" class="col-form-label">Buyer Surname</label>
                                        <input required value="<?=$_SESSION['pos-form']['lname']?>" type="text" name="lname" class="form-control rounded_form_control" id="lname"/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nm" class="col-form-label">Buyer Email</label>
                                        <input required value="<?=$_SESSION['pos-form']['email']?>" type="email" name="email" class="form-control rounded_form_control" id="email"/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nm" class="col-form-label">Buyer Phone</label>
                                        <input required value="<?=$_SESSION['pos-form']['phone']?>" type="text" name="phone" class="form-control rounded_form_control" id="phone"/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nm" class="col-form-label">Voucher Quantity</label>
                                        <input required value="<?=$_SESSION['pos-form']['quantity']?>" type="number" min="1" name="quantity" class="form-control rounded_form_control" id="quantity"/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="BoxType" class="col-form-label">Happy Box</label><br>
                                        <select required class="form-control" name="boxname" id="">
                                            <option value="nn">Select box</option>
                                            <?php 
                                                $boxes = json_decode($box->get($token), true)['data'];
                                                foreach( $boxes as $ppp ){
                                                    print '<option value="'.$ppp['internal_id'].'">'.$ppp['name'].'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="date" class="col-form-label">Purchase date</label><br>
                                        <input required value="<?=$_SESSION['pos-form']['box_purchase_date']?>" type="date" name="box_purchase_date" class="form-control rounded_form_control" id="box_purchase_date"/>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12 text-right text-white">
                                    <button type="submit" name="generate" class="btn btn_view_report">
                                        Submit Order
                                    </button>
                                </div>
                            </div>
                        </form>

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
