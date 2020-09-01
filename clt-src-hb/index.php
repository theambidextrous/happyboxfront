<?php
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
require_once('../lib/Box.php');
require_once('../lib/Picture.php');
require_once('../lib/Inventory.php');
$util = new Util();
$user = new User();
$box = new Box();
$picture = new Picture();
$inventory = new Inventory();
$util->ShowErrors(1);
$_all_boxes = json_decode($box->get_all_active('0'), true)['data'];
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
  <div class="container-fluid desktop_view">
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
  <!--start mobile slider-->
  <div class="container-fluid mobile_view">
      <div class="slider_overlay"></div>
    <div class="row">
     <div id="demo" class="carousel slide carousel-fade home_slider" data-ride="carousel">
 
  <div class="carousel-inner">
    <div class="carousel-item active slider_1">
           <div class="mob_cta text-center">   
   <img src="shared/img/slider_reg.svg" class="">
  </div>
        <img src="shared/img/mob_slider1.jpg" class="w-100">    
           <div class="mob_sli_des text-center"> 
               
                  <img src="shared/img/mob_sli_des.svg" class="mob_sli_des_1">
                  <p>
                      HAPPYBOX offers you the unique opportunity to find a gift which fits all tastes. 
                      The recipient has the option of choosing a tailored experience from a multitude of exclusive activities.</p><p> From relaxing spas, energising yoga classes and gastronomic delights to exhilarating sports and adventure experiences, HAPPYBOX has it all!
                  </p>
                  <img src="shared/img/mob_sli_discover.svg" class="">
 
  </div>
     

   
  </div>
    

</div>
    </div>
  </div>
  </div>
  <!--end mob slider-->
  <!--section below slider-->
  
  <section class="container section_padding_top desktop_view">
      <div class="row">
          <div class="col-md-12 text-center">
              <a href="" class="btn btn-block btn-bordered">
                  Discover Our Selection
              </a>
          </div>
          
      </div>
      </section>
<!--end discover our selection-->
      <section class="container section_padding_top pull_up_mobile">
        <!-- start row -->
        <div class="row">
          <?php 
          $_row_count = 1;
          $_box_count = count($_all_boxes);
          foreach( $_all_boxes as $_all_box ):
            $_stock = json_decode($inventory->get_purchasable('', $_all_box['internal_id']))->stock;
            $_stock_div = 'E-box only';
            if($_stock > 0){
              $_stock_div = 'In stock('.$_stock.')';
            }
            $_media = $picture->get_byitem('00', $_all_box['internal_id']);
            $_media = json_decode($_media, true)['data'];
            $_3d = $pdf = 'N/A';
            foreach( $_media as $_mm ){
                if($_mm['type'] == '2'){
                  $_3d = $_mm['path_name'];
                }
                elseif($_mm['type'] == '3'){
                  $pdf = $_mm['path_name'];
                }
            }
            $_pop_str = $_all_box['internal_id'] . '~' .$_all_box['name'].'~'.$_all_box['price'].'~'.$_all_box['description'].'~'.$_3d.'~'.$pdf;
          ?>
            <div class="col-md-6">
             <div class="card selection_card">
                <div class="card-header">
                  <img src="<?=$_3d?>" class="autoimg">
                </div>
                <div class="card-body selection_card_body text-center">
                  <h4 class="box_title">
                    <a href="#" onclick="booklet_show('<?=$_pop_str?>')"><?=$_all_box['name']?></a>
                  </h4>
                  <p><a class="stock_div"><?=$_stock_div?></a></p>
                  <p><?=$_all_box['description']?></p>
                </div>
              </div>
              <div class="cart_bar text-white">
                  <div class="cart_bar_strip desktop_view">
                    <form name="frm_<?=$_all_box['internal_id']?>">
                      <input type="hidden" value="<?=$_all_box['internal_id']?>" name="internal_id">
                      <span class="pricing">KES <?=number_format($_all_box['price'], 2)?></span>
                      <img src="<?=$util->ClientHome()?>/shared/img/cart_client_strip.svg" class="width_100 add_to_cart" onclick="add_to_cart('frm_<?=$_all_box['internal_id']?>')">
                    </form>
                  </div>
                    <div class="cart_bar_strip_mob mobile_view row">
                      <div class="col-6">
                              <form name="frm_<?=$_all_box['internal_id']?>">
                             
                      <input type="hidden" value="<?=$_all_box['internal_id']?>" name="internal_id">
                <span class="pricing btn btn-mob-cart btn-block">KES <?=number_format($_all_box['price'], 2)?></span>
                      </div>
                        <div class="col-6">
                             <!--    <img src="shared/img/addcartmob.svg" data-toggle="modal" data-target="#addedToCart" class="width_100 add_to_cart">!-->
                                    <img src="<?=$util->ClientHome()?>/shared/img/addcartmob.svg" class="width_100 add_to_cart" onclick="add_to_cart('frm_<?=$_all_box['internal_id']?>')">
                                  </form> 
                      </div>                  
 </div>
              </div>
            </div>
          <?php 
          if($_row_count%2 == 0){
            print '</div><br><hr class="desktop_view"><br><div class="row">';
          }
          $_row_count++;
          endforeach;
          ?>
          </div>
          <!-- end row -->
        </div>
      </section>
