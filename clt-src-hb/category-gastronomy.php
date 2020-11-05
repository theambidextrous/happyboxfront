<?php
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
require_once('../lib/Box.php');
require_once('../lib/Topic.php');
require_once('../lib/Picture.php');
require_once('../lib/Inventory.php'); 
$util = new Util();
$user = new User();
$box = new Box();
$picture = new Picture();
$inventory = new Inventory();
$_t = new Topic();
$topic_selected_ = $topic_selected_ = $util->AppGastronomy();
$util->ShowErrors(1);
$_all_boxes = json_decode($box->get_all_active_bytopic($topic_selected_), true)['data'];
$_all_ptns = json_decode($user->get_ptn_bytopic($topic_selected_), true)['data'];
// $util->Show($_all_ptns);
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>HappyBox :: Category Gastronomy</title>

  <!-- Bootstrap core CSS -->
 <?php include 'shared/partials/css.php'; ?>
 
</head>

<body class="client_body">
  <!-- Navigation -->
 <?php include 'shared/partials/nav.php'; ?>
  <!-- Page Content --> 
  <!--start well being banner-->
  <section class="desktop_view  gastronomy_banner">
      <div class="container">
      <div class="row justify-content-end">
          <div class="col-md-5 text-md-right">
           
             
              <div class="gastronomy_banner_title">
                       <h3>  
                           It's time to have<br> a gourmet break . . .
                       </h3>
              </div>
              <p class="text-white gastronomy_banner_p text-center">
                  . . . and share a convivial moment with your dear friends and relatives around a good meal or a wine tasting.<br><br>
                  Browse our selection of culinary delights that will undoubtedly appeal to all palates with diverse flavours from far and wide. <br><br>
                  We've got something for every taste!
           </p>
              <div class="well_scroll text-center">
                  <img class="" src="shared/img/icons/icn-arrow-orange.svg">
         </div>
              
             
          </div>
          
      </div>
      </section>
  <section class="mobile_view">
      <div class="container">
      <div class="row justify-content-center">
        
            <div class="">
                <img class="w-100" src="shared/img/gastronomy_mob_banner.png">
            
              </div>

             <div class="col-11">
              <div class="well_banner_title_mob">
                   <img class="w-" src="shared/img/its_time.svg">
            
              </div></div>
             <div class="col-10">
              <p class="well_banner_p text-black text-center">
                  . . . and share a convivial moment with your dear friends and relatives around a good meal or a wine tasting.<br><br> Browse our selection of culinary delights that will undoubtedly appeal to all palates with diverse flavours from far and wide.<br><br> We've got something for every taste!
              </p>
             </div>
               <div class="col-12">
              <div class="well_scroll text-center">
                  <img class="" src="shared/img/icn-circle-arrow-rounded-orange.svg">
         </div>
              
             
          </div>
          
      </div></div>
      </section>
    <!--end well being banner-->
      <!--end discover our selection-->
      <section class="container section_padding_top cat_well">
          <div class="row col-container ">
          <?php 
          $_row_count = 1;
          $_box_count = count($_all_boxes);
          foreach( $_all_boxes as $_all_box ):
            $_stock = json_decode($inventory->get_purchasable('', $_all_box['internal_id']))->stock;
           $_stock_div = 'E-box only';
            if($_stock > 0){
              //$_stock_div = 'In stock('.$_stock.')';
                            $_stock_div = 'In stock';
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
            $_pop_str = str_replace("'", "", $_pop_str);
			      $_pop_str = preg_replace( "/\r|\n/", "", $_pop_str);
          ?>            
            <div class="col-md-4 no_pad_lr">
              <div class="card selection_card sports_card">
               <div class="sport_card_hover" onclick="booklet_show('<?=$_pop_str?>')">
                 <img src="shared/img/icons/magnifyglass.svg"/>
                </div>
                <div class="card-header">
                  <img src="<?=$_3d?>" class="autoimg">
                </div>
                <div class="card-body selection_card_body text-center">
                  <h4 class="box_title"><?=$_all_box['name']?></h4>
                  <p><a class="stock_div"><?=$_stock_div?></a></p>
                  <p><?=$_all_box['description']?></p>
                </div>
              </div>
              <div class="cart_bar text-white desktop_view">
                <div class="cart_bar_strip">
                  <form name="frm_<?=$_all_box['internal_id']?>">
                    <input type="hidden" value="<?=$_all_box['internal_id']?>" name="internal_id">
                    <span class="pricing">KES <?=number_format($_all_box['price'], 2)?></span>
                    <img src="<?=$util->ClientHome()?>/shared/img/cart_client_strip.svg" class="width_100 add_to_cart" onclick="add_to_cart('frm_<?=$_all_box['internal_id']?>')">
                  </form>
                </div>
              </div>
                  <div class="cart_bar_strip_mob mobile_view ">
                
                         <div class="cart_bar_strip row">
                             
                                   
                      <div class="col-6">
                           <form name="frm_<?=$_all_box['internal_id']?>">
                           <input type="hidden" value="<?=$_all_box['internal_id']?>" name="internal_id">
                          <span class="pricing btn btn-mob-cart btn-block">
                         KES <?=number_format($_all_box['price'], 2)?>
                      </span> 
                      </div>
                        <div class="col-6">
                        <img src="<?=$util->ClientHome()?>/shared/img/addcartmob.svg" class="width_100 add_to_cart" onclick="add_to_cart('frm_<?=$_all_box['internal_id']?>')">
                          <!-- <img src="shared/img/addcartmob.svg" data-toggle="modal" data-target="#addedToCart" class="width_100 add_to_cart"> -->
                        </form>  
                      </div>
                               
                         </div>
              </div>
            </div> 
            <?php 
            if($_row_count%3 == 0){
              print '</div><br><hr><br><div class="row">';
            }
            $_row_count++;
            endforeach;
            ?>
          </div>
        </section>
<!--end add to cart cards-->
<!--our partners -->
      <section class="wellbeing_partners desktop_view">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <a class="btn_gastronomy btn-block" >OUR GASTRONOMY PARTNERS</a>
            </div>
          </div>
          <!-- list partners -->
          <?php 
            $list_ = [];
            foreach( $_all_ptns as $_all_ptn ):
              $_is_Active = json_decode($user->get_is_active($_all_ptn['userid']))->is_active->is_active;
              if($_is_Active){
                array_push($list_, 1);
                $_ptn_picture = json_decode($picture->get_byitem_one('00', $_all_ptn['internal_id']))->data;
                $_ptn_logo_path = $util->AppUploads().'profiles/'.$_all_ptn['picture'];
                if($_ptn_picture->path_name){
                  $_ptn_logo_path = $_ptn_picture->path_name;
                }
          ?>
          <div class="row row_partner">
            <div class="col-md-3">
              <div class="partner_logo gastronomy_partner_logo">
                <div class="partner_logo_in"><img src="<?=$_ptn_logo_path?>"/></div>
              </div>
            </div> 
            <div class="col-md-9">
              <div class="table-responsive">
                <div class="table_radius">
                  <table class="cat_well_table table table-bordered">
                    <tr>
                      <td class="td_cat_a">
                        <table>
                          <tbody>
                            <tr><td class="inner_td_gray"><h6><center><?=$_all_ptn['business_name']?></center></h6></td></tr>
                            <tr><td class="inner_light_blue"><h6><center><?=$_all_ptn['location']?></center></h6></td></tr>
                          </tbody>
                        </table>
                      </td>
                      <td>
                        <h4>Partner / Experience Description</h4>
                        <p class="cat_p"><?=$_all_ptn['short_description']?></p>
                        <p class="text-right rating_bar">
                          <img src="shared/img/icons/icn-star-orange.svg" class="">      
                          <img src="shared/img/icons/icn-star-orange.svg" class="">  
                          <img src="shared/img/icons/icn-star-orange.svg" class="">
                          <img src="shared/img/icons/icn-star-orange.svg" class=""> 
                          <img src="shared/img/icons/icn-blank-star-orange.svg" class="">
                          <!-- <img src="shared/img/icons/icn-half-star-orange.svg" class=""> -->
                        </p>
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <?php 
              }
            endforeach;
            if(array_sum($list_) < 1){
              print '<h4><center>No partners found</center></h4>';
            }
          ?>
        </div>
      </section>
<section class="wellbeing_partners mobile_view gas_well_part_mob">
       <div class="container">
           <div class="row">
           <div class="col-md-12">
           <a class="btn_gastronomy btn-block" >OUR GASTRONOMY PARTNERS</a>
               
           </div>  </div>
           <?php 
            $list_ = [];
            foreach( $_all_ptns as $_all_ptn ):
              $_is_Active = json_decode($user->get_is_active($_all_ptn['userid']))->is_active->is_active;
              if($_is_Active){
                array_push($list_, 1);
                $_ptn_picture = json_decode($picture->get_byitem_one('00', $_all_ptn['internal_id']))->data;
                $_ptn_logo_path = $util->AppUploads().'profiles/'.$_all_ptn['picture'];
                if($_ptn_picture->path_name){
                  $_ptn_logo_path = $_ptn_picture->path_name;
                }
          ?>
            <div class="row row_partner">
           <div class="col-5">
               <div class="partner_logo">
                 <div class="partner_logo_in">  
                   <img src="<?=$_ptn_logo_path?>"/>
                   </div>
               </div>
               
           </div> 
             <div class="col-7">
                 <div class="table-responsive">
                      <div class="table_radius">
                     <table class="cat_well_table table table-bordered">
                         <tr>
                              <td class="td_cat_a">
                                 <table>
                                     <tr><td class="inner_td_gray"><h6><?=$_all_ptn['business_name']?></h6></td></tr>
                                        <tr><td class="inner_light_blue"><h6 >  <?=$_all_ptn['location']?></h6></td></tr>
                                 </table>
                                 
                               
                                 
                             </td>
                               
                         </tr>
                     
                 </table>
                    </div>  
                     
                 </div>
               
             </div> <div class="col-12">
                 <div class="card_partner_mobcard">
                     <h4>Spa & Beauty Treatments</h4>
                     <p>
                   <?=$_all_ptn['location']?> </p>
                     
                 </div>
                 
             </div>
            </div>
              <?php 
              }
            endforeach;
            if(array_sum($list_) < 1){
              print '<h4><center>No partners found</center></h4>';
            }
          ?>
        
       
          
                     
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
									<img id="box_img_" class="box_img_ d-block w-100" src="shared/img/_modal_slide_img.jpg" alt="Second slide">
									<div class="booklet-button">
										<p><a id="bx_booklet_" class="bx_booklet_" target="_blank" href="javascript(0);">Consult the booklet online</a></p>
									</div>
								</div>
								
							</div>
							<a class="carousel-control-prev" href="#modalSlider" role="button" data-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="sr-only">Previous</span></a> <a class="carousel-control-next" href="#modalSlider" role="button" data-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="sr-only">Next</span></a>
						</div>
					</div>
					<div class="col-md-4 blue_border_left pop_slider_pad">
						<a href="" data-dismiss="modal"><img class="modal_close" src="<?=$util->ClientHome()?>/shared/img/icons/icn-close-window-blue.svg"></a>
						<div class="modal_parent">
							<div class="modal_child text-center">
								<h6 id="box_name_" class="box_name_"></h6><br>
								<div class="desktop_view">
									<a href="" class="bold_txt pink_bg btn text-white box_price_" id="box_price_"></a>
									<p id="box_desc_" class="box_desc_"></p>
									<div>
										<form name="frm_popup">
											<input type="hidden" value="" id="internal_id" class="internal_id" name="internal_id">
											<img class="" src="<?=$util->ClientHome()?>/shared/img/icons/btn-add-to-cart-small-red-teal.svg" onclick="add_to_cart('frm_popup')"/>
										</form>
									</div>
								</div>
								<!--mobile -->
								<div class="mobile_view">
									<p class="box_desc_"> Discover over fifty unforgettable activities: Spa, Massage, Facial treatment, Yoga, Dinner, Hiking, Workout… From the gourmet to the most adventurous, including the wisest, everyone’s happiness is in this box! </p>
									<div class="row">
										<div class="col-6">
											<a href="" class="bold_txt pink_bg btn text-white box_price_">KES 20 000.00</a>
										</div>
										<div class="col-6">
											<img class="" src="<?=$util->ClientHome()?>/shared/img/icons/btn-add-to-cart-small-red-teal.svg" onclick="add_to_cart('frm_popup')"/>
										</div>
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
    <a href="" data-dismiss="modal" class="desktop_view"> <img class="modal_close2" src="<?=$util->ClientHome()?>/shared/img/icons/icn-close-window-blue.svg"></a> 
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
        $('.internal_id').val(d[0]);
        $('.box_price_').text('KES ' + currencyNumberFormat(d[2]));
        $('.box_name_').text(d[1]);
        // $('#slide_title_').text(d[1]);
        $('.box_desc_').text(d[3]);
        $('.box_img_').attr('src', d[4]);
        $('.bx_booklet_').attr('href', d[5]);
        $('.bx_booklet_t').attr('href', d[5]);
        $('#popup_box').trigger('click');
        // console.log(d);
      }

      add_to_cart = function(FormId){
        waitingDialog.show('Adding... Please wait',{headerText:'',headerSize: 6,dialogSize:'sm'});
        var dataString = $("form[name=" + FormId + "]").serialize();
        $.ajax({
            type: 'post',
            url: '<?=$util->AjaxHome()?>?activity=add-to-cart',
            data: dataString,
            success: function(res){
                // console.log(res);
                var rtn = JSON.parse(res);
                if(rtn.hasOwnProperty("MSG")){
                    $("#reset_div").load(window.location.href + " #reset_div" );
                    $('#vvv').text('THIS BOX HAS BEEN ADDED TO YOUR CART.');
                    setTimeout(function(){
                        location.reload();
                    }, 10000);
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

