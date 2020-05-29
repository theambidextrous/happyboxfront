<?php 
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
$util = new Util();
$user = new User();
$util->ShowErrors();
$user->is_loggedin();
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
                       <!-- <h3><strong>REPORTS</strong>  <select class=" select_reports" id="select_reports">
                                <option></option>
                                <option>Sales by Box Type</option>
                                <option>Sales by Customer</option>
                                <option>Sales by Partner</option>
                                <option>List of Customers</option>
                                <option>List of Partners</option>
                                <option>List of Voucher Codes</option>
                                <option>List of Box Codes</option>
                            </select> </h3>-->
                       <ul class="nav nav-pills">
    
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"><h3><strong>REPORTS </strong> <i class="fas fa-angle-down"></i> </h3></a>
      <div class="dropdown-menu">
               <a class="dropdown-item" href="#">Sales by Box Type</a>
                           <a class="dropdown-item" href="#">Sales by Customer</a>
                          <a class="dropdown-item" href="#">Sales by Partner</a>
                              <a class="dropdown-item" href="#">List of Customers</a>
                                <a class="dropdown-item" href="#">List of Partners</a>
                              <a class="dropdown-item" href="#">List of Voucher Codes</a>
                             <a class="dropdown-item" href="#">List of Box Codes</a>
      
      </div>
    </li>
   
   
  </ul>
                    </div>


                </div>
            </div>
        </section>
        <section class=" filter_bar ">
            <div class="container ">
                <div class="row ">
                    <div class="col-md-12 ">
                        <h4 class="filter_title text-center"> Report Filters</h4>                  
                    </div>


                </div>
                <div class="row justify-content-center">
                    <div class="col-md-5 ">
                        <form class="filter_form">
                            <div class="form-group row">
                                <label for="BoxType" class="col-md-4 col-form-label">Box Type</label>
                                <div class="col-md-8">
                                    <select class=" form-control" id="select_box_type">
                                        <option value="">Select a box type</option>
                                        <option>Box type a</option>
                                        <option>Box type b</option>
                                        <option>Box type c</option>
                                        <option>Box type d</option>
                                        <option>Box type e</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="fromCategory" class="col-md-4 col-form-label">From Category</label>
                                <div class="col-md-8">
                                    <select class=" form-control" id="select_box_type">
                                        <option value="">Select a category</option>
                                        <option>Category 1</option>
                                        <option>Category 2</option>
                                        <option>Category 3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="toCategory" class="col-md-4 col-form-label">To Category</label>
                                <div class="col-md-8">
                                    <select class=" form-control" id="select_box_type">
                                        <option value="">Select a category</option>
                                        <option>Category 1</option>
                                        <option>Category 2</option>
                                        <option>Category 3</option>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <h4 class="filter_title text-center"> Report Options</h4>   
                            <div class="form-group row">
                                <label for="DateRange" class="col-md-4 col-form-label">Date Range</label>
                                <div class="col-md-4">
                                    <select class=" form-control" id="select_box_type">
                                        <option value="Monthly">Monthly</option>
                                        <option>Daily</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select class=" form-control" id="select_box_type">

                                        <option>Current Month</option>
                                        <option>January</option>

                                    </select>
                                </div>
                            </div>
                            <div class=" row">

                                <div class="col-md-12 text-right text-white">
                                    <button type="submit" class="btn btn_view_report">VIEW REPORT</button>
                                </div>

                            </div>



                        </form>
                    </div> </div> </div>
        </section>






        <?php include 'admin-partials/footer.php'; ?>


        <!-- Bootstrap core JavaScript -->

        <?php include 'admin-partials/js.php'; ?>





    </body>

</html>
