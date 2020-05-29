<?php 
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
$util = new Util();
$user = new User();
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
                        <h3>EDIT PARTNER</h3>
                    </div>
                    <div class="col-6 text-right">
                        <a class="btn generate_rpt" href="admin-partner-listing.php">Back</a>

                    </div>

                </div>
            </div>
        </section>
        <section class=" data+table_section ">
            <div class="container">
            <div class="row ">
                    <div class="col-md-12 ">
                        <br><br>
                        <h4 class="filter_title text-center">Edit Partner </h4>                  
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-7 ">
                        <?php 
                            $selected_partner = $user->get_one($_REQUEST['pt'], $token);
                            $selected_partner_data = $user->get_details($_REQUEST['pt']);
                            $selected_partner = json_decode($selected_partner, true)['data'];
                            $selected_partner_data = json_decode($selected_partner_data, true)['data'];
                            // $util->Show($selected_partner_data);
                            if(!isset($_REQUEST['pt']) || $_REQUEST['pt'] == ''){
                                print $util->error_flash('Wrong request');
                                exit;
                            }
                            if(!isset($_SESSION['frm'])){
                                $_SESSION['frm'] = $selected_partner;
                            }
                            if(!isset($_SESSION['frm_b'])){
                                $_SESSION['frm_b'] = $selected_partner_data;
                            }
                            if( isset($_POST['update'])){
                                try{
                                    $_SESSION['frm'] = $_POST;
                                    $_SESSION['frm_b'] = $_POST;
                                    $u = new User();
                                    /** update profile */
                                    $created_user_id = $_REQUEST['pt'];
                                    $body = [
                                        'fname' => $_POST['fname'],
                                        'mname' => $_POST['mname'],
                                        'sname' => $_POST['sname'],
                                        'short_description' => $_POST['short_description'],
                                        'location' => $_POST['location'],
                                        'phone' => $_POST['phone'],
                                        'business_name' => $_POST['business_name'],
                                        'business_category' => $_POST['business_category'],
                                        'business_reg_no' => $_POST['business_reg_no']
                                    ];
                                    $prof_resp = $u->edit_details_partner($body, $token, $created_user_id);
                                    // print $prof_resp;
                                    if(json_decode($prof_resp)->status == 0 && json_decode($prof_resp)->userid > 0){
                                        unset($_SESSION['frm']);
                                        unset($_SESSION['frm_b']);
                                        print $util->success_flash('Partner information updated! Note that email address is not updated and password is not reset too');
                                    }else{
                                        print $util->error_flash(json_decode($prof_resp)->message);
                                    }
                                }catch(Exception $e){
                                    print $util->error_flash($e->getMessage());
                                }
                            }
                        ?>
                        <form class="filter_form" method="post">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="BoxType" class="col-form-label">Partner Name</label>
                                    <input type="text" placeholder="partner name" name="business_name" class="form-control rounded_form_control" id="select_box_type" value="<?=$_SESSION['frm_b']['business_name']?>"/>
                                </div>
                                <div class="col-md-6">
                                    <label for="BoxType" class="col-form-label">Partner Inc. Number</label>
                                    <input type="text" placeholder="inc/reg number" name="business_reg_no" class="form-control rounded_form_control" id="select_box_type" value="<?=$_SESSION['frm_b']['business_reg_no']?>"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="BoxType" class="col-form-label">Partner location</label>
                                    <input type="text" placeholder="location" name="location" class="form-control rounded_form_control" id="select_box_type" value="<?=$_SESSION['frm_b']['location']?>"/>
                                </div>
                                <div class="col-md-6">
                                    <label for="BoxType" class="col-form-label">Partner Business category</label>
                                    <input type="text" placeholder="business category" name="business_category" class="form-control rounded_form_control" id="select_box_type" value="<?=$_SESSION['frm_b']['business_category']?>"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="BoxType" class="col-form-label">Partner business description</label>
                                    <textarea name="short_description" placeholder="short description" class="form-control rounded_form_control" id="select_box_type"><?=$_SESSION['frm_b']['short_description']?></textarea>
                                </div>
                            </div>
                            <hr>
                            <h4 class="filter_title text-center"> contact Details </h4>   
                            <div class="form-group row">
                                <label for="DateRange" class="col-md-3 col-form-label">Full Name</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control rounded_form_control" id="select_box_type" placeholder="First name" name="fname" value="<?=$_SESSION['frm_b']['fname']?>"/>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control rounded_form_control" id="select_box_type" placeholder="Middle name" name="mname" value="<?=$_SESSION['frm_b']['mname']?>" />
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control rounded_form_control" id="select_box_type" placeholder="Surname" name="sname" value="<?=$_SESSION['frm_b']['sname']?>" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="DateRange" class="col-md-4 col-form-label">Phone & Email</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control rounded_form_control" id="select_box_type" placeholder="Phone Number" name="phone" value="<?=$_SESSION['frm_b']['phone']?>"/>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" readonly class="form-control rounded_form_control" id="select_box_type" placeholder="Email Address" name="email" value="<?=$_SESSION['frm']['email']?>" />
                                </div>
                            </div>
                            
                            <div class=" row">
                                <div class="col-md-12 text-right text-white">
                                    <button type="submit" name="update" class="btn btn_view_report">save changes</button>
                                </div>
                            </div>
                        </form>
                    </div> 
                </div>
            </div>
        </section><br><br>




 <?php include 'admin-partials/footer.php'; ?>


        <!-- Bootstrap core JavaScript -->

        <?php include 'admin-partials/js.php'; ?>





    </body>

</html>
