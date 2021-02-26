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
$_SESSION['user-form'] = [
    'fname' => null,
    'sname' => null,
    'email' => null,
    'phone' => null,
    'password' => null,
];
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
                        <a href="<?=$util->AdminHome()?>/admin-change-pwd.php" class="btn generate_rpt btn-block">Change Password</a>
                    </div>
                    <div class="col-md-2">
                        <a href="<?=$util->AdminHome()?>/admin-new-admin.php" class="btn generate_rpt btn-block">Create Admin</a>
                    </div>
                    <div class="col-md-2">
                        <a href="<?=$util->AdminHome()?>/admin-list-admins.php" class="btn generate_rpt btn-block is_active">Admins</a>
                    </div>
                </div>
            </div>
        </section>
        <section class=" filter_bar ">
        <div class="container ">
                <div class="row justify-content-center">
                <div class="table-responsive">
                        <br>
                        <h3>Admin Users</h3>
                        <br> 
                        <?php
                        if( isset($_POST['delete-adm'])){
                            $del_response = $user->delete_admin_usr($_POST['id']);
                            if(json_decode($del_response)->status == '0')
                            {
                                print '<div class="alert alert-success">'.json_decode($del_response)->message.'</div>';
                            }
                            else
                            {
                                print '<div class="alert alert-danger">'.json_decode($del_response)->message.'</div>';
                            }
                        }
                        if( isset($_POST['modify-adm'])){
                            try{
                                if(strlen($_POST['password']))
                                {
                                    $util->ValidatePasswordStrength($_POST['password']);
                                }
                                $adm_response = $user->update_admin_usr($_POST, $_POST['id']);
                                if(json_decode($adm_response)->status == '0')
                                {
                                    print '<div class="alert alert-success">'.json_decode($adm_response)->message.'</div>';
                                }
                                else
                                {
                                    print '<div class="alert alert-danger">'.json_decode($adm_response)->message.'</div>';
                                }
                            }catch(Exception $e){
                                print $util->error_flash($e->getMessage());
                            }
                        }
                        /** Fetch data */
                            $adminUsers = [];
                            $u = $user->findall_adm_users();
                            if(json_decode($u)->status == '0')
                            {
                                $adminUsers = json_decode($u, true)['data'];
                            }
                            // $util->Show($u);
                        ?>
                        <table class="table display reportable">
                            <thead>
                                <tr>
                                    <th>Internal Id</th>
                                    <th>First Name</th>
                                    <th>Sur Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Created On</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                foreach( $adminUsers as $pos ):
                                    $str = $pos['id'].'~~'.$pos['fname'].'~~'.$pos['sname'].'~~'.$pos['email'].'~~'.$pos['phone'];
                            ?>
                                <tr>
                                    <td><?=$pos['internal_id']?></td>
                                    <td><?=$pos['fname']?></td>
                                    <td><?=$pos['sname']?></td>
                                    <td><?=$pos['email']?></td>
                                    <td><?=$pos['phone']?></td>
                                    <td><?=$util->globalDate($pos['created_at'])?></td>
                                    <td><a onclick="loadInvForm('<?=$str?>')"><img class="animatable" src="img/icn-edit-teal.svg" class="kkk"></a></td>
                                </tr>
                            <?php 
                                endforeach;
                            ?>
                            </tbody>
                        </table>
                        </div>
                </div> 
            </div>
        </section>

        <?php include 'admin-partials/footer.php'; ?>
        <!-- Bootstrap core JavaScript -->
        <?php include 'admin-partials/js.php'; ?>
        <script>
            loadInvForm = function (str)
            {
                var arr = str.split('~~');
                $('#id').val(arr[0]);
                $('#fname').val(arr[1]);
                $('#sname').val(arr[2]);
                $('#email').val(arr[3]);
                $('#phone').val(arr[4]);
                $('#modify_adm').modal('show');
                return;
            }
        </script>
        <!-- popup -->
        <div class="modal fade" id="modify_adm">
            <div class="modal-dialog general_pop_dialogue">
            <div class="modal-content">
                <div class="modal-body text-center">
                <div class="col-md-12 text-center forgot-dialogue-borderz">
                    <h4 class="">Edit Admin User</h4>
                    <div>
                        <form class="filter_form" method="post">
                            <div class="form-group row">
                                <label for="BoxType" class="col-md-4 col-form-label">First Name</label>
                                <div class="col-md-8">
                                    <input type="hidden" name="id" id="id"/>
                                    <input type="text" class="form-control rounded_form_control" id="fname" placeholder="First name" name="fname"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="BoxType" class="col-md-4 col-form-label">Sir Name</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control rounded_form_control" id="sname" placeholder="First name" name="sname"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="BoxType" class="col-md-4 col-form-label">Email address</label>
                                <div class="col-md-8">
                                    <input type="email" class="form-control rounded_form_control" id="email" name="email"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="BoxType" class="col-md-4 col-form-label">Phone</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control rounded_form_control" id="phone" name="phone"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="BoxType" class="col-md-4 col-form-label">Reset Password</label>
                                <div class="col-md-8">
                                    <input type="password" class="form-control rounded_form_control" id="password" name="password"/>
                                </div>
                            </div>
                            <hr>
                            <div class=" row">
                                <div class="col-md-12 text-right text-white">
                                    <button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
                                    <button type="submit" name="modify-adm" class="btn btn_view_report">Save Changes</button>
                                    <button type="submit" name="delete-adm" class="btn btn-warning btn_view_report">Delete User</button>
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
