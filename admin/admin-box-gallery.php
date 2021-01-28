<?php 
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
require_once('../lib/Experience.php');
require_once('../lib/Topic.php');
require_once('../lib/Media.php');
require_once('../lib/Picture.php');
$util = new Util();
$user = new User();
$topic = new Topic();
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
                        <h3>BOX GALLERY</h3>
                    </div>
                    <div class="col-6 text-right">
                        <a class="btn generate_rpt" href="admin-box-inventory.php">Back</a>

                    </div>

                </div>
            </div>
        </section>
        <section class=" data+table_section ">
            <div class="container">
            <div class="row ">
                    <div class="col-md-12 ">
                        <br><br>
                        <h4 class="filter_title text-center">Add Gallery to Box 
                        <br><small class="text-muted">You can add more than 1 media</small>
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
                            if( isset($_POST['upload'])){
                                try{
                                    $_SESSION['frm'] = $_POST;
                                    $pc = new Picture($_REQUEST['box'], 'path_name', $_POST['type']);
                                    $pc_resp = $pc->create($token, $_REQUEST['exp']);
                                    // print $pc_resp;
                                    if(json_decode($pc_resp)->status == '0'){
                                        unset($_SESSION['frm']);
                                        print $util->success_flash('Gallery uploaded!');
                                    }else{
                                        print $util->error_flash(json_decode($pc_resp)->message);
                                    }
                                }catch(Exception $e){
                                    print $util->error_flash($e->getMessage());
                                }
                            }
                        ?>
                        <form class="filter_form" method="post" enctype="multipart/form-data">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="BoxType" class="col-form-label"> Choose File</label>
                                    <input type="file" name="path_name" class="form-control rounded_form_control" id="select_box_type"/>
                                </div>
                                <div class="col-md-6">
                                    <label for="BoxType" class="col-form-label">Gallery Type</label>
                                    <select class="form-control" name="type" id="select_box_type">
                                        <?php 
                                            $media_types = json_decode($media->get($token), true)['data'];
                                            foreach( $media_types as $ptn ){
                                                print '<option value="'.$ptn['id'].'">'.$ptn['name'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class=" row">
                                <div class="col-md-12 text-right text-white">
                                    <button type="submit" name="upload" class="btn btn_view_report">Upload Gallery</button>
                                </div>
                            </div>
                        </form>
                    </div> 
                </div>
                <!-- current gallery on this experience -->
                <div class="row ">
                    <div class="col-md-12 ">
                        <br><br>
                        <h4 class="filter_title text-center">Galleries for this Box 
                        </h4>
                    </div>
                    <div class="col-md-12 ">
                        <div class="table-responsive">
                            <table class="table table_data1 table-bordered">
                                <thead>
                                    <tr>
                                        <th>Gallery Type</th>
                                        <th>Gallery Link</th>
                                        <th>Gallery Preview</th>
                                        <th>Administration functions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $exp_media = json_decode($picture->get_byitem($token, $_REQUEST['box']), true)['data'];
                                    // $util->Show($exp_media);
                                    if(!empty($exp_media)){
                                        foreach( $exp_media as $tpc ):
                                    ?>
                                    <tr>
                                        <td><?=$tpc['type']?></td>
                                        <td><?=$tpc['path_name']?></td>
                                        <td><img class="rounded-cirle" width="100px" src="<?=$tpc['path_name']?>" alt=""/></td>
                                        <td class="inner_table_wrap">
                                            <table class="text-white inner_table">
                                                <tr>
                                                    <td class="td_b">
                                                        <a href="admin-box-gallery.php?action=del&&mt=<?=$tpc['id']?>" class="light">Delete</a> 
                                                    </td>
                                                </tr>
                                            </table>  
                                        </td>
                                    </tr>
                                    <?php 
                                        endforeach;
                                        }else{
                                            print '<tr><td colspan="4">No media found for this experience </td></tr>';
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- end current -->
            </div>
        </section>
        <br>
        <br>
 <?php include 'admin-partials/footer.php'; ?>


        <!-- Bootstrap core JavaScript -->

        <?php include 'admin-partials/js.php'; ?>





    </body>

</html>