<!--end add to cart cards-->
<section class=" iwant_section">
      <div class="container">
    <div class="row">
             <div class="col-md-12">
              
                  <img src="<?=$util->ClientHome()?>/shared/img/iwant_layer.svg" class="iwant_img desktop_view">
                 <img src="<?=$util->ClientHome()?>/shared/img/iwantmoxmob.svg" class="iwant_img mobile_view">
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
              
                      <img src="<?=$util->ClientHome()?>/shared/img/whyhappy.svg" class="why_img desktop_view">
                      <img src="<?=$util->ClientHome()?>/shared/img/whyhappymob.svg" class="why_img mobile_view">
             
             
          </div>
          
      </div>
    <div class="row why_happy_card_row desktop_view">
      
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
      <div class="brands row mobile_view">
   
                     <div class="col">
                         
                 <div class="brands_slider_container">
                     <div class="owl-carousel owl-theme why_slider">
                         <div class="owl-item w-100">
                             <div class="brands_item d-flex flex-column justify-content-center">
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
                         </div>
                          <div class="owl-item w-100">
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
                         <div class="owl-item w-100">
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
                         <div class="owl-item w-100">
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
                                           
                         
                         
                         
                         
                         
                     </div> <!-- Brands Slider Navigation -->
                     <div class="brands_nav why_prev"><i class="fas fa-chevron-left"></i></div>
                     <div class="brands_nav why_next"><i class="fas fa-chevron-right"></i></div>
                 </div>
             </div>
       
  
 </div>
</section>
       <?php include 'shared/partials/partners.php';?>
      <?php include 'shared/partials/footer.php';?>
  
  <!-- Bootstrap core JavaScript -->
  
