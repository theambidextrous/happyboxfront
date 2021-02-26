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
                    <div class="col-6 section_title">
                        <h3>ADMIN PROFILE</h3>
                    </div>
                </div>
            </div>
        </section>
        <section class=" status_bar ">
            <br>
            <div class="container justify-content-around">
                <div class="row ">
                    <div class="col-md-2">
                        <a href="<?=$util->AdminHome()?>/admin-profile.php" class="btn generate_rpt btn-block">Edit Profile</a>
                    </div>
                    <!-- <div class="col-md-3">
                        <a href="<=$util->AdminHome()?>/admin-profile-pic.php" class="btn generate_rpt btn-block">Change Profile Photo</a>
                    </div> -->
                    <div class="col-md-2">
                        <a href="<?=$util->AdminHome()?>/admin-change-pwd.php" class="btn generate_rpt btn-block is_active">Change Password</a>
                    </div>
                    <div class="col-md-2">
                        <a href="<?=$util->AdminHome()?>/admin-new-admin.php" class="btn generate_rpt btn-block">Create Admin</a>
                    </div>
                    <div class="col-md-2">
                        <a href="<?=$util->AdminHome()?>/admin-list-admins.php" class="btn generate_rpt btn-block">Admins</a>
                    </div>
                </div>
            </div>
        </section>
        <section class=" filter_bar ">
        <div class="container ">
                <div class="row ">
                    <div class="col-md-12 ">
                        <h4 class="filter_title text-center">Change Password</h4>                  
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-7 ">
                        <?php 
                            if( isset($_POST['update'])){
                                try{
                                    $util->ValidatePasswordStrength($_POST['password']);
                                    $pwd_response = $user->adm_password_change($_POST);
                                    if(json_decode($pwd_response)->status == '0')
                                    {
                                        print '<div class="alert alert-success">'.json_decode($pwd_response)->message.'</div>';
                                    }
                                    else
                                    {
                                        print '<div class="alert alert-danger">'.json_decode($pwd_response)->message.'</div>';
                                    }
                                }catch(Exception $e)
                                {
                                    print '<div class="alert alert-danger">'.$e->getMessage().'</div>';
                                }
                            }
                        ?>
                        <form class="filter_form" method="post">
                            <div class="form-group row">
                                <label for="BoxType" class="col-md-4 col-form-label">New Password</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control rounded_form_control" id="password" name="password" required/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="BoxType" class="col-md-4 col-form-label">Re-enter Password</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control rounded_form_control" id="c_password" name="c_password" required/>
                                </div>
                            </div>
                            <hr>
                            <div class=" row">
                                <div class="col-md-12 text-right text-white">
                                    <button type="submit" name="update" class="btn btn_view_report">Update Password</button>
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
