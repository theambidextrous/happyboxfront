<?php 
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
require_once('../lib/Media.php');
$util = new Util();
$user = new User();
$media = new Media();
$util->ShowErrors();
$user->is_loggedin();
$token = json_decode($_SESSION['usr'])->access_token;
$medias = $media->get($token);
$medias = json_decode($medias, true)['data'];
// $util->Show($topics);
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
                        <h3>MEDIA TYPES INVENTORY</h3>
                    </div>
                    <div class="col-6 text-right">
                        <a class="btn generate_rpt" href="admin-mediatype-new.php">CREATE MEDIA TYPE</a>
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
                                    <th>MEDIA TYPE CODE</th>
                                    <th>MEDIA TYPE NAME</th>
                                    <th>ADMINISTRATOR FUNCTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(!empty($medias)){
                                    foreach( $medias as $tpc ):
                                ?>
                                <tr>
                                    <td><?=$tpc['id']?></td>
                                    <td><?=$tpc['name']?></td>
                                    <td class="inner_table_wrap">
                                        <table class="text-white inner_table">
                                            <tr>
                                                <td class="td_a">
                                                    <a href="admin-mediatype-edit.php?mt=<?=$tpc['id']?>" class="light">View media type</a>
                                                </td>
                                                <td class="td_b">
                                                    <a href="admin-mediatype-edit.php?mt=<?=$tpc['id']?>" class="light">Edit media type</a> 
                                                </td>
                                            </tr>
                                        </table>  
                                    </td>
                                </tr>
                                <?php 
                                     endforeach;
                                    }else{
                                        print '<tr><td colspan="3">No media types found</td></tr>';
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
