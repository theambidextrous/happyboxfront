<?php
session_start();
require_once('lib/Util.php');
require_once('lib/User.php');
require_once('lib/Box.php');
require_once('lib/Picture.php');
require_once('lib/Inventory.php');
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
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
        <!--meta words-->
<meta name="keywords" content="vouchers,birthday gift,valentine gift,gift a gift,christmas gift,easter gift,wedding gift,anniversary gift">
<meta name="description" content="Welcome to HappyBox. HappyBox issues vouchers to its customers via its website. Each voucher is an opportunity to suggest an appropriate set of experiences for the recipient of the voucher.">
<meta name="robots" content="index, follow">
<link rel="canonical" href="https://happybox.ke/">
<meta property="og:locale" content="en_US">
<meta property="og:type" content="website">
<meta property="og:title" content="HappyBox">
<meta property="og:description" content="Welcome to HappyBox. HappyBox issues vouchers to its customers via its website. Each voucher is an opportunity to suggest an appropriate set of experiences for the recipient of the voucher.">
<meta property="og:url" content="https://happybox.ke/">
<meta property="og:site_name" content="HappyBox">
<meta property="og:image" content="https://happybox.ke/shared/img/logo.svg">
<meta property="og:image:width" content="320">
<meta property="og:image:height" content="88">        
        <!--end meta words -->
	<title>HappyBox :: Home</title>

	<!-- Bootstrap core CSS -->
	<?php include 'shared/partials/css.php'; ?>
</head>

<body class="client_body home_page">

	<!-- Navigation -->
	<?php include 'shared/partials/nav.php'; ?>

	<!-- Page Content -->
	<div class="container-fluid desktop_view">
		<div class="slider_overlay"></div>
		<div class="row">
			<div id="desktop_carousel" class="carousel slide carousel-fadex home_slider" data-ride="carousel">
				<ul class="carousel-indicators">
					<li data-target="#desktop_carousel" data-slide-to="0" class="active"></li>
					<li data-target="#desktop_carousel" data-slide-to="1"></li>
					<li data-target="#desktop_carousel" data-slide-to="2"></li>
					<!-- <li data-target="#desktop_carousel" data-slide-to="3"></li> -->
				</ul>
				<div class="carousel-inner">
					<div class="carousel-item slider_1 active">
						<img src="<?=$util->AppHome()?>/shared/img/slider-a.png" class="w-100">
					</div>
					<!-- 2-->
					<div class="carousel-item slider_2">
						<img src="<?=$util->AppHome()?>/shared/img/slider-a2.jpg" alt="slider 2" class="w-100">
					</div>
					<!-- <div class="carousel-item slider_2">
						<img src="<=$util->AppHome()?>/shared/img/slider-b.png" alt="slider 2" class="w-100">
					</div> -->
					<div class="carousel-item slider_3">
						<img src="<?=$util->AppHome()?>/shared/img/slider-c.png" alt="slider 3" class="w-100">
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--start mobile slider-->
	<!--
<div class="container-fluid mobile_view">
	<div class="slider_overlay"></div>
	<div class="row">
		<div id="mobile_carousel" class="carousel slide carousel-fade home_slider" data-ride="carousel">
			<div class="carousel-inner">
				<div class="carousel-item slider_1">
					<div class="mob_cta text-center">
						<img src="shared/img/slider_reg.svg" class="">
					</div>
					<img src="shared/img/mob_slider1.jpg" class="w-100">
					<div class="mob_sli_des text-center">
						<img src="shared/img/mob_sli_des.svg" class="mob_sli_des_1">
						<p> HAPPYBOX offers you the unique opportunity to find a gift which fits all tastes. 
							The recipient has the option of choosing a tailored experience from a multitude of exclusive activities.</p>
						<p> From relaxing spas, energising yoga classes and gastronomic delights to exhilarating sports and adventure experiences, HAPPYBOX has it all! </p>
						<img src="shared/img/mob_sli_discover.svg" class="">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
