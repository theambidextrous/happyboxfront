<?php 
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
require_once('../lib/Topic.php');
require_once('../lib/Box.php');
require_once('../lib/Experience.php');
require_once('../lib/BoxExperience.php');
$util = new Util();
$user = new User();
$topic = new Topic();
$experience = new Experience();
$box = new Box();
$boxExperience = new BoxExperience();
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
                        <h3>VIEW BOX</h3>
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
                        <h4 class="filter_title text-center">VIEW Box</h4>                  
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-7 ">
                        <?php 
                            if(!isset($_REQUEST['box'])){
                                print $util->error_flash('wrong request');
                                exit;
                            }
                            $_SESSION['frm'] = json_decode($box->get_byidf($token, $_REQUEST['box']), true)['data'];
                            $_this_box_exp = json_decode($boxExperience->get_bybox($token, $_REQUEST['box']), true)['data'];
                            $_is = 0;
                            foreach($_this_box_exp as $_t_b_e ){
                                $_SESSION['frm']['experiences'][$_is] = $_t_b_e['experience'];
                                $_is ++;
                            }
                            // $util->Show($_SESSION['frm']);
                            if( isset($_POST['update'])){
                                try{
                                    foreach( $_POST['topics'] as $_t ){
                                        if($_t != 'nn'){
                                         $_tp[] = $_t;
                                        }
                                     }
                                    foreach( $_POST['experiences'] as $_e ){
                                       if($_e != 'nn'){
                                        $_ex[] = $_e;
                                       }
                                    }
                                    $_POST['topics'] = implode(',', $_tp);
                                    // $util->Show($_ex);
                                    // exit;
                                    $b = new Box($_POST['name'], $_POST['price'], $_POST['description'], $_POST['topics']);
                                    $resp = $b->update($token, $_SESSION['frm']['id']);
                                    if(json_decode($resp)->status == 0){
                                        $box_internal_id = $_REQUEST['box'];
                                        $current_experiences = $_SESSION['frm']['experiences'];
                                        $to_create = array_diff($_ex, $current_experiences);
                                        $to_delete = array_diff($current_experiences, $_ex);
                                        foreach( $to_create as $_experience ):
                                            $boxexperience = new BoxExperience($_experience, $box_internal_id);
                                            $rs = $boxexperience->create($token);
                                            if(json_decode($rs)->status != '0'){
                                                print $util->error_flash(json_decode($rs)->message); 
                                            }
                                        endforeach;
                                        foreach( $to_delete as $_expe ):
                                            $boxexperience = new BoxExperience($_expe, $box_internal_id);
                                            $rs = $boxexperience->delete_all($token);
                                            if(json_decode($rs)->status != '0'){
                                                // print $util->error_flash($rs); 
                                            }
                                        endforeach;
                                        print $util->success_flash('Box Updated successfully');
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
                                <div class="col-md-6">
                                    <label for="BoxType" class="col-form-label">Name</label>
                                    <input type="text" placeholder="Box name" name="name" class="form-control rounded_form_control" id="select_box_type" value="<?=$_SESSION['frm']['name']?>"/>
                                </div>
                                <div class="col-md-6">
                                    <label for="BoxType" class="col-form-label">Price</label>
                                    <input type="number" placeholder="Box price" name="price" class="form-control rounded_form_control" id="select_box_type" value="<?=$_SESSION['frm']['price']?>"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="BoxType" class="col-form-label">Topic(s)</label>
                                    <select class="form-control select2" multiple name="topics[]" id="">
                                        <option value="nn">Select box related topic(s)</option>
                                        <?php 
                                            $topics = json_decode($topic->get($token), true)['data'];
                                            foreach( $topics as $ptn ){
                                                $save_t = explode(',', $_SESSION['frm']['topics']);
                                                if(in_array($ptn['internal_id'], $save_t)){
                                                    print '<option selected value="'.$ptn['internal_id'].'">'.$ptn['name'].'</option>';
                                                }{
                                                    print '<option value="'.$ptn['internal_id'].'">'.$ptn['name'].'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                    <span><small class="text-muted">Not what you want?</small> <a href="admin-topic-new.php"class=""> create new topic</a></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="BoxType" class="col-form-label">Experience(s)</label>
                                    <select class="form-control select2" multiple name="experiences[]" id="">
                                        <option value="nn">Select box experiences</option>
                                        <?php 
                                            $_experiences = json_decode($experience->get($token), true)['data'];
                                            $_saved_exp = $_SESSION['frm']['experiences'];
                                            foreach( $_experiences as $ptn ){
                                                if(in_array($ptn['internal_id'], $_saved_exp)){
                                                    print '<option selected value="'.$ptn['internal_id'].'">'.$ptn['name'].'</option>';
                                                }else{
                                                    print '<option value="'.$ptn['internal_id'].'">'.$ptn['name'].'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                    <span><small class="text-muted">Not what you want?</small> <a href="admin-experience-new.php"class=""> create new experience</a></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="BoxType" class="col-form-label">Description</label>
                                    <textarea name="description" placeholder="box description" class="form-control rounded_form_control" id="select_box_type"><?=$_SESSION['frm']['description']?></textarea>
                                </div>
                            </div>
                            <hr>
                            <div class=" row">
                                <div class="col-md-12 text-right text-white">
                                    <button type="submit" name="update" class="btn btn_view_report">Save Changes</button>
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
