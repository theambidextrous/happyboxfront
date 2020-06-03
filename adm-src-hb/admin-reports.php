<?php 
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
require_once('../lib/Report.php');
$util = new Util();
$user = new User();
$report = new Report();
$util->ShowErrors();
$user->is_loggedin();
$token = json_decode($_SESSION['usr'])->access_token;
$_reports = json_decode($report->get($token), true)['data'];
// $util->Show($reports);
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Happy Box:: Admin Reports</title>
        <!-- Bootstrap core CSS -->
        <?php include 'admin-partials/css.php'; ?>
        <style>
            .admin-report{
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
                <div class="col-md-12 ">
                <?php include 'admin-partials/mid-nav.php'; ?>
                </div>

            </div>
        </section>
        <!--end discover our selection-->
        <section class=" top_blue_bar ">
            <div class="container">
                <div class="row rpt_drop">
                    <div class="col-md-6 section_title">
                        <ul class="nav nav-pills">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                    <h3><strong>REPORTS</strong><i class="fas fa-angle-down"></i></h3>
                                </a>
                                <div class="dropdown-menu">
                                    <?php
                                        foreach( $_reports as $_rrr ){
                                            print '<a class="dropdown-item" href="admin-reports.php?report='.$_rrr['id'].'">'.$_rrr['name'].'</a>';
                                        }
                                    ?>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6 text-right">
                        <a class="btn btn_view_report text-right" href="#" data-toggle="modal" data-target="#create_report">CREATE REPORT</a>
                    </div>
                </div>
            </div>
        </section>
        <section class=" filter_bar ">
            <div class="container ">
                <div class="row ">
                    <div class="col-md-12">
                        <?php
                            if(isset($_POST['save'])){
                                try{
                                    $r = new Report($_POST['name'], implode(',',$_POST['cols']));
                                    $resp = $r->create($token);
                                    // print $resp;
                                    if ( json_decode( $resp )->status == '0' ){
                                        $util->timed_redirect('admin-reports.php');
                                        print $util->success_flash('Report created successfully! Reloading ...');
                                    }else{
                                        print $util->error_flash(json_decode( $resp )->message);
                                    }
                                }catch(Exception $e){
                                    print $util->error_flash($e->getMessage());
                                }
                            }
                    
                        ?>
                        <h4 class="filter_title text-center"> Report Filters</h4>                  
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-8 ">
                        <?php
                            if( isset($_REQUEST['report']) ){ ?>
                            <form class="filter_form" action="post">
                                <div class="form-group row">
                                    <label for="DateRange" class="col-md-2 col-form-label">From Date</label>
                                    <div class="col-md-4">
                                    <input type="date" class="form-control" id="select_box_type" name="dfrom"/>
                                    </div>
                                    <label for="DateRange" class="col-md-2 col-form-label">To Date</label>
                                    <div class="col-md-4">
                                        <input type="date" class="form-control" id="select_box_type" name="dto"/>
                                    </div>
                                </div>
                                <div class=" row">
                                    <div class="col-md-12 text-right text-white">
                                        <button type="button" class="btn btn_view_report">Run Report</button>
                                        <button type="button" class="btn btn_view_report">View Report</button>
                                    </div>
                                </div>
                            </form>
                        <?php   }else{
                            print $util->error_flash('You MUST select a report from top left OR <a href="#" data-toggle="modal" data-target="#create_report">Create New Report</a>');
                        }
                        ?>
                    </div> </div> </div>
        </section>






        <?php include 'admin-partials/footer.php'; ?>

        <!-- Bootstrap core JavaScript -->

        <?php include 'admin-partials/js.php'; ?>
        <!-- popup -->
        <div class="modal fade" id="create_report">
            <div class="modal-dialog general_pop_dialogue">
            <div class="modal-content">
                <div class="modal-body text-center">
                <div class="col-md-12 text-center forgot-dialogue-borderz">
                    <h4 class="">Create New Report</h4>
                    <div>
                        <form class="filter_form" method="post">
                            <style>
                                .select2,.select2-container,.select2-container--default,.select2-container--below, .select2-container--focus{
                                    width:100%!important;
                                }
                            </style>
                            <div class="form-group row">
                                <label for="BoxType" class="col-form-label">Report Name</label>
                                <input type="text" placeholder="name of this report" name="name" class="form-control rounded_form_control" id="select_box_type"/>
                            </div>
                            <div class="form-group row">
                                <label for="BoxType" class="col-form-label">Select Columns</label>
                            </div>
                            <div class="form-group row">
                                <select class="form-control select2" multiple name="cols[]" id="">
                                    <?php 
                                        $cols = $util->report_cols();
                                        foreach( $cols as $k => $v ){
                                            print '<option value="'.$k.'">'.$v.'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                            <hr>
                            <div class=" row">
                                <div class="col-md-12 text-right text-white">
                                    <button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
                                    <button type="submit" name="save" class="btn btn_view_report">Save</button>
                                </div>
                            </div>
                            <script>
                                $(document).ready(function() {
                                    $('.select2').select2();
                                });
                            </script>
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
