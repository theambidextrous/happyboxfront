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

  <title>HappyBox :: Home</title>

  <!-- Bootstrap core CSS -->
 <?php include 'shared/partials/css.php'; ?>
 


</head>

<body>

  <!-- Navigation -->
 <?php include 'shared/partials/nav.php'; ?>

  <!-- Page Content -->
  <div class="container-fluid">
      <div class="slider_overlay"></div>
    <div class="row">
     <div id="demo" class="carousel slide carousel-fade home_slider" data-ride="carousel">
  <ul class="carousel-indicators">
    <li data-target="#demo" data-slide-to="0" class="active"></li>
    <li data-target="#demo" data-slide-to="1"></li>
    <li data-target="#demo" data-slide-to="2"></li>
  </ul>
  <div class="carousel-inner">
    <div class="carousel-item active slider_1">
        <img src="shared/img/slidera.jpg" alt="slider 1" class="w-100">
      <div class="carousel-caption carousel-header">
          <div class="container">
              <div class="row justify-content-end">
                   <div class="col-md-6 ">
                       <h2 class="text-right"><img src="shared/img/slider1header.svg" class="slider_1_1_img"></h2>
          <div class="slider_header_1 ">
              HAPPYBOX offers you the unique opportunity to find a gift which fits all tastes. 
              The recipient has the option of choosing a tailored experience from a multitude of exclusive activities.<br> From relaxing spas, energising yoga classes and gastronomic delights to exhilarating sports and adventure experiences, HAPPYBOX has it all!
              
          </div>
                       <p class="slider_header_p text-right"> <span class="span1">Choose the perfect gift,<br>Choose</span><span class="span2"> HAPPYBOX</span></p>
                       
                  
              </div>
         
      </div>    </div>   
    </div>
           

   
  </div>
      <!-- 2-->
     <div class="carousel-item slider_2">
          <img src="shared/img/hb-slider-02.png" alt="slider 2" class="w-100">
      <div class="carousel-caption carousel-header">
          <div class="container">
              <div class="row ">
                   <div class="col-md-6 ">
                       <h2 class="text-left"><img src="shared/img/slider2_top.svg" class="slider_2_2_img"></h2>
          <div class="slider_header_2">
              <p>
 A HAPPYBOX is the gift of choice! It's a means of giving the unique gift of opportunity, allowing the recipient to decide on what type of experience they would most enjoy!                 
              </p> 
              <p>
   This perfect gift consists of:               
              </p>
              <ul>
                  <li><img src="shared/img/icons/icn-tick-pink.svg"> A colourful giftbox </li>    
                  <li><img src="shared/img/icons/icn-tick-yellow.svg"> A comprehensive booklet of carefully selected activities on offer</li>  
                  <li><img src="shared/img/icons/icn-tick-green.svg"> Partners contact details</li>  
                  <li><img src="shared/img/icons/icn-tick-orange.svg"> Partners contact details</li>  
              </ul>
          </div>
                       <p class="slider_header_p2 text-right"> <span class="span1 slider_pink_txt">Choose the perfect gift,<br>Choose</span><span class="span2 slider_green"> HAPPYBOX</span></p>
                       
                  
              </div>
         
      </div>    </div>   
    </div>
           

   
  </div>
     <div class="carousel-item slider_1">
         <img src="shared/img/slider3.jpg" alt="slider 1" class="w-100">
      <div class="carousel-caption carousel-header">
          <div class="container">
              <div class="row justify-content-end">
                   <div class="col-md-6 ">
                       <h2 class="text-right">
                           <a href=""  class="btn btn-slider-3">Make your gift digital, with our e-boxes</a>    
                       </h2>
          <div class="slider_header_1">
              <p>
       Give your HAPPYBOX gift over email! Sit back, relax and make your gift selection on our website. You will have the option to choose an e-box which will deliver your gift via email to your chosen recipient. Easy!           
              </p>
              <p>
 This perfect gift consists of:                 
              </p>
             
              <ul class="slider_3ul">
                  <li><img src="shared/img/icons/icn-tick-yellow.svg"> A PDF booklet of carefully selected activities on offer</li>
                  <li><img src="shared/img/icons/icn-tick-green.svg"> Partners contact details</li>
                  <li><img src="shared/img/icons/icn-tick-orange.svg"> Your unique e-voucher code for booking your selected experience</li>
                      
              </ul>
          </div>
                       <p class="slider_header_p3 text-right"> <span class="span1">Choose the perfect gift,<br>Choose</span><span class="span2"> HAPPYBOX</span></p>
                       
                  
              </div>
         
      </div>    </div>   
    </div>
           

   
  </div>

