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
                                        <p class="forgot_des text-center">
                    Your list of experiences offered.           
                                        </p>
                                        <div class="table-responsive">  <div class="table_radius"> <table class="table  experience_list_table table-bordered">
                <thead>
                    <tr>
                        <th class="blue_cell_th th_box">EXPERIENCE LIST</th>
                        <th>BOX NAME</th>
                        <th>BOX NAME</th>
                        <th >BOX NAME</th>
                        <th>BOX NAME</th>
                        <th>BOX NAME</th>
                         <th>BOX NAME</th>
               
                        

                    </tr>
    </thead>
    <tbody>
        <tr>
            <td>
            Hot-Stone Massage , Body-Scrub & Pedicure     
            </td>

        <td><img src="../shared/img/icons/icn-tick-teal.svg" class="experience_list_tick"/> </td>
          <td><img src="../shared/img/icons/icn-tick-teal.svg" class="experience_list_tick"/></td>
        <td class=""></td>
           <td><img src="../shared/img/icons/icn-tick-teal.svg" class="experience_list_tick"/></td>
            <td class=""></td>
             <td><img src="../shared/img/icons/icn-tick-teal.svg" class="experience_list_tick"/></td>          
            
      </tr>
       <tr>
            <td>
            Aromatherapy Massage, Body-Scrub & Manicure    
            </td>

        <td><img src="../shared/img/icons/icn-tick-teal.svg" class="experience_list_tick"/></td>
          <td></td>
        <td class=""><img src="../shared/img/icons/icn-tick-teal.svg" class="experience_list_tick"/></td>
           <td></td>
            <td class=""><img src="../shared/img/icons/icn-tick-teal.svg" class="experience_list_tick"/></td>
             <td><img src="../shared/img/icons/icn-tick-teal.svg" class="experience_list_tick"/></td>          
            
      </tr>
       <tr>
            <td>
           Moroccan Bath , Swedish Massage & Manicure, Pedicure  
            </td>

        <td></td>
          <td><img src="../shared/img/icons/icn-tick-teal.svg" class="experience_list_tick"/></td>
        <td class=""></td>
           <td><img src="../shared/img/icons/icn-tick-teal.svg" class="experience_list_tick"/></td>
            <td class=""><img src="../shared/img/icons/icn-tick-teal.svg" class="experience_list_tick"/></td>
             <td></td>          
            
      </tr>
       <tr>
            <td>
           Deep Tissue Massage & Deep Cleansing Facial    
            </td>

        <td><img src="../shared/img/icons/icn-tick-teal.svg" class="experience_list_tick"/></td>
          <td></td>
        <td class=""></td>
           <td><img src="../shared/img/icons/icn-tick-teal.svg" class="experience_list_tick"/></td>
            <td class=""><img src="../shared/img/icons/icn-tick-teal.svg" class="experience_list_tick"/></td>
             <td><img src="../shared/img/icons/icn-tick-teal.svg" class="experience_list_tick"/></td>          
            
      </tr>
      
      
  
     
    </tbody>
  </table> </div> 
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