-->
	<div class="container-fluid mobile_view">
		<div class="slider_overlay"></div>
		<div class="row">
			<div id="demo" class="carousel slide carousel-fade home_slider" data-ride="carousel">

				<div class="carousel-inner">
					<div class="carousel-item active slider_1">
						<div class="mob_cta text-center">
							<a href="<?=$util->AppHome()?>/client/user-dash-activate-voucher.php">
								<img src="shared/img/slider_reg.png" class="">
							</a>
						</div>
						<img src="shared/img/mob_slider1.jpg" class="w-100">
						<div class="mob_sli_des text-center">

							<img src="shared/img/mob_sli_des.svg" class="mob_sli_des_1">
							<p>
								HAPPYBOX offers you the unique opportunity to find a gift which fits all tastes.
								The recipient has the option of choosing a tailored experience from a multitude of exclusive activities.</p>
							<p> From relaxing spas, energising yoga classes and gastronomic delights to exhilarating sports and adventure experiences, HAPPYBOX has it all!
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
				<a href="" class="btn btn-block btn-bordered"> Discover Our Selection </a>
			</div>
		</div>
	</section>
	<!--end discover our selection-->
	<section class="container section_padding_top pull_up_mobile">
		<!-- start row -->
		<div class="row">
			<?php
			$_row_count = 1;
			$col_count = 1;

			$_box_count = count($_all_boxes);
			foreach ($_all_boxes as $_all_box) :
				if ($col_count % 2 == 0) {
					$col_count_col = "col_right_2";;
				} else {

					$col_count_col = "col_left_1";
				}

				$_stock = json_decode($inventory->get_purchasable('', $_all_box['internal_id']))->stock;
				$_stock_div = 'E-box only';
				if ($_stock > 0) {
					// $_stock_div = 'In stock('.$_stock.')';
					$_stock_div = 'In stock';
				}
				$_media = $picture->get_byitem('00', $_all_box['internal_id']);
				$_media = json_decode($_media, true)['data'];
				$_3d = $pdf = 'N/A';
				foreach ($_media as $_mm) {
					if ($_mm['type'] == '2') {
						$_3d = $_mm['path_name'];
					} elseif ($_mm['type'] == '3') {
						$pdf = $_mm['path_name'];
					}
				}
				$_pop_str = $_all_box['internal_id'] . '~' . $_all_box['name'] . '~' . $_all_box['price'] . '~' . strip_tags($_all_box['description']) . '~' . $_3d . '~' . $pdf;
				$_pop_str = str_replace("'", "", $_pop_str);
				$_pop_str = preg_replace("/\r|\n/", "", $_pop_str);
			?>
				<div class="col-md-6 <?= $col_count_col; ?>">
					<div class="card selection_card sports_card">
						<div class="sport_card_hover" onclick="booklet_show('<?= $_pop_str ?>')">
							<img src="shared/img/icons/magnifyglass.svg" />
						</div>
						<div class="card-header">
							<img src="<?= $_3d ?>" class="autoimg">
						</div>
						<div class="card-body selection_card_body text-center">
							<h4 class="box_title"> <a href="javascript(0);"><?= $_all_box['name'] ?></a> </h4>
							<div>
								<p class="stock_div"><?= $_stock_div ?></p>
							</div>
							<div><?= $_all_box['description'] ?></div>
						</div>
					</div>
					<div class="cart_bar text-white">
						<div class="cart_bar_strip desktop_view">
							<form name="frm_<?= $_all_box['internal_id'] ?>">
								<input type="hidden" value="<?= $_all_box['internal_id'] ?>" name="internal_id">
								<span class="pricing">KES <?= number_format($_all_box['price'], 2) ?>
								</span> <img src="<?=$util->AppHome()?>/shared/img/cart_client_strip.svg" class="width_100 add_to_cart" onclick="add_to_cart('frm_<?= $_all_box['internal_id'] ?>')">
							</form>
						</div>
						<div class="cart_bar_strip_mob mobile_view ">
							<form name="frm_<?= $_all_box['internal_id'] ?>">
								<div class="row">
									<div class="col-6">
										<input type="hidden" value="<?= $_all_box['internal_id'] ?>" name="internal_id">
										<span class="pricing btn btn-mob-cart btn-block">KES <?= number_format($_all_box['price'], 2) ?>
										</span>
									</div>
									<div class="col-6">
										<img src="<?=$util->AppHome()?>/shared/img/addcartmob.svg" class="width_100 add_to_cart" onclick="add_to_cart('frm_<?= $_all_box['internal_id'] ?>')">
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			<?php
				if ($_row_count % 2 == 0) {
					// print '</div><br><hr class="desktop_view"><br><div class="row">';
					print '</div><br><br><div class="row">';
				}
				$_row_count++;
				$col_count++;
			endforeach;
			?>
			<!-- end row -->
		</div>
	</section>
	<!--end add to cart cards-->
	<section class=" iwant_section">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<img src="<?=$util->AppHome()?>/shared/img/iwant_layer.svg" class="iwant_img desktop_view"> <img src="<?=$util->AppHome()?>/shared/img/iwantmoxmob.png" class="iwant_img mobile_view">
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row justify-content-between iwant_card_row">
				<div class="col-md-3 iwant_card">
					<div class="step_box step_color1">1</div>
					<div class="iwant_card_div">
						<p class="iwant_card_p"> Select a <br class="">
							HappyBox according<br class="">
							to your budget</p>
					</div>
					<p class="iwant_card_bar iwant_card_bar step_color1"> </p>
				</div>
				<div class="col-md-3 iwant_card no_radius">
					<div class="step_box step_color2">2</div>
					<div class="iwant_card_div">
						<p class="iwant_card_p"> Log in or <br class="">
							create an account</p>
					</div>
					<p class="iwant_card_bar iwant_card_bar step_color2"> </p>
				</div>
				<div class="col-md-3 iwant_card no_radius">
					<div class="step_box step_color3">3</div>
					<div class="iwant_card_div">
						<p class="iwant_card_p"> Choose your delivery <br class="">
							date and mode <br>
							<span class="thin_font">(doorstep or e-box)</span> </p>
					</div>
					<p class="iwant_card_bar iwant_card_bar step_color3"> </p>
				</div>
				<div class="col-md-3 iwant_card iwant_card_last">
					<div class="step_box step_color4">4</div>
					<div class="iwant_card_div">
						<p class="iwant_card_p"> Make payment using<br class="">
							a credit card or Mpesa</p>
					</div>
					<p class="iwant_card_bar iwant_card_bar step_color4"> </p>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<!--congratulate yourself-->
				<div class="col-md-12 congratulate text-center section_margin_top">
					<p class="p1">Congratulate yourself … </p>
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
				<img src="<?=$util->AppHome()?>/shared/img/whyhappy.png" class="why_img desktop_view"> <img src="<?=$util->AppHome()?>/shared/img/whyhappymob.png" class="why_img mobile_view">
			</div>
		</div>
		<div class="row why_happy_card_row desktop_view">
			<div class="col-md-3">
				<div class="card why_happy_card why_happy_card_client">
					<div class="card-header">
					</div>
					<div class="card-body why_happy_card_body text-center">
						<img src="<?=$util->AppHome()?>/shared/img/icons/icn-kenyan-flag.svg" />
						<div class="why_happy_card_body_div">
							<p> Proudly 100% Kenyan </p>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="card why_happy_card why_happy_card_client">
					<div class="card-header">
					</div>
					<div class="card-body why_happy_card_body text-center">
						<img src="<?=$util->AppHome()?>/shared/img/icons/icn-large-choice.svg" />
						<div class="why_happy_card_body_div">
							<p> A large choice of activities in each box </p>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="card why_happy_card why_happy_card_client">
					<div class="card-header">
					</div>
					<div class="card-body why_happy_card_body text-center">
						<img src="<?=$util->AppHome()?>/shared/img/icons/icn-warranty.svg">
						<div class="why_happy_card_body_div">
							<p> Loss &amp; theft warranty </p>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="card why_happy_card why_happy_card_client">
					<div class="card-header">
					</div>
					<div class="card-body why_happy_card_body text-center">
						<img src="<?=$util->AppHome()?>/shared/img/icons/icn-evaluate.svg" />
						<div class="why_happy_card_body_div">
							<p> Experiences are regularly evaluated and updated on our website </p>
						</div>
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
										<img src="<?=$util->AppHome()?>/shared/img/icons/icn-kenyan-flag.svg" />
										<p> Proudly 100% Kenyan </p>
									</div>
								</div>
							</div>
						</div>
						<div class="owl-item w-100">
							<div class="card why_happy_card why_happy_card_client">
								<div class="card-header">
								</div>
								<div class="card-body why_happy_card_body text-center">
									<img src="<?=$util->AppHome()?>/shared/img/icons/icn-large-choice.svg" />
									<p> A large choice of activities in each box </p>
                                                                        
								</div>
							</div>
						</div>
						<div class="owl-item w-100">
							<div class="card why_happy_card why_happy_card_client">
								<div class="card-header">
								</div>
								<div class="card-body why_happy_card_body text-center">
									<img src="<?=$util->AppHome()?>/shared/img/icons/icn-warranty.svg">
									<p> Loss &amp; theft warranty </p>
								</div>
							</div>
						</div>
						<div class="owl-item w-100">
							<div class="card why_happy_card why_happy_card_client">
								<div class="card-header">
								</div>
								<div class="card-body why_happy_card_body text-center">
									<img src="<?=$util->AppHome()?>/shared/img/icons/icn-evaluate.svg" />
									<p> Experiences are regularly evaluated and updated on our website </p>
								</div>
							</div>
						</div>
					</div>
					<!-- Brands Slider Navigation -->
					<div class="brands_nav why_prev">
						<i class="fas fa-chevron-left"></i>
					</div>
					<div class="brands_nav why_next">
						<i class="fas fa-chevron-right"></i>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php include 'shared/partials/partners.php'; ?>
	<?php include 'shared/partials/footer.php'; ?>

	<!-- Bootstrap core JavaScript -->

	<?php include 'shared/partials/js.php'; ?>
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
											<p><a id="bx_booklet_" class="bx_booklet_" target="_blank" href="javascript(0);">
											<img src="<?=$util->AppHome()?>/shared/img/download_booklet.png" class="w-100">
											</a></p>
										</div>
									</div>

								</div>
								<a class="carousel-control-prev" href="#modalSlider" role="button" data-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="sr-only">Previous</span></a> <a class="carousel-control-next" href="#modalSlider" role="button" data-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="sr-only">Next</span></a>
							</div>
						</div>
						<div class="col-md-4 blue_border_left pop_slider_pad">
							<a href="" data-dismiss="modal"><img class="modal_close" src="<?=$util->AppHome()?>/shared/img/icons/icn-close-window-blue.svg"></a>
							<div class="modal_parent">
								<div class="modal_child text-center">
									<h6 id="box_name_" class="box_name_"></h6>
									<div class="desktop_view">
										<a href="" class="bold_txt pink_bg btn text-white box_price_" id="box_price_"></a>
										<p id="box_desc_" class="box_desc_"></p>
										<div>
											<form name="frm_popup">
												<input type="hidden" value="" id="internal_id" class="internal_id" name="internal_id">
												<img class="" src="<?=$util->AppHome()?>/shared/img/icons/btn-add-to-cart-small-red-teal.svg" onclick="add_to_cart('frm_popup')" />
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
												<img class="" src="<?=$util->AppHome()?>/shared/img/icons/btn-add-to-cart-small-red-teal.svg" onclick="add_to_cart('frm_popup')" />
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
				<a href="" class="desktop_view" data-dismiss="modal"> <img class="modal_close2" src="<?=$util->AppHome()?>/shared/img/icons/icn-close-window-blue.svg"></a>
				<div class="modal-body text-center">
					<div class="col-md-12 text-center">
						<h3 id="vvv"></h3>
						<div class="action_btns desktop_view">
							<a href="" data-dismiss="modal"> <img class="" src="<?=$util->AppHome()?>/shared/img/btn-continue-shopping.png"></a> <a href="<?=$util->ClientHome()?>/user-dash-shoppingcart.php"> <img class="" src="<?=$util->AppHome()?>/shared/img/btn-checkout.png"></a>
						</div>
						<div class="okay_btn mobile_view text-center">
							<img data-dismiss="modal" class="" src="<?=$util->AppHome()?>/shared/img/okay_mob.svg"></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!--added to cart  end pop up -->
	<script type="text/javascript">
		/*$(document).bind('keyup', function(e) {
        if(e.which == 39){
            $('.carousel').carousel('next');
        }
        else if(e.which == 37){
            $('.carousel').carousel('prev');
        }
    });*/

		$(document).ready(function() {
			booklet_show = function(data) {
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

			add_to_cart = function(FormId) {
				waitingDialog.show('Adding... please wait', {
					headerText: '',
					headerSize: 6,
					dialogSize: 'sm'
				});
				var dataString = $("form[name=" + FormId + "]").serialize();
				$.ajax({
					type: 'post',
					url: '<?= $util->AjaxHome() ?>?activity=add-to-cart',
					data: dataString,
					success: function(res) {
						console.log(res);
						var rtn = JSON.parse(res);
						if (rtn.hasOwnProperty("MSG")) {
							// $("#reset_div").load(window.location.href + " #reset_div" );
							// setTimeout(function() {
							// 	location.reload();
							// }, 20000);
       $("#addedToCart").on('hidden.bs.modal', function(){
        location.reload();
       });
							$('#vvv').text('This box has been added to your cart');
							$('#popupid').trigger('click');
							waitingDialog.hide();
							return;
						} else if (rtn.hasOwnProperty("ERR")) {
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