<?php 
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
$util = new Util();
$user = new User();
$util->ShowErrors();
$user->is_loggedin();
// $util->Show($_SESSION['usr_info']);
$profile_form = json_decode($_SESSION['usr_info']);
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Happy Box:: Admin Profile</title>
        <!-- Bootstrap core CSS -->
        <?php include 'admin-partials/css.php'; ?>

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
        <section class=" top_blue_bar ">
            <div class="container">
                <div class="row rpt_drop">
                    <div class="col-md-6 section_title">
                       <ul class="nav nav-pills list-inline">
                            <li class="nav-item">
                                <a class="nav-link dropdown-toggle" href="<?=$util->AdminHome()?>/admin-profile.php">
                                    <b>Profile info</b>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link dropdown-toggle" href="<?=$util->AdminHome()?>/admin-profile-pic.php">
                                    <b>Profile photo</b>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <section class=" filter_bar ">
        <div class="container ">
                <div class="row ">
                    <div class="col-md-12 ">
                        <h4 class="filter_title text-center"> Profile photo</h4>                  
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-7 ">
                        <?php 
                            if( isset($_POST['update'])){
                                try{
                                    $user_id = $_POST['uuid'];
                                    $resp = $user->edit_profile_pic($user_id, 'img');
                                    // print $resp;
                                    if(json_decode($resp)->status == '0'){
                                        $_SESSION['usr_info'] = $user->get_details($user_id);
                                        print $util->success_flash(json_decode($resp)->message);
                                    }else{
                                        print $util->error_flash(json_decode($resp)->message);
                                    }
                                }catch(Exception $e){
                                    print $util->error_flash($e->getMessage());
                                }
                            }
                        ?>
                        <form class="filter_form" method="post" enctype="multipart/form-data">
                            <div class="form-group row">
                                <label for="BoxType" class="col-md-4 col-form-label">Current profile photo</label>
                                <div class="col-md-8">
                                    <input type="hidden" name="uuid" value="<?=json_decode($_SESSION['usr'])->user->id?>"/>
                                    <span><img src="<?=$profile_pic_?>" class="dropdown_user_img rounded-circle"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="BoxType" class="col-md-4 col-form-label">Upload new profile photo</label>
                                <div class="col-md-8">
                                    <input type="file" name="img" class="form-control rounded_form_control"/>
                                </div>
                            </div>
                            <hr>
                            <div class=" row">

                                <div class="col-md-12 text-right text-white">
                                    <button type="submit" name="update" class="btn btn_view_report">Update</button>
                                </div>

                            </div>



                        </form>
                    </div> 
                </div> 
            </div>
        </section>

        <?php include 'admin-partials/footer.php'; ?>


        <!-- Bootstrap core JavaScript -->

        <?php include 'admin-partials/js.php'; ?>

    </body>

</html>
