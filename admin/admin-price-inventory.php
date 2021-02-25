<?php 
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
require_once('../lib/Price.php');
$util = new Util();
$user = new User();
$price = new Price();
$util->ShowErrors();
$user->is_loggedin();
$token = json_decode($_SESSION['usr'])->access_token;
$prices = $price->get($token);
$prices = json_decode($prices, true)['data'];
// $util->Show($prices);
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

        <title>Happy Box:: Admin Portal</title>
        <!-- Bootstrap core CSS -->
        <?php include 'admin-partials/css.php'; ?>
        <style>
            .admin-prices{
                color: #c20a2b!important;
                text-decoration: none!important;
                border-bottom: solid 2px #c20a2b!important;
            }
            .table_absimg {
                position: relative!important;
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
                        <h3>PRICE RANGES</h3>
                    </div>
                    <div class="col-6 text-right">
                        <a class="btn generate_rpt" href="admin-price-new.php">CREATE PRICE RANGE</a>
                    </div>

                </div>
            </div>
        </section>
        <section class=" status_bar ">
            <div class="container justify-content-around">
                <div class="row ">
                   
                </div>
            </div>
        </section>
        <section class=" data+table_section ">
            <div class="container">
                <div class="row ">
                    <div class="col-md-12 ">
                        <div class="table-responsive">

                        <table class="table table-bordered reportable">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Range</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(!empty($prices)){
                                    foreach( $prices as $tpc ):
                                        $edit_string = "'" . $tpc['id'] . "','" . $tpc['name'] . "'";
                                ?>
                                <tr>
                                    <td><?=$tpc['internal_id']?></td>
                                    <td><?=$tpc['name']?></td>
                                    <td><a onclick="loadInvForm('<?=$edit_string?>')"><img src="img/icn-edit-teal.svg" class="kkk"></a></td>
                                </tr>
                                <?php 
                                     endforeach;
                                    }else{
                                        print '<tr><td colspan="3">No price ranges found</td></tr>';
                                    }
                                ?>
                            </tbody>
                        </table>
                            </div>
                    </div>


                </div>
            </div>
        </section>





 <?php include 'admin-partials/footer.php'; ?>


        <!-- Bootstrap core JavaScript -->

        <?php include 'admin-partials/js.php'; ?>
        <script>
        loadInvForm = function (id, name)
        {
            $('#range_id').val(id);
            $('#name').val(name);
            $('#modify_range').modal('show');
            return;
        }
        </script>
        <!-- popup -->
        <div class="modal fade" id="modify_range">
            <div class="modal-dialog general_pop_dialogue">
            <div class="modal-content">
                <div class="modal-body text-center">
                <div class="col-md-12 text-center forgot-dialogue-borderz">
                    <h4 class="">Modify Box Purchase Date</h4>
                    <div>
                        <form class="filter_form" method="post">
                            <div class="form-group row">
                                <label for="BoxType" class="col-form-label">Pick date</label>
                                <input type="hidden" name="id" id="range_id"/>
                                <input type="text" class="form-control rounded_form_control" name="name" id="name"/>
                            </div>
                            <hr>
                            <div class=" row">
                                <div class="col-md-12 text-right text-white">
                                    <button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
                                    <button type="submit" name="modify-range" class="btn btn_view_report">Save Changes</button>
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
