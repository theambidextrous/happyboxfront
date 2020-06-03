<?php 
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
require_once('../lib/Topic.php');
require_once('../lib/Box.php');
require_once('../lib/Experience.php');
require_once('../lib/Picture.php');
$util = new Util();
$user = new User();
$topic = new Topic();
$util->ShowErrors(1);
$user->is_loggedin();
$token = json_decode($_SESSION['usr'])->access_token;
// $util->Show($_partners_list);
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
        <style>
            .admin-box-new{
                color: #c20a2b!important;
                text-decoration: none!important;
                border-bottom: solid 2px #c20a2b!important;
            }
        </style>
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
                        <h3>CREATE BOX</h3>
                    </div>
                    <div class="col-6 text-right">
                        <a class="btn generate_rpt" href="admin-box-all.php">Back</a>
                    </div>
                </div>
            </div>
        </section>
        <section class=" data+table_section ">
            <div class="container">
            <div class="row ">
                    <div class="col-md-12 ">
                    <br><br>
                        <h4 class="filter_title text-center">New Box </h4>                  
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-7 ">
                        <?php 
                            $_SESSION['frm'] = [];
                            if( isset($_POST['create'])){
                                try{
                                    foreach($_POST['topics'] as $_t ){
                                        if($_t != 'nn'){
                                         $_tp[] = $_t;
                                        }
                                     }
                                    foreach( $_POST['partners'] as $_e ){
                                       if($_e != 'nn'){
                                        $_partners[] = $_e;
                                       }
                                    }
                                    $_POST['topics'] = implode(',', $_tp);
                                    $_POST['partners'] = implode(',', $_partners);
                                    $b = new Box(
                                        $_POST['name'], $_POST['price'], $_POST['description'], $_POST['topics'],$_POST['partners'],'00'
                                    );
                                    $resp = $b->create($token);
                                    if(json_decode($resp)->status == '0'){
                                        /** upload media */
                                        $box_internal_id = json_decode($resp)->box;
                                        /** 3d */
                                        $pc_3d = new Picture($box_internal_id, '3dimg', '2');
                                        $pc_3d_resp = $pc_3d->create($token, $box_internal_id);
                                        if(json_decode($pc_3d_resp)->status != '0'){
                                            throw new Exception('3D image could not be uploaded!');
                                        }
                                        /** pdf */
                                        $pc_pdf = new Picture($box_internal_id, 'pdfbooklet', '3');
                                        $pc_pdf_resp = $pc_pdf->create($token, $box_internal_id);
                                        if(json_decode($pc_pdf_resp)->status != '0'){
                                            throw new Exception('PDF could not be uploaded!');
                                        }
                                        print $util->success_flash('Created successfully');
                                    }else{
                                        print $util->error_flash(json_decode($resp)->message);
                                    }
                                }catch(Exception $e){
                                    print $util->error_flash($e->getMessage());
                                }
                            }
                        ?>
                        <form class="filter_form" method="post" enctype="multipart/form-data">
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
                                    <label for="BoxType" class="col-form-label">List of partners</label>
                                    <select class="form-control select2" multiple name="partners[]" id="">
                                        <option value="nn">Select box partners</option>
                                        <?php 
                                            $_partners_list = json_decode($user->get_all_partner($token), true)['data'];
                                            foreach( $_partners_list as $ptn ){
                                                $_d = $user->get_details($ptn['id']);
                                                $partner_name = json_decode($_d)->data->business_name;
                                                $internal_id = json_decode($_d)->data->internal_id;
                                                 print '<option value="'.$internal_id.'">'.$partner_name.'</option>';
                                            }
                                        ?>
                                    </select>
                                    <!-- <span><small class="text-muted">Not what you want?</small> <a href="admin-topic-new.php"class=""> create new topic</a></span> -->
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="BoxType" class="col-form-label">List of Topics</label>
                                    <select class="form-control select2" multiple name="topics[]" id="">
                                        <option value="nn">Select box related topic(s)</option>
                                        <?php 
                                            $topics = json_decode($topic->get($token), true)['data'];
                                            foreach( $topics as $ptn ){
                                                 print '<option value="'.$ptn['internal_id'].'">'.$ptn['name'].'</option>';
                                            }
                                        ?>
                                    </select>
                                    <!-- <span><small class="text-muted">Not what you want?</small> <a href="admin-experience-new.php"class=""> create new experience</a></span> -->
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="BoxType" class="col-form-label">Description</label>
                                    <textarea name="description" placeholder="box description" class="form-control rounded_form_control" id="select_box_type"><?=$_SESSION['frm']['description']?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="BoxType" class="col-form-label">3D image</label>
                                    <input required type="file" name="3dimg" class="form-control rounded_form_control" id="select_box_type"/>
                                </div>
                                <div class="col-md-6">
                                    <label for="BoxType" class="col-form-label">PDF Booklet</label>
                                    <input required type="file" name="pdfbooklet" class="form-control rounded_form_control" id="select_box_type"/>
                                </div>
                            </div>
                            <hr>
                            <div class=" row">
                                <div class="col-md-12 text-right text-white">
                                    <button type="submit" name="create" class="btn btn_view_report">Create</button>
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
