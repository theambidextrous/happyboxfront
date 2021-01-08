<?php 
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
require_once('../lib/Box.php');
require_once('../lib/Topic.php');
require_once('../lib/Picture.php');
$util = new Util();
$user = new User();
$topic = new Topic();
$picture = new Picture();
$util->ShowErrors(1);
$user->is_loggedin();
$token = json_decode($_SESSION['usr'])->access_token;
$box = new Box();
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
        <style>
            .admin-box{
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
                        <h3>BOX DESIGNS</h3>
                    </div>
                    <div class="col-6 text-right">
                        <a class="btn generate_rpt" href="admin-box-new.php" >New Box Conception</a>
                        <!-- <a class="btn generate_rpt" href="#" data-toggle="modal" data-target="#generate_box" >New Box Conception</a> -->
                    </div>
                </div>
            </div>
        </section>
        <section class=" status_bar ">
                    <div class="container justify-content-around">
                <div class="row ">
                    <div class="col-md-2">
                        <a href="admin-box-all.php" class="btn generate_rpt btn-block is_active">Available</a>
                    </div>
                    <div class="col-md-2">
                        <a href="admin-box-all-draft.php" class="btn generate_rpt btn-block">Suspended</a>
                    </div>
                </div>
            </div>
        </section>
        <section class=" data_table_section data_table_section_box_design">
            <div class="container">
                <div class="row ">
                    <div class="col-md-12 ">
                       
                        <div class="table_radius table_radius_admin">
                        <div class="table-responsive ">
                    
                        <table class="table table_data1 table-bordered table-box-designs">
                            <thead>
                                <tr>
                                    <th>Box Internal Id</th>
                                    <th>Box Name</th>
                                    <th>Box Price</th>
                                    <th>Box Description</th>
                                    <th>List of Partners</th>
                                    <th>List of Topics</th>
                                    <th>3D Image</th>
                                    <th>PDF Booklet</th>
                                    <th class="admin_des">Administrative functions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $all_happyboxes = json_decode($box->get($token), true)['data'];
                                foreach($all_happyboxes as $hbox ):
                                    if($hbox['is_active'] == '2'){
                                    $_media = $picture->get_byitem($token, $hbox['internal_id']);
                                    $_media = json_decode($_media, true)['data'];
                                    $_3d = $pdf = 'N/A';
                                    foreach( $_media as $_mm ){
                                        if($_mm['type'] == '2'){
                                            $_3d = '<img class="rounded-cirle" width="60px" src="'.$_mm['path_name'].'" alt=""/>';
                                        }elseif($_mm['type'] == '3'){
                                            $pdf = '<a target="_blank" download href="'.$_mm['path_name'].'" class="btn btn-danger"><i class="fa fa-file-pdf"></i></a>';
                                        }
                                    }
                                    $_partners = $user->format_box_partners($hbox['partners']);
                                    $_topics = $topic->format_box_topics($token, $hbox['topics']);
                                ?>
                                <tr>
                                    <td><?=$hbox['internal_id']?></td>
                                    <td><?=$hbox['name']?></td>
                                    <td>KES <?=$hbox['price']?></td>
                                    <td><?=$hbox['description']?></td>
                                    <td><?=$_partners?></td>
                                    <td><?=$_topics?></td>
                                    <td><?=$_3d?></td>
                                    <td><?=$pdf?></td>
                                    <td class="inner_table_wrap inner_table_wrap_no">
                                        <table class="text-white inner_table">
                                            <tr>
                                                <td class="td_a">
                                                    <a href="admin-box-edit.php?box=<?=$hbox['internal_id']?>" class="light">Modify</a>
                                                </td>
                                                <td class="td_b">
                                                   <a href="admin-box-deactivate.php?box=<?=$hbox['id']?>" class="light">Suspend</a>    
                                                </td>
                                            </tr>
                                        </table>  
                                    </td>
                                </tr>
                                <?php 
                                    }
                                endforeach;
                                ?>
                            </tbody>
                        </table>
                        </div>
                    </div>
                    </div>
                 </div>
            </div>
        </section>

<br><br><br>
 <?php include 'admin-partials/footer.php'; ?>
<!-- Bootstrap core JavaScript -->
<?php include 'admin-partials/js.php'; ?>
<div class="modal fade" id="generate_box">
    <div class="modal-dialog general_pop_dialogue">
      <div class="modal-content">
        <div class="modal-body text-center">
          <div class="col-md-12 text-center forgot-dialogue-borderz">
            <h4 class="">Add Box Inventory</h4>
            <div>
                <form class="filter_form" method="post">
                    <div class="form-group row">
                        <label for="BoxType" class="col-form-label">Quantity</label>
                         <input type="number" min="1" placeholder="Enter Quantity here" name="quantity" class="form-control rounded_form_control" id="select_box_type"/>
                    </div>
                    <div class="form-group row">
                        <label for="BoxType" class="col-form-label">Box Name</label><br>
                        <select class="form-control" name="boxname" id="">
                            <option value="nn">Select box name</option>
                            <?php 
                                // $topics = json_decode($topic->get($token), true)['data'];
                                // foreach( $topics as $ptn ){
                                //         print '<option value="'.$ptn['internal_id'].'">'.$ptn['name'].'</option>';
                                // }
                            ?>
                        </select>
                    </div>
                    <hr>
                    <div class=" row">
                        <div class="col-md-12 text-right text-white">
                            <button type="button" data-dismiss="modal" name="create" class="btn btn-default">Cancel</button>
                            <button type="submit" name="create" class="btn btn_view_report">Generate</button>
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
