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
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

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

<body>
  <!-- Navigation -->
 <?php include '../shared/partials/nav-logged-in.php'; ?>
 
<section class="partner_voucher_list section_60">
           <div class="container">
             <div class="row justify-content-center forgot-dialogue-wrap">
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
                      <thead>
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
                          foreach( $experience_list as $ekey => $evalue):
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
              </div>
            </section>
        <?php include '../shared/partials/loggedin-footer.php';?>
          <!-- Page Content -->

          <!-- Bootstrap core JavaScript -->
          
        <?php include '../shared/partials/js.php';?>
   
  
 
 

</body>

</html>
