<?php 
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
require_once('../lib/Experience.php');
require_once('../lib/Topic.php');
require_once('../lib/Media.php');
require_once('../lib/Picture.php');
require_once('../lib/Box.php');
$util = new Util();
$user = new User();
$topic = new Topic();
$box = new Box();
$media = new Media();
$picture = new Picture();
$experience = new Experience();
$util->ShowErrors(1);
$user->is_loggedin();
$token = json_decode($_SESSION['usr'])->access_token;
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
                        <h3>BOX DEACTIVATION</h3>
                    </div>
                    <div class="col-6 text-right">
                        <a class="btn generate_rpt" href="admin-box-inventory-activated.php">Back</a>
                    </div>
                </div>
            </div>
        </section>
        <section class=" data+table_section ">
            <div class="container">
            <div class="row ">
                    <div class="col-md-12 ">
                        <br><br>
                        <h4 class="filter_title text-center">Deactivate Box 
                        <br>
                        </h4>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-7 ">
                        <?php 

                            if(!isset($_REQUEST['box'])){
                                print $util->error_flash('wrong request');
                                exit;
                            }
                            if( isset($_POST['deactivate'])){
                                try{
                                    $pc_resp = $box->deactivate($token, $_REQUEST['box']);
                                    if(json_decode($pc_resp)->status == '0'){
                                        print $util->success_flash('Box Deactivated!');
                                    }else{
                                        print $util->error_flash(json_decode($pc_resp)->message);
                                    }
                                }catch(Exception $e){
                                    print $util->error_flash($e->getMessage());
                                }
                            }
                        ?>
                        <form class="filter_form" method="post" enctype="multipart/form-data">
                            <p style="font-size:14px;" class="alert alert-warning">Note that deactivating a box will render it invisible to customers online. Perhaps you should reconsider doing this.</p>
                            <hr>
                            <div class=" row">
                                <div class="col-md-12 text-center text-white">
                                    <button type="submit" name="deactivate" class="btn btn_view_report">Deactivate Box</button>
                                </div>
                            </div>
                        </form>
                    </div> 
                </div>
            </div>
        </section>
        <br>
        <br>
 <?php include 'admin-partials/footer.php'; ?>


        <!-- Bootstrap core JavaScript -->

        <?php include 'admin-partials/js.php'; ?>





    </body>

</html>
