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

        <title>Happy Box:: Admin Voucher Search Result</title>

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
        <section class="voucher_search text-center ">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6 section_title">
                        <h4 class="voucher_title">VOUCHER QUICK SEARCH </h4>
                        <p class="p_search">Looking for a specific voucher code? Enter the number to check it’s validity.</p>
                                    <form class="voucher_search_form">
  <div class="form-group row">
    
    <div class="col-md-9">
        <span class="search_glass"><i class="fas fa-search"></i></span>
        <input type="text" name="voucher_search" class="form-control voucher_search_input" placeholder="Enter voucher code here">
    </div>
      <div class="col-md-3">
          <button type="submit" class="btn btn_search_v btn-block">SEARCH</button> 
      </div>
  </div>
                                    </form>
                    </div>
                   
                    

                </div>
                 <div class="row">
                     <div class="voucher_result_bar">
                     <div class="voucher_no">
                         VOUCHER NUMBER
                     </div> 
                     <div class="voucher_no_value ">
                         QWERTY0125
                     </div>
                     <div class="voucher_status">
                         STATUS
                     </div>
                     <div class="voucher_status_value">
                         VALID
                     </div>
                     <div class="voucher_partner">
                         PARTNER
                     </div>
                     <div class="voucher_partner_val col-md-3 border_right">
                      CLEOPATRA SPA
                     </div>
                     <div class="voucher_partner2 col-md-3">
                         BOX TWO | SPA EXPERIENCE
                     </div>
                         </div>
                        
                    </div>
            </div>
        </section>
      
        





 <?php include 'admin-partials/footer.php'; ?>      

        <?php include 'admin-partials/js.php'; ?>





    </body>

</html>
