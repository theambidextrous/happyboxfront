<?php
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
require_once('../lib/Box.php');
$util = new Util();
$box = new Box();
$partnerdata = json_decode($_SESSION['usr_info'], true);
$experience_list = $partnerdata['data']['services'];
$experience_list = json_decode($experience_list, true);
$token = json_decode($_SESSION['usr'])->access_token;
?>
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
  <title>Happy Box:: Partner Experience List</title>
  <!-- Bootstrap core CSS -->
 <?php include '../shared/partials/css.php'; ?>
 <style>
   .t-experience{
      color: #c20a2b!important;
      text-decoration: none!important;
      border-bottom: solid 2px #c20a2b!important;
   }
 </style>
</head>

<body class="partner_wrap">
  <!-- Navigation -->
 <?php include '../shared/partials/nav-logged-in.php'; ?>
 
<section class="partner_voucher_list section_60">
           <div class="container">
             <div class="row justify-content-center forgot-dialogue-wrap desktop_view">
               <div class="col-md-12">
                 <h3 class="partner_blueh text-center">MY EXPERIENCE LIST</h3>
                 <p class="forgot_des text-center">Your list of experiences offered.</p>
                <?php 
                // $util->Show($experience_list);
                $boxes = [];
                if(is_object(json_decode($box->get($token)))){
                  $boxes = json_decode($box->get($token), true)['data'];
                }
                // $util->Show($boxes);
                ?>
                <div class="table-responsive">
                  <div class="table_radius">
                    <table class="table  experience_list_table table-bordered">
                        <thead class="expe_li_th">
                        <tr>
                            <th class="blue_cell_th th_box">EXPERIENCE LIST</th>
                            <?php
                            if(count($boxes)){
                              foreach( $boxes as $headers ):
                                print '<th>'.strtoupper($headers['name']).'</th>';
                              endforeach;
                            }
                            ?>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        if(count($experience_list)){
                          foreach( $experience_list as $ex_list ):
                            $ex_list_arr = explode('~', $ex_list);
                            $ekey = $ex_list_arr[0];
                            $evalue = $ex_list_arr[1];
                            $idf = $partnerdata['data']['internal_id'];
                            $partner_item_current = $idf.'~~~'.$ekey.'~~~'.$evalue;
                        ?>
                        <tr>
                          <td>
                          <?=$evalue?>     
                          </td>
                          <?php
                            if(count($boxes)){
                              foreach( $boxes as $tds ):
                                $box_exps = json_decode($tds['partners'], true);
                                if(in_array($partner_item_current, $box_exps)){
                            ?>
                                  <td><img src="../shared/img/icons/icn-tick-teal.svg" class="experience_list_tick"/></td>
                                  <!-- <td class=""></td> -->
                            <?php 
                                }else{
                                  print '<td class=""></td>';
                                }
                                endforeach;
                              }
                            ?>
                        </tr>
                        <?php 
                          endforeach;
                        }
                        ?>
                      </tbody>
                    </table>
                  </div> 
                  </div> 
                </div>
              </div>
               <!--mobile-->
               <div class="row mobile_view">
                    <section  class="blue_band text-center">
			<h2 class="">HAPPYBOX PARTNER PORTAL</h2>
			</section>
   <section  class="mob_maroon_section text-center">
			<h4 class="">MY EXPERIENCE LIST</h4>
			</section>
               <div class="col-md-12">
                   <br>
                 <p class="forgot_des text-center">Your list of experiences offered</p>
                
                </div>
              </div>
               <div class="voucher_list_mob mobile_view">
                     <div class="row  ">
        <div class="col-md-12 ">
             <table class="table  voucher_list_table_mob expe_table_mob table-borderless">
                <thead>
                  <tr class="blue_cell_th_mob text-white">
                      <th colspan="2" >EXPERIENCE LIST</th>
                   
                  </tr>
                </thead>
                <?php
                if(count($experience_list)){
                    $exp_count=0;
                    foreach( $experience_list as $ex_list ):
                        $exp_count++;
                      $ex_list_arr = explode('~', $ex_list);
                      $ekey = $ex_list_arr[0];
                      $evalue = $ex_list_arr[1];
                      $idf = $partnerdata['data']['internal_id'];
                      $partner_item_current = $idf.'~~~'.$ekey.'~~~'.$evalue;
                ?>
                <tbody class="part_list_td">  
                <table class="table-borderless inner_part_table">
                    <tr class="voucher_list_table_mob_tr" data-toggle="collapse" data-target="#demo_<?=$exp_count?>">
                         <td class="v_td_a"  colspan="2"><?=$evalue?></td>  
                    </tr>
               
                    <?php 
                        if(count($boxes)){
                            foreach( $boxes as $headers ):
                                $box_exps = json_decode($headers['partners'], true);
                                if(in_array($partner_item_current, $box_exps)){
                    ?>
                    
                                <tr class="voucher_list_table_mob_tr">
                                    <td class="v_td_a"><?=strtoupper($headers['name'])?></td>  <td>
                                        <img src="../shared/img/icn-tick-teal.svg" class="exper_tick"/>
                                    </td>
                                </tr>
                               <?php 
                                }else{ ?>
                                    <tr class="voucher_list_table_mob_tr">
                                    <td class="v_td_a"><?=strtoupper($headers['name'])?></td>  <td>
                                        
                                    </td>
                                </tr>
                                <?php }?>
                                
                    <?php 
                    endforeach;
                     } 
                     ?>
                                </table>
                </tbody>
                
                <?php 
                    endforeach;
                }
                ?>
             </table>
  
       
  
        </div>
           
                     </div></div>
              </div>
            </section>
        <?php  include '../shared/partials/loggedin-footer.php';?>
          <!-- Page Content -->

          <!-- Bootstrap core JavaScript -->
          
        <?php include '../shared/partials/js.php';?>
   
  
 
 

</body>

</html>
