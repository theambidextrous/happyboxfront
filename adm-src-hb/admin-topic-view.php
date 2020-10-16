<?php 
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
require_once('../lib/Topic.php');
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
                        <h3>VIEW TOPIC</h3>
                    </div>
                    <div class="col-6 text-right">
                        <a class="btn generate_rpt" href="admin-topic-inventory.php">Back</a>

                    </div>

                </div>
            </div>
        </section>
        <section class=" data+table_section ">
            <div class="container">
            <div class="row ">
                    <div class="col-md-12 ">
                    <br><br>
                        <h4 class="filter_title text-center">View Topic</h4>                  
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-7 ">
                        <?php 
                            $topic_ = [];
                            if( !isset($_REQUEST['topic'])){
                                print $util->error_flash('wrong request');
                            }else{
                                $t = new Topic();
                                $topic_ = $t->get_one($token, $_REQUEST['topic']);
                                // $util->Show($topic_);
                                if(json_decode($topic_)->status != 0){
                                    print $util->error_flash('wrong request');
                                }else{
                                    $topic_data = json_decode($topic_)->data;
                        ?>
                        <form class="filter_form" method="post">
                            <div class="form-group row">
                                <label for="BoxType" class="col-md-4 col-form-label">Topic name</label>
                                <div class="col-md-8">
                                    <input type="text" readonly placeholder="topic name" class="form-control rounded_form_control" value="<?=$topic_data->name?>"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="BoxType" class="col-md-4 col-form-label">Topic description</label>
                                <div class="col-md-8">
                                    <input type="text" readonly placeholder="topic description" class="form-control rounded_form_control" value="<?=$topic_data->description?>" />
                                </div>
                            </div>
                            <hr>
                            <div class=" row">

                                <div class="col-md-12 text-right text-white">
                                    <!-- <button type="submit" name="create" class="btn btn_view_report">Create</button> -->
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
