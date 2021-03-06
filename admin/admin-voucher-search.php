<?php 
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
require_once('../lib/Report.php');
require_once('../lib/Inventory.php');
require_once('../lib/Box.php');
$util = new Util();
$user = new User();
$box = new Box();
$report = new Report();
$inventory = new Inventory();
$util->ShowErrors(1);
$user->is_loggedin();
$token = json_decode($_SESSION['usr'])->access_token;
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
        <title>Happy Box:: Admin Voucher Search Result</title>
        <!-- Bootstrap core CSS -->
        <?php include 'admin-partials/css.php'; ?>
        <style>
            .admin-v-search{
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
                <div class="col-md-12 ">
                <?php include 'admin-partials/mid-nav.php'; ?>
                </div>

            </div>
        </section>
        <!--end discover our selection-->
        <section class="voucher_search text-center ">
            <div class="container">
                <div class="row justify-content-center">
                    <?php
                        $res_table = null;
                        if(isset($_POST['search']) && !empty($_POST['voucher_search'])){
                            $voucher_code = trim($_POST['voucher_search']);
                            $res = $inventory->get_by_voucher($token, $voucher_code);
                            $res = json_decode($res, true)['data'];
                            // $util->Show($res);
                            if(isset($res['box_internal_id'])){
                                $idf = $res['partner_internal_id'];
                                $box_idf = $res['box_internal_id'];
                                $ptn_data = json_decode($user->get_details_byidf($idf))->data;
                                $box_data = json_decode($box->get_byidf($token, $box_idf))->data;
                                $data = [
                                    $res['box_voucher'],
                                    $res['box_voucher_status'],
                                    $ptn_data->business_name,
                                    $box_data->name
                                ];
                            }else{
                                $data = [
                                    'Invalid',
                                    'Invalid',
                                    'Invalid',
                                    'Invalid'
                                ];
                            }
                            $res_table = $util->v_search_table($data);
                        }
                    ?>
                    <div class="col-md-6 section_title">
                        <h4 class="voucher_title">VOUCHER QUICK SEARCH </h4>
                        <p class="p_search">Looking for a specific voucher code? Enter the number to check it’s validity.</p>
                        <form class="voucher_search_form" method="post">
                            <div class="form-group row ">
                            <div class="col-md-9 col_no_r">
                                <span class="search_glass"><!--<i class="fas fa-search"></i>--><img src="img/icn-search.svg" class=""></span>
                                <input type="text" name="voucher_search" class="form-control voucher_search_input" placeholder="Enter voucher code here">
                            </div>
                            <div class="col-md-3">
                                <button type="submit" name="search" class="btn btn_search_v btn-block">SEARCH</button> 
                            </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <?=!is_null($res_table)?$res_table:''?>
                </div>
            </div>
        </section>
 <?php include 'admin-partials/footer.php'; ?>      
    <?php include 'admin-partials/js.php'; ?>
    </body>

</html>
