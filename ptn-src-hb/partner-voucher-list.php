<?php
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
$util = new Util();
?>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Happy Box:: Partner Voucher List</title>
  <!-- Bootstrap core CSS -->
 <?php include '../shared/partials/css.php'; ?>

</head>

<body>
  <!-- Navigation -->
 <?php include '../shared/partials/nav-logged-in.php'; ?>
 
<section class="partner_voucher_list section_60">
           <div class="container">
			
               
                    <div class="row justify-content-center forgot-dialogue-wrap">
                     
                       
                    <div class="col-md-12">
					<h3 class="partner_blueh text-center">MY VOUCHER LIST</h3>
                                        <p class="forgot_des text-center">
                    Your list of Redeemed and Cancelled vouchers               
                                        </p>
                                        <div class="table-responsive">
                                            <div class="table_radius"><table class="table  voucher_list_table table-bordered">
                <thead>
                    <tr>
                        <th class="blue_cell_th th_box">BOX NAME</th>
                        <th>VOUCHER CODE</th>
                        <th>STATUS</th>
                        <th class="">CUSTOMER NAME</th>
                        <th>CUSTOMER SURNAME</th>
                        <th>DATE REDEEMED</th>
                        <th>DATE CANCELLED</th>
                        <th>BOOKING DATE</th>
                        <th>PARTNER PAYMENT DATE</th>
                        <th>PARTNER REIMBURSEMENT</th>
                        <th colspan="2" class="th_actions">VOUCHER ADMINISTRATION</th>


                    </tr>
    </thead>
    <tbody>
        <tr>
          <td class="light_blue_cell">
            SPA EXPERIENCE
          </td>
        <td>azerty</td>
        <td class="hap_danger">CANCELLED</td>
         
           <td>Bloggs</td>
            <td>Joe</td>
              <td>06/03/2020</td>
                <td>06/03/2020</td>
                <td class="empty_cell"></td>
                   <td class="empty_cell"></td>
                    <td>Ksh5 000.00</td>
            <td class="empty_cell">
               
                
            </td>
             <td class="empty_cell">
               
                
            </td>
            
      </tr>
      <tr>
          <td class="light_blue_cell">
            SPA EXPERIENCE
          </td>
        <td>qwerty</td>
        <td class="hap_success">REDEEMED</td>
         
           <td>Smith</td>
            <td>Joe</td>
              <td>15/02/2020</td>
                <td class="empty_cell"></td>
                  <td>15/02/2020</td>
                   <td>31/03/2020</td>
                    <td>31/03/2020</td>
                    <td class="hap_danger">
                                        <!-- <div class="btn btn-primary tooltip">Hover Me to Preview
    <div class="top">
        <h3>Lorem Ipsum</h3>
        <p>Dolor sit amet, consectetur adipiscing elit.</p>
        <i></i>
    </div>
</div>-->  
              
              <a href="#" class="text-white" data-toggle="tooltip" data-placement="top" title="Hooray!">CANCEL VOUCHER </a>  
            </td>
                <td class="hap_primary">
                    
                    MODIFY DATE  <a href=""><img src="../shared/img/icons/icn-edit-teal.svg" class="td_edit_img"/></a>  
           
                
            </td>
            
      </tr>
      
  
     
    </tbody>
  </table>
                                                </div>
                </div> 
                                        <p class="text-center pad_top20">
                                            
                                           
                                             <button type="submit" class="btn btn_rounded btn-dark-blue btn-sm"> SAVE MY CHANGES</button>
                                        </p>
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
