<?php 
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
require_once('../lib/Media.php');
$util = new Util();
$user = new User();
$util->ShowErrors();
$user->is_loggedin();
$token = json_decode($_SESSION['usr'])->access_token;
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
                        <h3>EDIT MEDIA TYPE</h3>
                    </div>
                    <div class="col-6 text-right">
                        <a class="btn generate_rpt" href="admin-mediatype-inventory.php">Back</a>

                    </div>

                </div>
            </div>
        </section>
        <section class=" data+table_section ">
            <div class="container">
            <div class="row ">
                    <div class="col-md-12 ">
                    <br><br>
                        <h4 class="filter_title text-center">Edit Media type</h4>                  
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-7 ">
                        <?php 
                            $_names = $util->get_media_types();
                            $media_ = [];
                            if( !isset($_REQUEST['mt'])){
                                print $util->error_flash('wrong request');
                            }else{
                                $m = new Media();
                                $media_ = $m->get_one($token, $_REQUEST['mt']);
                                // $util->Show($topic_);
                                if(json_decode($media_)->status != 0){
                                    print $util->error_flash('wrong request');
                                }else{
                                    $media_data = json_decode($media_)->data;
                                    if(isset($_POST['update'])){
                                        $mdt = new Media($_POST['name']);
                                        $resp = $mdt->update($token, $_REQUEST['mt']);
                                        if(json_decode($resp)->status == 0){
                                            print $util->success_flash('updated successfully');
                                        }else{
                                            print $util->error_flash(json_decode($resp)->message);
                                        }
                                    }
                        ?>
                        <form class="filter_form" method="post">
                            <div class="form-group row">
                                <label for="BoxType" class="col-md-4 col-form-label">Media Type name</label>
                                <div class="col-md-8">
                                    <select class="form-control rounded_form_control" name="name" id="select_box_type">
                                        <?php 
                                        foreach( $_names as $_n ){
                                            if($_n == $media_data->name ){
                                                print '<option selected value="'.$_n.'">'.$_n.'</option>';
                                            }else{
                                                print '<option value="'.$_n.'">'.$_n.'</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class=" row">

                                <div class="col-md-12 text-right text-white">
                                    <button type="submit" name="update" class="btn btn_view_report">Save changes</button>
                                </div>

                            </div>
                        </form>
                        <?php
                                   
                                }
                            }
                        ?>
                    </div> 
                </div>
            </div>
        </section><br><br>




 <?php include 'admin-partials/footer.php'; ?>


        <!-- Bootstrap core JavaScript -->

        <?php include 'admin-partials/js.php'; ?>





    </body>

</html>
