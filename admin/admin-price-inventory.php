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
                        <h3>PRICE RANGE INVENTORY</h3>
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

                        <table class="table table_data1 table-bordered">
                            <thead>
                                <tr>
                                    <th>CODE</th>
                                    <th>RANGE</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(!empty($prices)){
                                    foreach( $prices as $tpc ):
                                ?>
                                <tr>
                                    <td><?=$tpc['internal_id']?></td>
                                    <td><?=$tpc['name']?></td>
                                </tr>
                                <?php 
                                     endforeach;
                                    }else{
                                        print '<tr><td colspan="5">No price ranges found</td></tr>';
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





    </body>

</html>
