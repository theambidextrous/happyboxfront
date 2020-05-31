<?php
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
$util = new Util();
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Happy Box:: Category Booklet Pop Up</title>

  <!-- Bootstrap core CSS -->
 <?php include 'shared/partials/css.php'; ?>
</head>

<body>
  <!-- Navigation -->
 <?php include 'shared/partials/nav.php'; ?>
  <!-- Page Content --> 
  <!--start well being banner-->
  <section class="well_banner">
      <div class="container">
      <div class="row justify-content-end">
          <div class="col-md-5 text-md-right">
           
             
              <div class="well_banner_title">
                  <h3>      Need to disconnect and recharge?</h3>
            
              </div>
              <p class="well_banner_p text-white text-center">
                  Discover our exclusive selection of dream spas, relaxing beauty treatments and yoga classes, guaranteed to leave you feeling calm, restored and revitalised.
              </p>
              <div class="well_scroll text-center">
      <img class="" src="shared/img/icn-arrow-yellow.svg">
         </div>
              
             
          </div>
          
      </div></div>
      </section>
    <!--end well being banner-->
    
  
  <section class="container section_padding_top">
      <div class="row">
          <div class="col-md-12 text-center">
              <a href="" class="btn btn-block btn-bordered">
                  Discover Our Selection
              </a>
          </div>
          
      </div>
      </section>
<!--end discover our selection-->
 <section class="container section_padding_top cat_well">
      <div class="row">
          <div class="col-md-4">
             <div class="card selection_card">
                  <div class="card-header">
                      <img src="shared/img/hb-box-03@2x.png" class="autoimg">
            
          </div>
                    <div class="card-body selection_card_body text-center">
                        <h4 class="box_title">Box Name One</h4>
                        <p>
    Lorem Ipsum is simply dummy text of the printing and typesetting industry.                        
                        </p>
                        
                        
            
          </div>
                 
            
          </div>
              <div class="cart_bar text-white">
                  <div class="cart_bar_strip">
                      <span class="pricing">
                         KES 20 000.00
                      </span>
                           <img src="shared/img/cart_client_strip.svg" class="width_100 add_to_cart">
                          
                      </div>
                
              </div>
          </div>
             <div class="col-md-4">
             <div class="card selection_card">
                  <div class="card-header">
                      <img src="shared/img/hb-box-03@2x.png" class="autoimg">
            
          </div>
                    <div class="card-body selection_card_body text-center">
                        <h4 class="box_title">Box Name Three</h4>
                        <p>
    Lorem Ipsum is simply dummy text of the printing and typesetting industry.                        
                        </p>
            
          </div>
                 
            
          </div>
            <div class="cart_bar text-white">
                  <div class="cart_bar_strip">
                      <span class="pricing">
                         KES 20 000.00
                      </span>
                           <img src="shared/img/cart_client_strip.svg" class="width_100 add_to_cart">
                          
                      </div>
                
              </div>
        
          
      </div>
           <div class="col-md-4">
             <div class="card selection_card">
                  <div class="card-header">
                      <img src="shared/img/hb-box-03@2x.png" class="autoimg">
            
          </div>
                    <div class="card-body selection_card_body text-center">
                        <h4 class="box_title">Box Name Two</h4>
                        <p>
    Lorem Ipsum is simply dummy text of the printing and typesetting industry.                        
                        </p>
            
          </div>
                 
            
          </div>
            <div class="cart_bar text-white">
                  <div class="cart_bar_strip">
                      <span class="pricing">
                         KES 20 000.00
                      </span>
                           <img src="shared/img/cart_client_strip.svg" class="width_100 add_to_cart">
                          
                      </div>
                
              </div>
        
          
      </div>
      </section>
