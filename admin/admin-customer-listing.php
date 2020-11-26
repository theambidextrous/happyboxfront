<?php 
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
$util = new Util();
$user = new User();
$util->ShowErrors(1);
$user->is_loggedin();
$token = json_decode($_SESSION['usr'])->access_token;
$customer_list = $user->get_all_customers($token);
$customer_list = json_decode($customer_list, true)['data'];
// $util->Show($customer_list);
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Happy Box:: Admin Partner Listing</title>

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
                <div class="row">
                    <div class="col-md-6 section_title">
                        <h3>CUSTOMER LISTING </h3>
                    </div>
                    <div class="col-6 text-right">
                        <a class="btn generate_rpt" href="#">CREATE CUSTOMER</a>
                    </div>
                </div>
            </div>
        </section>
        <section class=" filter_bar ">
            <div class="container ">
                <div class="row ">
                    <div class="col-md-12 ">
                        <h5 class="partner_list_sub_title"> Manage and modify customer listings and profiles here.</h5>                  
 </div>
                   <div class="col-md-12 ">  <div class="table-responsive">
                     <table class="table  partner_table table-bordered">
                      <thead>
                        <tr>
                          <th>IMAGE</th>
                          <th>CUSTOMER NAME</th>
                          <th>CUSTOMER CODE</th>
                          <th class="des_width">CUSTOMER DESCRIPTION</th>
                          <th>CUSTOMER LOCALISATION</th>
                          <th>CONTACT DETAILS</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        // $partner_list = [];
                        if(!empty($customer_list)){
                        foreach ( $customer_list as $ptl ):
                          $customer_details = $user->get_details($ptl['id']);
                          $p_d = json_decode($customer_details, true)['data'];
                          if(!empty($p_d)){
                            $img  = $util->AppUploads() . 'profiles/default.jpg';
                            if($p_d['picture'] != 'default.jpg'){
                              $img  = $p_d['picture'];
                            }
                        ?>
                        <tr>
                          <td class="td1"><img src="<?=$img?>" class="dropdown_user_img rounded-circle"/></td>
                          <td><?=$p_d['fname']. ' ' .$p_d['mname'] . ' ' .$p_d['sname']?></td>
                          <td><?=$p_d['internal_id']?></td>
                          <td><?=$p_d['short_description']?></td>
                          <td><?=$p_d['location']?></td>
                          <td>
                          <table class="contact_table">
                              <div class="table_absimg_wrap">
                              <a href="#"><img src="img/icn-edit-teal.svg" class="table_absimg"></a>
                              </div>
                              <tr><td class="contact_name">Name</td><td><?=$p_d['fname'].' '.$p_d['mname']?></td></tr>
                              <tr><td class="contact_name">Surname</td><td><?=$p_d['sname']?></td></tr>
                              <tr><td class="contact_name">Email</td><td><?=$ptl['email']?></td></tr>
                              <tr><td class="contact_name">Mobile</td><td><?=$p_d['phone']?></td></tr>
                            </table>   
                          </td>
                        </tr>
                        <?php 
                          }
                        endforeach;
                      }else{
                        print '<tr><td colspan="8"><center>No customers found</center></td></tr>';
                      }
                        ?>
                      </tbody>
                    </table>
                   </div>
                  </div>
                </div>
                </div>
        </section>
        





 <?php include 'admin-partials/footer.php'; ?>


        <!-- Bootstrap core JavaScript -->

        <?php include 'admin-partials/js.php'; ?>





    </body>

</html>
