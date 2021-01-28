<?php 
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
require_once('../lib/Report.php');
require_once('../lib/Inventory.php');
require_once('../lib/Box.php');
$util = new Util();
$user = new User();
$box = new Box();
$report = new Report();
$inventory = new Inventory();
$util->ShowErrors(1);
$user->is_loggedin();
$token = json_decode($_SESSION['usr'])->access_token;
$_reports = json_decode($report->get($token), true)['data'];
// $util->Show($reports);
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

        <title>Happy Box:: Admin Reports</title>
        <!-- Bootstrap core CSS -->
        <?php include 'admin-partials/css.php'; ?>
        <style>
            .admin-report{
                color: #c20a2b!important;
                text-decoration: none!important;
                border-bottom: solid 2px #c20a2b!important;
            }
            #report_id_filter{
                display:none!important;
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
                        <ul class="nav nav-pills rep_nav_pills">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                    <h3><strong>REPORTS</strong><img src="img/report_down_arrow.svg" class="report_arrow"></h3>
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
                    <div class="col-md-6 text-right create_report_r">
                        <a class="btn btn_view_report create_report_r_btn text-right" href="#" data-toggle="modal" data-target="#create_report">CREATE REPORT</a>
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
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <?php
                        $table_ = null;
                        if(!isset($_SESSION['dtr'])){
                            $_SESSION['dtr'] = [];
                        }
                        if( isset($_REQUEST['report']) && !empty($_REQUEST['report']) ){ 
                        $_curr_report = json_decode($report->get_one($token, $_REQUEST['report']))->data;
                            // print $_curr_report->cols;
                            if(isset($_POST['vreport'])){
                                $_SESSION['dtr'] = $_POST;
                                $body = [
                                    'cols' => $_curr_report->cols,
                                    'date_from' => $_POST['date_from'],
                                    'date_to' => $_POST['date_to']
                                ];
                                $results = json_decode($inventory->get_report($token, $body), true)['data'];
                                // $util->Show($results);
                                //$results, $cols, $user_ob, $box_ob, $token
                                $table_ = $util->build_report_table($results, $_curr_report->cols, $user, $box, $token);
                            }
                        ?>
                            <h4 class="filter_title text-center"> <a href="admin-reports.php">Reports</a> > <a href="###"><?=$_curr_report->name?> filters</a></h4>
                            <form class="filter_form" method="post">
                                <div class="form-group row">
                                    <label for="DateRange" class="col-md-2 col-form-label">From Date</label>
                                    <div class="col-md-4">
                                    <input type="date" class="form-control" id="select_box_type" name="date_from" value="<?=$_SESSION['dtr']['date_from']?>"/>
                                    </div>
                                    <label for="DateRange" class="col-md-2 col-form-label">To Date</label>
                                    <div class="col-md-4">
                                        <input type="date" class="form-control" id="select_box_type" name="date_to" value="<?=$_SESSION['dtr']['date_to']?>"/>
                                    </div>
                                </div>
                                <div class=" row">
                                    <div class="col-md-12 text-right text-white">
                                        <button type="submit" name="vreport" class="btn btn_view_report">Run Report</button>
                                        <button type="submit" name="vreport" class="btn btn_view_report">View Report</button>
                                    </div>
                                </div>
                            </form>
                            <hr>
                            <div class=" row">
                                <div class="col-md-12 text-center text-muted">
                                    <h4>Returned results</h4>
                                </div>
                                <div class="col-md-12 text-white">
                                    <?php
                                        if(!is_null($table_)){
                                            print $table_;
                                        }
                                    ?>
                                </div>
                            </div>
                        <?php   
                    }else{
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
    <script>
    $(document).ready(function() {
        $('#report_id').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5'
                // 'pdfHtml5'
            ]
        } );
    } );
    </script>
</html>
