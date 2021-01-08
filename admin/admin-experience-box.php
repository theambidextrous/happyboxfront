<?php 
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
require_once('../lib/Experience.php');
require_once('../lib/Topic.php');
require_once('../lib/Box.php');
require_once('../lib/BoxExperience.php');
$util = new Util();
$user = new User();
$topic = new Topic();
$box = new Box();
// $box = new Box('MadarakaPack', '50000', 'Madaraka Special Pack', 'TP-OLSA4DMI,TP-CR7IN7IR');
// print $box->create($token);
$experience = new Experience();
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
                        <h3>ADD EXPERIENCE TO EXISTING HAPPYBOX</h3>
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
                        <h4 class="filter_title text-center">Add Experience to existing happybox</h4>                  
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-7 ">
                        <?php 

                            if(!isset($_REQUEST['exp'])){
                                print $util->error_flash('wrong request');
                                exit;
                            }
                            // $util->Show($_SESSION['frm']);
                            if( isset($_POST['tobox'])){
                                try{
                                    $bx = new BoxExperience($_POST['experience'], $_POST['happybox']);
                                    $bx_resp = $bx->create($token);
                                    // print $bx_resp;
                                    if(json_decode($bx_resp)->status == '0'){
                                        print $util->success_flash('Experience added to box!');
                                    }else{
                                        print $util->error_flash(json_decode($bx_resp)->message);
                                    }
                                }catch(Exception $e){
                                    print $util->error_flash($e->getMessage());
                                }
                            }
                        ?>
                        <form class="filter_form" method="post">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="BoxType" class="col-form-label">Selected experience</label>
                                    <select readonly class="form-control" name="experience" id="select_box_type">
                                        <?php 
                                        $this_exp = json_decode($experience->get_one($token, $_REQUEST['exp']), true)['data'];
                                        print '<option selected value="'.$this_exp['internal_id'].'">'.$this_exp['name'].'</option>';
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="BoxType" class="col-form-label">Choose a box to add to</label>
                                    <select class="form-control" name="happybox" id="select_box_type">
                                        <option value="nn">Select a box to be added to</option>
                                        <?php 
                                            $happyboxes = json_decode($box->get($token), true)['data'];
                                            foreach( $happyboxes as $ptn ){
                                                print '<option selected value="'.$ptn['internal_id'].'">'.$ptn['name'].'</option>';
                                            }
                                        ?>
                                    </select>
                                    <span><small class="text-muted">Not what you want?</small> <a href="admin-box-inventory.php"class=""> Create New Box</a></span>
                                </div>
                            </div>
                            <hr>
                            <div class=" row">
                                <div class="col-md-12 text-right text-white">
                                    <button type="submit" name="tobox" class="btn btn_view_report">add to selected box</button>
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
