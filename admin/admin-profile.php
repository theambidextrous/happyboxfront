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
                    <div class="col-md-6 section_title">
                       <!-- <h3><strong>REPORTS</strong>  <select class=" select_reports" id="select_reports">
                                <option></option>
                                <option>Sales by Box Type</option>
                                <option>Sales by Customer</option>
                                <option>Sales by Partner</option>
                                <option>List of Customers</option>
                                <option>List of Partners</option>
                                <option>List of Voucher Codes</option>
                                <option>List of Box Codes</option>
                            </select> </h3>-->
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
                        <h4 class="filter_title text-center"> Profile info</h4>                  
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-7 ">
                        <?php 
                            if( isset($_POST['update'])){
                                try{
                                    $user_id = $_POST['id'];
                                    $data = [
                                        'fname' => $_POST['fname'],
                                        'sname' => $_POST['sname'],
                                        'location' => $_POST['location'],
                                        'phone' => $_POST['phone']
                                    ];
                                    if($_POST['uid'] > 0){
                                        $resp = $user->edit_details_admin($data, $token, $user_id);
                                    }else{
                                        $resp = $user->add_details_admin($data, $token, $user_id);
                                    }
                                    if(json_decode($resp)->status == '0'){
                                        $_SESSION['usr_info'] = $user->get_details($user_id);
                                        print $util->success_flash('Updated successfully');
                                    }else{
                                        print $util->error_flash(json_decode($resp)->message);
                                    }
                                }catch(Exception $e){
                                    print $util->error_flash($e->getMessage());
                                }
                            }
                        ?>
                        <form class="filter_form" method="post">
                            <div class="form-group row">
                                <label for="BoxType" class="col-md-4 col-form-label">Username</label>
                                <div class="col-md-8">
                                    <input type="hidden" name="id" value="<?=json_decode($_SESSION['usr'])->user->id?>"/>
                                    <input type="hidden" name="uid" value="<?=$profile_form->data->userid?>"/>
                                    <input type="text" readonly class="form-control rounded_form_control" id="select_box_type" value="<?=json_decode($_SESSION['usr'])->user->username?>"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="BoxType" class="col-md-4 col-form-label">Email address</label>
                                <div class="col-md-8">
                                    <input type="text" readonly class="form-control rounded_form_control" id="select_box_type" value="<?=json_decode($_SESSION['usr'])->user->email?>"/>
                                </div>
                            </div>
                            <!-- <div class="form-group row">
                                <label for="toCategory" class="col-md-4 col-form-label">To Category</label>
                                <div class="col-md-8">
                                    <select class=" form-control" id="select_box_type">
                                        <option value="">Select a category</option>
                                        <option>Category 1</option>
                                        <option>Category 2</option>
                                        <option>Category 3</option>
                                    </select>
                                </div>
                            </div> -->
                            <hr>
                            <h4 class="filter_title text-center"> User Details </h4>   
                            <div class="form-group row">
                                <label for="DateRange" class="col-md-3 col-form-label">Full Name</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control rounded_form_control" id="select_box_type" placeholder="First name" name="fname" value="<?=$profile_form->data->fname?>"/>
                                </div>
                                <!-- <div class="col-md-3">
                                    <input type="text" class="form-control rounded_form_control" id="select_box_type" placeholder="Middle name" name="mname" value="<=$profile_form->data->mname?>" />
                                </div> -->
                                <div class="col-md-3">
                                    <input type="text" class="form-control rounded_form_control" id="select_box_type" placeholder="Sir name" name="sname" value="<?=$profile_form->data->sname?>" />
                                </div>
                            </div>
                            <hr>
                            <h4 class="filter_title text-center"> Contact Details </h4> 
                            <div class="form-group row">
                                <label for="DateRange" class="col-md-4 col-form-label">Contact Information</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control rounded_form_control" id="select_box_type" placeholder="Phone number" name="phone" value="<?=$profile_form->data->phone?>"/>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control rounded_form_control" id="select_box_type" placeholder="Physical Address" name="location" value="<?=$profile_form->data->location?>"/>
                                </div>
                            </div>
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
