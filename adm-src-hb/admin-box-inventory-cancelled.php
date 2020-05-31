<?php 
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
require_once('../lib/Box.php');
$util = new Util();
$user = new User();
$util->ShowErrors();
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
                        <a class="btn generate_rpt" href="#">COMPOSE NEW BOX</a>
                    </div>
                </div>
            </div>
        </section>
        <section class=" status_bar ">
            <div class="container justify-content-around">
                <br>
                <div class="row ">
                    <div class="col-md-2">
                        <a href="admin-box-inventory.php" class="btn generate_rpt btn-block">INACTIVE</a>
                    </div>
                    <div class="col-md-2">
                        <a href="admin-box-inventory-activated.php" class="btn generate_rpt btn-block">ACTIVATED</a>
                    </div>
                    <div class="col-md-2">
                        <a href="admin-box-inventory-purchased.php" class="btn generate_rpt btn-block">PURCHASED</a>
                    </div>
                    <div class="col-md-2">
                        <a href="admin-box-inventory-cancelled.php" style="color:#c20a2b;" class="btn generate_rpt btn-block">CANCELLED</a>
                    </div>
                    <div class="col-md-2">
                        <a href="admin-box-inventory-expired.php" class="btn generate_rpt btn-block">EXPIRED</a>
                    </div>
                    <div class="col-md-2">
                        <a href="admin-box-inventory-paid-partner.php" class="btn generate_rpt btn-block">PARTNER PAID</a>
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
                        <small class="text-muted">All boxes that have been purchased by customer buyers but cancelled by partner</small>
                        <table class="table table_data1 table-bordered">
                            <thead>
                                <tr>
                                    <th>BOX CODE</th>
                                    <th>BOX <br>NAME</th>
                                    <th>BOX PRICE</th>
                                    <th>VOUCHER CODE</th>
                                    <th>PURCHASED BY</th>
                                    <th>DATE CANCELLED</th>
                                    <th>ADMINISTRATOR FUNCTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $all_happyboxes = json_decode($box->get($token), true)['data'];
                                foreach($all_happyboxes as $hbox ):
                                    if(in_array($hbox['is_active'], [5])){
                                ?>
                                <tr>
                                    <td><?=$hbox['internal_id']?></td>
                                    <td><?=$hbox['name']?></td>
                                    <td>KES <?=$hbox['price']?></td>
                                    <td><?=$hbox['voucher']?></td>
                                    <td><?=$hbox['description']?></td>
                                    <td class="inner_table_wrap">
                                        <table class="text-white inner_table">
                                            <tr>
                                                <!-- <td class="td_a">
                                                    <a href="admin-box-view.php?box=<=$hbox['internal_id']?>" class="light">View Detail</a>
                                                </td>
                                                <td class="td_b">
                                                    <a href="admin-box-gallery.php?box=?=$hbox['internal_id']?>" class="light">Add Gallery</a>    
                                                </td>
                                                <td class="td_a">
                                                    <a href="admin-box-deactivate.php?box=<=$hbox['id']?>" class="light">Deactivate</a>
                                                </td> -->
                                            </tr>
                                        </table>  
                                    </td>
                                </tr>
                                <?php 
                                    }
                                endforeach;
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





    </body>

</html>
