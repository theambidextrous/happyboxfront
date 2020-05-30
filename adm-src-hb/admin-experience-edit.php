<?php 
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
require_once('../lib/Experience.php');
require_once('../lib/Topic.php');
$util = new Util();
$user = new User();
$topic = new Topic();
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
                        <h3>EDIT EXPERIENCE</h3>
                    </div>
                    <div class="col-6 text-right">
                        <a class="btn generate_rpt" href="admin-experience-inventory.php">Back</a>

                    </div>

                </div>
            </div>
        </section>
        <section class=" data+table_section ">
            <div class="container">
            <div class="row ">
                    <div class="col-md-12 ">
                        <br><br>
                        <h4 class="filter_title text-center">Edit Experience </h4>                  
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-7 ">
                        <?php 

                            if(!isset($_REQUEST['exp'])){
                                print $util->error_flash('wrong request');
                                exit;
                            }
                            $_SESSION['frm'] = json_decode($experience->get_one($token, $_REQUEST['exp']), true)['data'];
                            // $util->Show($_SESSION['frm']);
                            if( isset($_POST['update'])){
                                try{
                                    $_SESSION['frm'] = $_POST;
                                    $exp = new Experience($_POST['partner'], $_POST['name'], $_POST['description'], $_POST['price'], $_POST['topic']);
                                    $expe_resp = $exp->update($token, $_REQUEST['exp']);
                                    // print $expe_resp;
                                    if(json_decode($expe_resp)->status == '0'){
                                        unset($_SESSION['frm']);
                                        print $util->success_flash('Experience updated!');
                                    }else{
                                        print $util->error_flash(json_decode($expe_resp)->message);
                                    }
                                }catch(Exception $e){
                                    print $util->error_flash($e->getMessage());
                                }
                            }
                        ?>
                        <form class="filter_form" method="post">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="BoxType" class="col-form-label">Name</label>
                                    <input type="text" placeholder="experience name" name="name" class="form-control rounded_form_control" id="select_box_type" value="<?=$_SESSION['frm']['name']?>"/>
                                </div>
                                <div class="col-md-6">
                                    <label for="BoxType" class="col-form-label">Partner</label>
                                    <select class="form-control" name="partner" id="select_box_type">
                                        <option value="nn">Select experience partner</option>
                                        <?php 
                                            $partners = json_decode($user->get_all_partner($token), true)['data'];
                                            foreach( $partners as $ptn ){
                                                $data_p = $user->get_details($ptn['id']);
                                                $data_p = json_decode($data_p, true)['data'];
                                                if(!empty($data_p)){
                                                    if( $data_p['internal_id'] == $_SESSION['frm']['partner']){
                                                        print '<option selected value="'.$data_p['internal_id'].'">'.$data_p['business_name'].'</option>';
                                                    }else{
                                                        print '<option value="'.$data_p['internal_id'].'">'.$data_p['business_name'].'</option>';
                                                    }
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="BoxType" class="col-form-label">Price</label>
                                    <input type="number" placeholder="experience price" name="price" class="form-control rounded_form_control" id="select_box_type" value="<?=$_SESSION['frm']['price']?>"/>
                                </div>
                                <div class="col-md-6">
                                    <label for="BoxType" class="col-form-label">Topic</label>
                                    <select class="form-control" name="topic" id="select_box_type">
                                        <option value="nn">Select experience topic</option>
                                        <?php 
                                            $topics = json_decode($topic->get($token), true)['data'];
                                            foreach( $topics as $tpc ){
                                                if( $tpc['internal_id'] == $_SESSION['frm']['topic']){
                                                    print '<option selected value="'.$tpc['internal_id'].'">'.$tpc['name'].'</option>';
                                                }else{
                                                    print '<option value="'.$tpc['internal_id'].'">'.$tpc['name'].'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="BoxType" class="col-form-label">Description</label>
                                    <textarea name="description" placeholder="experience description" class="form-control rounded_form_control" id="select_box_type"><?=$_SESSION['frm']['description']?></textarea>
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
                            <div class=" row">
                                <div class="col-md-12 text-right text-white">
                                    <button type="submit" name="update" class="btn btn_view_report">save changes</button>
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
