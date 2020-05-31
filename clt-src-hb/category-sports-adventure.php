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

  <title>Happy Box:: Category Sports Adventure</title>

  <!-- Bootstrap core CSS -->
 <?php include 'shared/partials/css.php'; ?>
</head>

<body>
  <!-- Navigation -->
 <?php include 'shared/partials/nav.php'; ?>
  <!-- Page Content --> 
  <!--start well being banner-->
  <section class="  sports_banner">
      <div class="container">
      <div class="row justify-content-end">
          <div class="col-md-5 text-md-right">
           
             
               <div class="sports_banner_title">
                       <h3>  
               For the thrill seekers
                       </h3>
              </div>
              <p class="text-white sports_banner_p text-center">
                  Are you ready to get your adrenaline pumping?<br> <br>
                  Choose from our exhilarating selection of sports and adventure experiences, guaranteed to satisfy anyone looking for an exciting energy boost.<br><br> For those wishing to stay in shape, let experienced professionals guide you in enjoyable & effective workouts.</p>
              <div class="well_scroll text-center">
                  <img class="" src="shared/img/icons/icn-arrow-pink.svg">
         </div>
              
             
          </div>
          
      </div> </div>
      </section>
    <!--end well being banner-->
    

<!--end discover our selection-->
 <section class="container section_padding_top cat_well">
      <div class="row">
          <div class="col-md-4">
             
             <div class="card selection_card sports_card">
                  <div class="sport_card_hover" data-toggle="modal" data-target="#bookletPop">
                  
                  <img src="shared/img/icons/magnifyglass.svg"/>
              </div>
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
                           <img src="shared/img/cart_client_strip.svg" data-toggle="modal" data-target="#addedToCart" class="width_100 add_to_cart">
                          
                      </div>
                
              </div>
          </div>
             <div class="col-md-4">
            <div class="card selection_card sports_card">
                  <div class="sport_card_hover" data-toggle="modal" data-target="#bookletPop">
                  
                  <img src="shared/img/icons/magnifyglass.svg"/>
              </div>
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
                           <img src="shared/img/cart_client_strip.svg" class="width_100 add_to_cart" data-toggle="modal" data-target="#addedToCart">
                          
                      </div>
                
              </div>
        
          
      </div>
           <div class="col-md-4">
              <div class="card selection_card sports_card">
                  <div class="sport_card_hover" data-toggle="modal" data-target="#bookletPop">
                  
                  <img src="shared/img/icons/magnifyglass.svg"/>
              </div>
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
                           <img src="shared/img/cart_client_strip.svg" class="width_100 add_to_cart" data-toggle="modal" data-target="#addedToCart">
                          
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
               <a class="btn_sports btn-block" >OUR SPORTS & ADVENTURE PARTNERS</a>
               
           </div>  </div>
            <div class="row row_partner">
           <div class="col-md-3">
               <div class="partner_logo sports_partner_logo">   <div class="partner_logo_in">  
                   <spa>Picture: Partner #1</spa>
                   </div>
               </div>
               
           </div> 
             <div class="col-md-9">
                 <div class="table-responsive">
                      <div class="table_radius">
                     <table class="cat_well_table table table-bordered">
                         <tr>
                              <td class="td_cat_a">
                                 <table>
                                     <tr><td class="inner_td_gray"><h6>URBAN GYM</h6></td></tr>
                                        <tr><td class="inner_light_blue"><h6 >  NAIROBI | KAREN</h6></td></tr>
                                 </table>
                                 
                               
                                 
                             </td>
                               <td>
                                       <h4>Partner / Experience Description</h4>
                                     <p class="cat_p">
                             Established in 1997, URBAN GYM is a 100% Kenyan owned and operated company. Our clients are guaranteed a fun and effective workout guided by experts.            
                                  </p>
                                   <p class="text-right rating_bar">
                                       <img src="shared/img/icons/icn-star-pink.svg" class="">      
                                          <img src="shared/img/icons/icn-star-pink.svg" class="">  
  <img src="shared/img/icons/icn-star-pink.svg" class="">  
                                            <img src="shared/img/icons/icn-star-pink.svg" class="">  
                                            <img src="shared/img/icons/icn-blank-star-pink.svg" class="">  
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
               <div class="partner_logo sports_partner_logo">
                      <div class="partner_logo_in">  
                   <spa>Picture: Partner #1</spa>
                      </div>
               </div>
               
           </div> 
             <div class="col-md-9">
                 <div class="table-responsive">
                      <div class="table_radius">
                     <table class="cat_well_table table table-bordered">
                         <tr>
                              <td class="td_cat_a">
                                 <table>
                                     <tr><td class="inner_td_gray"><h6>URBAN GYM</h6></td></tr>
                                        <tr><td class="inner_light_blue"><h6 >  NAIROBI | KAREN</h6></td></tr>
                                 </table>
                                 
                               
                                 
                             </td>
                               <td>
                                   <h4>Partner / Experience Description</h4>
                                   <p class="cat_p">
                             Established in 1997, URBAN GYM is a 100% Kenyan owned and operated company. Our clients are guaranteed a fun and effective workout guided by experts.            
                                  </p>   <p class="text-right rating_bar">
                                       <img src="shared/img/icons/icn-star-pink.svg" class="">      
                                          <img src="shared/img/icons/icn-star-pink.svg" class="">  
  <img src="shared/img/icons/icn-star-pink.svg" class="">  
   <img src="shared/img/icons/icn-star-pink.svg" class="">  
                                            <img src="shared/img/icons/icn-half-star-pink.svg" class="">  
                                            
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
               <div class="partner_logo sports_partner_logo">
                      <div class="partner_logo_in">  
                   <spa>Picture: Partner #1</spa>
                      </div>
                   
               </div>
               
           </div> 
             <div class="col-md-9">
                 <div class="table-responsive">
                      <div class="table_radius">
                     <table class="cat_well_table table table-bordered">
                         <tr>
                              <td class="td_cat_a">
                                 <table>
                                     <tr><td class="inner_td_gray"><h6>URBAN GYM</h6></td></tr>
                                        <tr><td class="inner_light_blue"><h6 >  NAIROBI | KAREN</h6></td></tr>
                                 </table>
                                 
                               
                                 
                             </td>
                               <td>
                                      <h4>Partner / Experience Description</h4>
                                   <p class="cat_p">
                             Established in 1997, URBAN GYM is a 100% Kenyan owned and operated company. Our clients are guaranteed a fun and effective workout guided by experts.            
                                  </p> <p class="text-right rating_bar">
                                         <p class="text-right rating_bar">
                                       <img src="shared/img/icons/icn-star-pink.svg" class="">      
                                          <img src="shared/img/icons/icn-star-pink.svg" class="">  
  <img src="shared/img/icons/icn-star-pink.svg" class="">  
                                            <img src="shared/img/icons/icn-star-pink.svg" class="">  
                                                        <img src="shared/img/icons/icn-star-pink.svg" class="">
                                          
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
    <!-- pop up -->
  <div class="modal fade" id="bookletPop">
    <div class="modal-dialog general_pop_dialogue booklet_dialogue pop_slider">
      <div class="modal-content">
   
                       <div class="modal-body">
                           <div class="row">
                                       <div class="col-md-8 pop_slider_pad">
				
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
                            <div class="col-md-4 blue_border_left pop_slider_pad">
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
  
  <!-- end pop up -->
     <!-- added to cart pop up -->
  <div class="modal fade" id="addedToCart">
    <div class="modal-dialog general_pop_dialogue added_tocart_dialogue">
        	
              
      <div class="modal-content">
   <a href="" data-dismiss="modal"> <img class="modal_close2" src="shared/img/icons/icn-close-window-blue.svg"></a> 
                       <div class="modal-body text-center">
                    <div class="col-md-12 text-center">
                        <h3>THIS BOX HAS BEEN ADDED TO YOUR CART</h3>   
                        <div class="action_btns" >
                            <a href="" > <img class="" src="shared/img/btn-continue-shopping.svg"></a> 
                            <a href=""> <img class="" src="shared/img/btn-checkout.svg"></a> 
                        </div>
                       
                        </div>
      </div>
        
      </div>
    </div>
  </div>
 
<!--added to cart  end pop up -->
 
 

</body>

</html>