</div>
    </div>
  </div>
  </div>
  <!--section below slider-->
  
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
 <section class="container section_padding_top">
      <div class="row">
          <div class="col-md-6">
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
             <div class="col-md-6">
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
      </div>
      </section>
<!--end add to cart cards-->
<section class="container-fluid iwant_section">
      <div class="row">
      
             <div class="col-md-12">
                 <img src="shared/img/iwant_layer.svg" class="iwant_img">
             
             
          </div>
          
      </div>
        <div class="container">
      <div class="row justify-content-between iwant_card_row">
      
             <div class="col-md-3 iwant_card">
                <div class="step_box step_color1">1</div>
                  
                
                 <p class="iwant_card_p"> Select a HappyBox according to your budget</p>
                 <p class="iwant_card_bar iwant_card_bar step_color1"> </p>
            
             
          </div>  <div class="col-md-3 iwant_card no_radius">
                   <div class="step_box step_color2">2</div>
                 <p class="iwant_card_p"> Log in or create an account</p>
                 <p class="iwant_card_bar iwant_card_bar step_color2"> </p>
            
             
          </div>
           
          <div class="col-md-3 iwant_card no_radius">
                   <div class="step_box step_color3">3</div>
              <p class="iwant_card_p"> Choose your delivery date and mode <br>
                  <span class="thin_font">(doorstep or e-box)</span>
              
              </p>
                 <p class="iwant_card_bar iwant_card_bar step_color3"> </p>
            
             
          </div>
          <div class="col-md-3 iwant_card iwant_card_last">
                   <div class="step_box step_color4">4</div>
                 <p class="iwant_card_p"> Make payment using A credit card or Mpesa</p>
                 <p class="iwant_card_bar iwant_card_bar step_color4"> </p>
            
             
          </div>
         
          
          
      </div>    </div>
    <div class="container">
        <div class="row">
             <!--congratulate yourself-->
          <div class="col-md-12 congratulate text-center section_margin_top">
              <p class="p1">Congratulate yourself …</p>
              <p class="p2"><b>On selecting a tailored gift experience packed with a multitude of unique options and exclusive deals to choose from!</b></p>
          </div>
        </div>
    </div>
      </section>
<!--end I want section-->
<!--start I want section-->
<section class="container section_padding_top why_happy">
        <div class="row">
      
             <div class="col-md-12">
                 <img src="shared/img/whyhappy.svg" class="why_img">
             
             
          </div>
          
      </div>
    <div class="row why_happy_card_row">
      
             <div class="col-md-3">
                 
                 <div class="card why_happy_card why_happy_card_client">
                     <div class="card-header">
                         
                         
                     </div>
                     <div class="card-body why_happy_card_body text-center">
                         
                         <img src="shared/img/icons/icn-kenyan-flag.svg"/>
                         <p>
                             Proudly 100% Kenyan
                         </p>
                         
                     </div>
                     
                 </div>
             
          </div>
          <div class="col-md-3">
                 
                 <div class="card why_happy_card why_happy_card_client">
                     <div class="card-header">
                         
                         
                     </div>
                     <div class="card-body why_happy_card_body text-center">
                         
                         <img src="shared/img/icons/icn-large-choice.svg"/>
                         <p>
                          A large choice of activities in each box
                         </p>
                         
                     </div>
                     
                 </div>
             
          </div>
          <div class="col-md-3">
                 
                 <div class="card why_happy_card why_happy_card_client">
                     <div class="card-header">
                         
                         
                     </div>
                     <div class="card-body why_happy_card_body text-center">
                         
                         <img src="shared/img/icons/icn-warranty.svg">
                         <p>
                             Loss & theft warranty
                         </p>
                         
                     </div>
                     
                 </div>
             
          </div>
          <div class="col-md-3">                 
                 <div class="card why_happy_card why_happy_card_client">
                     <div class="card-header">                       
                         
                     </div>
                     <div class="card-body why_happy_card_body text-center">
                         
                         <img src="shared/img/icons/icn-evaluate.svg"/>
                         <p>
                        Experiences are regularly evaluated and updated on our website
                         </p>
                         
                     </div>
                     
                 </div>
             
          </div>
          
      </div>
</section>
       <?php include 'shared/partials/partners.php';?>
      <?php include 'shared/partials/footer.php';?>
  
  <!-- Bootstrap core JavaScript -->
  
<?php include 'shared/partials/js.php';?>
   
  
 
 

</body>

</html>
