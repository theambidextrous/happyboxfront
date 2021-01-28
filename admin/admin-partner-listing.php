<?php 
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
require_once('../lib/Picture.php');
$util = new Util();
$user = new User();
$picture = new Picture();
$util->ShowErrors(1);
$user->is_loggedin();
$token = json_decode($_SESSION['usr'])->access_token;
$partner_list = $user->get_all_partner($token);
$partner_list = json_decode($partner_list, true)['data'];
// $util->Show(json_decode($partner_list, true));
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

        <title>Happy Box:: Admin Partner Listing</title>

        <!-- Bootstrap core CSS -->
        <?php include 'admin-partials/css.php'; ?>
        <style>
            .admin-p-list{
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
                <div class="row">
                    <div class="col-md-6 section_title">
                        <h3>PARTNER LISTING </h3>
                    </div>
                    <div class="col-6 text-right">
                        <a class="btn generate_rpt" href="admin-partner-new.php">CREATE PARTNER</a>
                    </div>
                </div>
            </div>
        </section>
        <section class=" filter_bar ">
            <div class="container ">
                <div class="row ">
                    <div class="col-md-12 ">
                        <h5 class="partner_list_sub_title"> Manage and modify partner listings and profiles here.</h5>                  
 </div>
                   <div class="col-md-12 ">  
                     
                        <?php 
                        // $partner_list = [];
                        if(!empty($partner_list)){
                        foreach ( $partner_list as $ptl ):
                          $partner_details = $user->get_details($ptl['id']);
                          $p_d = json_decode($partner_details, true)['data'];
                          if(!empty($p_d)){
                            $img  = $util->AppUploads() . 'profiles/default.jpg';
                            $_media = $picture->get_byitem($token, $p_d['internal_id']);
                            $_media = json_decode($_media, true)['data'];
                            foreach( $_media as $_mm ){
                                if($_mm['type'] == '2'){
                                   $img = $_mm['path_name'];
                                }
                            }
                            // if($p_d['picture'] != 'default.jpg'){
                            //   $img  = $p_d['picture'];
                            // }
                        ?>
                               <div class="relative_div">
                             <div class="table_absimg_wrap">
                              <a href="admin-partner-edit.php?pt=<?=$ptl['id']?>"><img src="img/icn-edit-teal.svg" class="table_absimg"></a>
                              </div>
                      </div>
                       
                         <div class="table_radius table_radius_admin">
                       <div class="table-responsive">
                           <table class="table  partner_table table-bordered">
                      <thead>
                        <tr>
                            <th class="partner_table_img_td">Image</th>
                          <th>Partner Name</th>
                          <th>Partner Code</th>
                          <th class="des_width">Partner Description</th>
                          <th>Partner<br> Localisation</th>
                          <th>PIN Number</th>
                          <th>Topic</th>
                          <th>Contact Details</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                  
                          
                          <td class="td1" align="center"><img src="<?=$img?>" class="admin_part_listing_img "/></td>
                          <td><?=$p_d['business_name']?></td>
                          <td><?=$p_d['internal_id']?></td>
                          <td><?=$p_d['short_description']?></td>
                          <td><?=$p_d['location']?></td>
                          <td><?=$p_d['business_reg_no']?></td>
                          <td><?=$p_d['business_category']?></td>
                          <td>
                          <table class="contact_table table_borderless">
                             
                              <tr><td class="contact_name">Name <b class="contact_val"><?=$p_d['fname'].' '.$p_d['mname']?></b></td></tr>
                              <tr><td class="contact_name">Surname <b class="contact_val"><?=$p_d['sname']?></b></td></tr>
                              <tr><td class="contact_name">Email <b class="contact_val"><?=$ptl['email']?></b></td></tr>
                              <tr><td class="contact_name border_less_td">Mobile <b class="contact_val"><?=$p_d['phone']?></b></td></tr>
                            </table>   
                          </td>
                        </tr>
                           </tbody>
                    </table>
                           </div>        </div>
                        <?php 
                          }
                        endforeach;
                      }else{
                        print '<tr><td colspan="8"><center>No partners found</center></td></tr>';
                      }
                        ?>
                   
                   
                  </div>
                </div>
                </div>
        </section>
        





 <?php include 'admin-partials/footer.php'; ?>


        <!-- Bootstrap core JavaScript -->

        <?php include 'admin-partials/js.php'; ?>





    </body>

</html>