<?php include 'shared/partials/js.php';?>
   <!-- pop up -->
  <button id="popup_box" data-toggle="modal" data-target="#bookletPop" style="display:none;"></button>
  <div class="modal fade" id="bookletPop">
    <div class="modal-dialog general_pop_dialogue booklet_dialogue pop_slider">
      <div class="modal-content">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-8 pop_slider_pad">
              <div id="modalSlider" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <img id="box_img_" class="d-block w-100" src="shared/img/_modal_slide_img.jpg" alt="Second slide">
                    <div class="carousel-caption">
                      <p><a id="bx_booklet_" target="_blank" href="#">View Box Booklet</a></p>
                    </div>
                  </div>
                  <div class="carousel-item">
                    <img class="d-block w-100" src="shared/img/_modal_slide_img.jpg" alt="Second slide">
                    <div class="carousel-caption">
                      <p><a id="bx_booklet_t" target="_blank" href="#">View Box Booklet</a></p>
                    </div>
                  </div>
                </div>
                <a class="carousel-control-prev" href="#modalSlider" role="button" data-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="sr-only">Previous</span></a>
                <a class="carousel-control-next" href="#modalSlider" role="button" data-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="sr-only">Next</span></a>
              </div>
            </div>
            <div class="col-md-4 blue_border_left pop_slider_pad">
              <a href="" data-dismiss="modal"><img class="modal_close" src="<?=$util->ClientHome()?>/shared/img/icons/icn-close-window-blue.svg"></a>
              <div class="modal_parent">
                <div class="modal_child text-center">
                  <h6 id="box_name_"></h6><br>
                     <div class="desktop_view">
                  <a href="" class="bold_txt pink_bg btn text-white" id="box_price_"></a>
                  <p id="box_desc_"></p>
               
                <div>
                <form name="frm_popup">
                  <input type="hidden" value="" id="internal_id" name="internal_id">
                  <img class="" src="<?=$util->ClientHome()?>/shared/img/icons/btn-add-to-cart-small-red-teal.svg" onclick="add_to_cart('frm_popup')"/>
                </form>
              </div> </div>
                  <!--mobile --> <div class="mobile_view">
                        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
                                                  
                      <div class="row">
                          <div class="col-6"> <a href="" class="bold_txt pink_bg btn text-white">KES 20 000.00</a></div>
                          <div class="col-6">            <img class="" src="shared/img/icons/btn-add-to-cart-small-red-teal.svg"></div>
                      </div>
                   
                                                </div>
                  <!--end mobile-->
            </div>
          </div>
          <!-- end row -->
        </div>
        <!-- end modal body -->
      </div>
      <!-- end modal content -->
    </div>
    <!-- end modal dialogue-->
  </div>
  <!-- end modal -->

</div>
</div>
  <!-- end pop up -->
  <!-- added to cart pop up -->
  <button id="popupid" data-toggle="modal" data-target="#addedToCart" style="display:none;"></button>
    <div class="modal fade" id="addedToCart">
    <div class="modal-dialog general_pop_dialogue added_tocart_dialogue ">
    <div class="modal-content">
        <a href="" class="desktop_view" data-dismiss="modal"> <img class="modal_close2" src="<?=$util->ClientHome()?>/shared/img/icons/icn-close-window-blue.svg"></a> 
    <div class="modal-body text-center">
    <div class="col-md-12 text-center">
    <h3 id="vvv"></h3>   
    <div class="action_btns desktop_view" >
    <a href="" data-dismiss="modal"> <img class="" src="<?=$util->ClientHome()?>/shared/img/btn-continue-shopping.svg"></a> 
    <a href="user-dash-shoppingcart.php"> <img class="" src="<?=$util->ClientHome()?>/shared/img/btn-checkout.svg"></a> 
    </div>
    <div class="okay_btn mobile_view text-center">
        <img data-dismiss="modal" class="" src="<?=$util->ClientHome()?>/shared/img/okay_mob.svg"></a> 
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

    $(document).ready(function(){
      booklet_show = function(data){
        var d = data.split('~');
        $('#internal_id').val(d[0]);
        $('#box_price_').text('KES ' + d[2]);
        $('#box_name_').text(d[1]);
        // $('#slide_title_').text(d[1]);
        $('#box_desc_').text(d[3]);
        // $('#box_img_').attr('src', d[4]);
        $('#bx_booklet_').attr('href', d[5]);
        $('#bx_booklet_t').attr('href', d[5]);
        $('#popup_box').trigger('click');
        // console.log(d);
      }

      add_to_cart = function(FormId){
        waitingDialog.show('adding... Please wait',{headerText:'',headerSize: 6,dialogSize:'sm'});
        var dataString = $("form[name=" + FormId + "]").serialize();
        $.ajax({
            type: 'post',
            url: '<?=$util->AjaxHome()?>?activity=add-to-cart',
            data: dataString,
            success: function(res){
                console.log(res);
                var rtn = JSON.parse(res);
                if(rtn.hasOwnProperty("MSG")){
                    $("#reset_div").load(window.location.href + " #reset_div" );
                    $('#vvv').text('This box has been added to your cart');
                    $('#popupid').trigger('click');
                    waitingDialog.hide();
                    return;
                }
                else if(rtn.hasOwnProperty("ERR")){
                    $('#vvv').text(rtn.ERR);
                    $('#popupid').trigger('click');
                    waitingDialog.hide();
                    return;
                }
            }
        });
      }
    });
    
  
</script>
</body>

</html>