<!--end add to cart cards-->
<!--our partners -->
<section class="wellbeing_partners">
       <div class="container">
           <div class="row">
           <div class="col-md-12">
               <a class="btn_partners btn-block" >OUR WELL-BEING PARTNERS</a>
               
           </div>  </div>
            <div class="row row_partner">
           <div class="col-md-3">
               <div class="partner_logo">
                   <spa>Picture: Partner #1</spa>
                   
               </div>
               
           </div> 
             <div class="col-md-9">
                 <div class="table-responsive">
                      <div class="table_radius">
                     <table class="cat_well_table table table-bordered">
                         <tr>
                              <td class="td_cat_a">
                                 <table>
                                     <tr><td class="inner_td_gray"><h6>SPA CLEOPATRA</h6></td></tr>
                                        <tr><td class="inner_light_blue"><h6 >  NAIROBI | KAREN</h6></td></tr>
                                 </table>
                                 
                               
                                 
                             </td>
                               <td>
                                   <h4>Spa & Beauty Treatments</h4>
                                   <p class="cat_p">
                                                                  The Spa Cleopatra captures the serenity of the region with its nature-inspired massage, skincare and beauty treatments. Our Highly trained therapists are committed to ensuring each guest is treated as an individual. Each treatment is designed to bring balance and harmony to the body leaving you feeling revitalized and refreshed.
        
                                   </p>
                                   <p class="text-right rating_bar">
                                       <img src="shared/img/icons/yellow_star.svg" class="">      
                                         <img src="shared/img/icons/yellow_star.svg" class="">  
                                           <img src="shared/img/icons/yellow_star.svg" class="">
                                             <img src="shared/img/icons/yellow_star.svg" class=""> 
                                               <img src="shared/img/icons/yellow_star.svg" class="">  
                                   </p>
                             </td>
                         </tr>
                     
                 </table>
                    </div>  
                     
                 </div>
               
           </div></div>
           <!--2-->
           <div class="row row_partner">
           <div class="col-md-3">
               <div class="partner_logo">
                   <spa>Picture: Partner #1</spa>
                   
               </div>
               
           </div> 
             <div class="col-md-9">
                 <div class="table-responsive">
                      <div class="table_radius">
                       <table class="cat_well_table table table-bordered">
                         <tr>
                              <td class="td_cat_a">
                                 <table>
                                     <tr><td class="inner_td_gray"><h6>SPA CLEOPATRA</h6></td></tr>
                                        <tr><td class="inner_light_blue"><h6 >  NAIROBI | KAREN</h6></td></tr>
                                 </table>
                                 
                               
                                 
                             </td>
                               <td>
                                   <h4>Spa & Beauty Treatments</h4>
                                   <p class="cat_p">
                                                                  The Spa Cleopatra captures the serenity of the region with its nature-inspired massage, skincare and beauty treatments. Our Highly trained therapists are committed to ensuring each guest is treated as an individual. Each treatment is designed to bring balance and harmony to the body leaving you feeling revitalized and refreshed.
        
                                   </p><p class="text-right rating_bar">
                                       <img src="shared/img/icons/yellow_star.svg" class="">      
                                         <img src="shared/img/icons/yellow_star.svg" class="">  
                                           <img src="shared/img/icons/yellow_star.svg" class="">
                                             <img src="shared/img/icons/yellow_star.svg" class=""> 
                                               <img src="shared/img/icons/yellow_star.svg" class="">  
                                   </p>
                             </td>
                         </tr>
                     
                 </table>
                    </div>  
                     
                 </div>
               
           </div></div>
           
           <!--3-->
           <div class="row row_partner">
           <div class="col-md-3">
               <div class="partner_logo">
                   <spa>Picture: Partner #1</spa>
                   
               </div>
               
           </div> 
             <div class="col-md-9">
                 <div class="table-responsive">
                      <div class="table_radius">
                       <table class="cat_well_table table table-bordered">
                         <tr>
                              <td class="td_cat_a">
                                 <table>
                                     <tr><td class="inner_td_gray"><h6>SPA CLEOPATRA</h6></td></tr>
                                        <tr><td class="inner_light_blue"><h6 >  NAIROBI | KAREN</h6></td></tr>
                                 </table>
                                 
                               
                                 
                             </td>
                               <td>
                                   <h4>Spa & Beauty Treatments</h4>
                              <p class="cat_p">
                                                                  The Spa Cleopatra captures the serenity of the region with its nature-inspired massage, skincare and beauty treatments. Our Highly trained therapists are committed to ensuring each guest is treated as an individual. Each treatment is designed to bring balance and harmony to the body leaving you feeling revitalized and refreshed.
        
                                   </p> <p class="text-right rating_bar">
                                       <img src="shared/img/icons/yellow_star.svg" class="">      
                                         <img src="shared/img/icons/yellow_star.svg" class="">  
                                           <img src="shared/img/icons/yellow_star.svg" class="">
                                             <img src="shared/img/icons/yellow_star.svg" class=""> 
                                               <img src="shared/img/icons/yellow_star.svg" class="">  
                                   </p>
                             </td>
                         </tr>
                     
                 </table>
                    </div>  
                     
                 </div>
               
           </div></div>
                     
                      </div>
    
</section>



       <?php include 'shared/partials/partners.php';?>
      <?php include 'shared/partials/footer.php';?>
  
  <!-- Bootstrap core JavaScript -->
  
<?php include 'shared/partials/js.php';?>
   
  <!-- Bootstrap core JavaScript -->
  
<?php include 'shared/partials/js.php';?>
   <!-- pop up -->
  <div class="modal fade" id="topicBookletPop">
    <div class="modal-dialog general_pop_dialogue booklet_dialogue">
      <div class="modal-content">
   
                       <div class="modal-body">
                           <div class="row">
                                       <div class="col-md-8">
				
                       <div id="modalSlider" class="carousel slide" data-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
    <img class="d-block w-100" src="shared/img/modal_slide_img.jpg" alt="Second slide">
     <div class="carousel-caption">
      <p>Box Specific Booklet</p>
  
  </div>
    </div>
    <div class="carousel-item">
        <img class="d-block w-100" src="shared/img/modal_slide_img.jpg" alt="Second slide">
         <div class="carousel-caption">

   <p>Box Specific Booklet</p>
  </div>
    </div>
  
  </div>
  <a class="carousel-control-prev" href="#modalSlider" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#modalSlider" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
                        </div>
                            <div class="col-md-4 blue_border_left">
                                <a href="" data-dismiss="modal"> <img class="modal_close" src="shared/img/icons/icn-close-window-blue.svg"></a>
                                <div class="modal_parent">
                                            <div class="modal_child text-center">
                                                <h6>  Box Name Three</h6>
                                                <br>
                                                <a href="" class="bold_txt pink_bg btn text-white">KES 20 000.00</a>
                                                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
                                                <div>
                                                     <img class="" src="shared/img/icons/btn-add-to-cart-small-red-teal.svg">
                                                    
                                                </div>
                                            </div>
                                </div>
                               
				
                       
                        </div>
                           </div>
            
                           
      </div>
        
      </div>
    </div>
  </div>
   <script>
    $(document).ready(function(){
        $("#topicBookletPop").modal('show');
    });
</script>
<!-- end pop up -->
 
 

</body>

</html>
