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

  <title>Happy Box:: Home</title>

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
        <img src="<?=$util->ClientHome()?>/shared/img/slider-a.png" class="w-100">           
  </div>
      <!-- 2-->
     <div class="carousel-item slider_2">
         <img src="<?=$util->ClientHome()?>/shared/img/slider-b.png" alt="slider 2" class="w-100">     
</div>
     <div class="carousel-item slider_1">
         <img src="<?=$util->ClientHome()?>/shared/img/slider-c.png" alt="slider 3" class="w-100"> 
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
                    <img src="<?=$util->ClientHome()?>/shared/img/hb-box-03@2x.png" class="autoimg">
                  </div>
                  <div class="card-body selection_card_body text-center">
                    <h4 class="box_title"><a data-toggle="modal" href="#bookletPop">Box Name One</a></h4>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                  </div>
                </div>
              <div class="cart_bar text-white">
                  <div class="cart_bar_strip">
                      <span class="pricing">
                         KES 20 000.00
                      </span>
                           <img src="<?=$util->ClientHome()?>/shared/img/cart_client_strip.svg" class="width_100 add_to_cart" data-toggle="modal" data-target="#addedToCart">
                          
                      </div>
                
              </div>
          </div>
             <div class="col-md-6">
             <div class="card selection_card">
                  <div class="card-header">
                      <img src="<?=$util->ClientHome()?>/shared/img/hb-box-03@2x.png" class="autoimg">
            
          </div>
                    <div class="card-body selection_card_body text-center">
                        <h4 class="box_title"><a data-toggle="modal" href="#bookletPop">Box Name Two</a></h4>
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
                     
                           <img src="<?=$util->ClientHome()?>/shared/img/cart_client_strip.svg" data-toggle="modal" data-target="#addedToCart" class="width_100 add_to_cart">
                          
                      </div>
                
              </div>
        
          
      </div>
      </div>
      </section>
<!--end add to cart cards-->
<section class=" iwant_section">
      <div class="container">
    <div class="row">
      
             <div class="col-md-12">
                 <img src="<?=$util->ClientHome()?>/shared/img/iwant_layer.svg" class="iwant_img">
             
             
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
                 <img src="<?=$util->ClientHome()?>/shared/img/whyhappy.svg" class="why_img">
             
             
          </div>
          
      </div>
    <div class="row why_happy_card_row">
      
             <div class="col-md-3">
                 
                 <div class="card why_happy_card why_happy_card_client">
                     <div class="card-header">
                         
                         
                     </div>
                     <div class="card-body why_happy_card_body text-center">
                         
                         <img src="<?=$util->ClientHome()?>/shared/img/icons/icn-kenyan-flag.svg"/>
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
                         
                         <img src="<?=$util->ClientHome()?>/shared/img/icons/icn-large-choice.svg"/>
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
                         
                         <img src="<?=$util->ClientHome()?>/shared/img/icons/icn-warranty.svg">
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
                         
                         <img src="<?=$util->ClientHome()?>/shared/img/icons/icn-evaluate.svg"/>
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
                                <a href="" data-dismiss="modal"> <img class="modal_close" src="<?=$util->ClientHome()?>/shared/img/icons/icn-close-window-blue.svg"></a>
                                <div class="modal_parent">
                                            <div class="modal_child text-center">
                                                <h6>  Box Name Three</h6>
                                                <br>
                                                <a href="" class="bold_txt pink_bg btn text-white">KES 20 000.00</a>
                                                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
                                                <div>
                                                     <img class="" src="<?=$util->ClientHome()?>/shared/img/icons/btn-add-to-cart-small-red-teal.svg">
                                                    
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
    <div class="modal-dialog general_pop_dialogue added_tocart_dialogue ">
        	
              
      <div class="modal-content">
   <a href="" data-dismiss="modal"> <img class="modal_close2" src="<?=$util->ClientHome()?>/shared/img/icons/icn-close-window-blue.svg"></a> 
                       <div class="modal-body text-center">
                    <div class="col-md-12 text-center">
                        <h3>THIS BOX HAS BEEN ADDED TO YOUR CART</h3>   
                        <div class="action_btns" >
                            <a href="" > <img class="" src="<?=$util->ClientHome()?>/shared/img/btn-continue-shopping.svg"></a> 
                            <a href=""> <img class="" src="<?=$util->ClientHome()?>/shared/img/btn-checkout.svg"></a> 
                        </div>
                       
                        </div>
      </div>
        
      </div>
    </div>
  </div>
 
<!--added to cart  end pop up -->
  <script type="text/javascript">

   $(document).bind('keyup', function(e) {
        if(e.which == 39){
            $('.carousel').carousel('next');
        }
        else if(e.which == 37){
            $('.carousel').carousel('prev');
        }
    });

</script>
   
  
 
 

</body>

</html>
