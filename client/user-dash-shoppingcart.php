<?php
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
require_once('../lib/Picture.php');
require_once('../lib/Box.php');
$util = new Util();
$user = new User();
$picture = new Picture();
$box = new Box();
$util->ShowErrors(1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
<!--meta words-->
<meta name="keywords" content="vouchers,birthday gift,valentine gift,gift a gift,christmas gift,easter gift,wedding gift,anniversary gift">
<meta name="description" content="HappyBox issues vouchers to its customers via its website. Each voucher is an opportunity to suggest an appropriate set of experiences for the recipient of the voucher.">
<meta name="robots" content="index, follow">
<link rel="canonical" href="https://happybox.ke/">
<meta property="og:locale" content="en_US">
<meta property="og:type" content="website">
<meta property="og:title" content="HappyBox">
<meta property="og:description" content="HappyBox issues vouchers to its customers via its website. Each voucher is an opportunity to suggest an appropriate set of experiences for the recipient of the voucher.">
<meta property="og:url" content="https://happybox.ke/">
<meta property="og:site_name" content="HappyBox">
<meta property="og:image" content="https://happybox.ke/shared/img/logo.svg">
<meta property="og:image:width" content="320">
<meta property="og:image:height" content="88">        
        <!--end meta words -->
<title>HappyBox :: User Shopping Cart</title>

<!-- Bootstrap core CSS -->
<?php include '../shared/partials/css.php'; ?>
</head>

<body class="cart_page client_body">
<!-- Navigation -->
<?php include '../shared/partials/nav.php'; ?>

<!-- Page Content -->

<section class=" user_account_sub_banner desktop_view">
	<div class="container">
		<div class="row user_logged_in_nav">
			<div class="col-md-12">
				<?php include '../shared/partials/nav-mid.php'; ?>
			</div>
		</div>
	</div>
</section>

<!--end discover our selection--> 
<!--desktop start-->
<section class="container section_padding_top desktop_view" id="yourDiv">
	<div class="row">
		<div class="col-md-12">
			<h3 class="user_blue_title" >YOUR SHOPPING CART</h3> 
			<!--progress strip-->
			<div class="width_100 cart_progress_strip">
				<div class="col-md-3 cart_strip">
				</div>
			</div>
			<!--end progress strip-->
			<div>
					<?php
					// $util->Show($_SESSION['curr_usr_cart']);
					?>
				<table class="p-2 cart-table table-borderless">
					<?php 
					// $util->Show($_SESSION['curr_usr_cart']);
					// unset($_SESSION['curr_usr_cart']);
					if(!empty($_SESSION['curr_usr_cart'])){
							foreach($_SESSION['curr_usr_cart'] as $_cart_item ):
									if(isset($_cart_item['order_id'])){

									}elseif(isset($_cart_item['physical_address'])){

									}else{
									$raw_data = json_decode($box->get_byidf('00', $_cart_item[0]));
									$_box_data = $raw_data->data;
									$_b_cost = floor($_cart_item[1]*$_box_data->price);
									$_total_cart[] = $_b_cost;
									$_total_shipping = 0;
									$_media = $picture->get_byitem('00', $_cart_item[0]);
									$_media = json_decode($_media, true)['data'];
									$_3d = 'shared/img/cart_img.png';
									foreach( $_media as $_mm ){
											if($_mm['type'] == '2'){$_3d = $_mm['path_name'];}
									}
					?>
					<tr id="reset_div_<?=$_cart_item[0]?>">
						<td class="pdt_img"><img src="<?=$_3d?>" /></td>
						<td class="cart_des"><h6><?=$_box_data->name?></h6> <span><?=$_box_data->description?></span><br>
							<br><b>KES <?=number_format($_box_data->price, 2)?></b><br>
							<span style="display:none;" class="alert alert-warning" id="vvv_<?=$_cart_item[0]?>">No enough boxes to service your order</span></td>
						<td><?=$util->ship_type_form($_cart_item[0], $_cart_item[2])?></td>
						<td><!------ Include the above in your HEAD tag ---------->
							
							<div class="center">
								<div class="input-group">
									<span class="input-group-btn">
                                            <button type="button" class="btn btn-number"  data-type="minus" data-field="quant_<?=$_cart_item[0]?>[2]"><i class="fas fa-minus"></i></button>
                                        </span>
									<input type="text" name="quant_<?=$_cart_item[0]?>[2]" class="form-control input-number cart_value" value="<?=$_cart_item[1]?>" min="1" max="10">
									<span class="input-group-btn">
                                            <button type="button" class="btn btn-number" data-type="plus" data-field="quant_<?=$_cart_item[0]?>[2]"><i class="fas fa-plus"></i></button>
                                        </span>
								</div>
							</div></td>
						<td><b>KES <?=number_format($_b_cost,2)?></b></td>
						<td><i onclick="remove_from_cart('<?=$_cart_item[0]?>')" class="fas fa-trash-alt del_icon"></i></td>
					</tr>
                                        <tr class="cart_border_bottom">
						<td colspan="6">
                                                    <small><i>* Physical delivery only available in Nairobi at present.</i></small>
                                                    <br>
                                                     <small><i>**  E-boxes are limited to one per order.</i></small>
                                                </td>
					</tr>
                                        
					<?php 
											}
							endforeach;
					}else{
							print '
							<tr>
									<td colspan="6">
											<small>*No items in cart.</small>
									</td>
							</tr>';
					}
          ?>
					<!-- <tr align="rightx" class="cart_totals tr_border_top">
						<td colspan="4" align="right"><span class="cart_totals_lbl">SHIPPING TOTAL</span></td>
						<td colspan="4" >KES ?=number_format($_total_shipping,2)?></td>
                                                
					</tr> -->
            <tr align="rightx" class="cart_totals tr_border_top cart_totals_large">
                    <td colspan="4" align="right "><span class="cart_totals_lbl">ORDER TOTAL (Incl. VAT)</span></td>
                    <td colspan="2">KES <?=number_format((array_sum($_total_cart)+$_total_shipping), 2)?></td>
            </tr>
            <tr align="right" class="cart_totals tr_border_top cart_totals_actions">
                    <td colspan="6"><a href="<?=$util->AppHome()?>"><img src="<?=$util->AppHome()?>/shared/img/btn-continue-shopping.png"></a> 
                        <a href="<?=$util->ClientHome()?>/user-dash-shipping.php"><img src="<?=$util->AppHome()?>/shared/img/btn-shipping-method-blue.png"></a></td>
            </tr>
				</table>
			</div>
		</div>
	</div>
</section>
<!--end desktop--> 
<!--start mobile-->
<section class="container section_padding_top mobile_view" id="yourDiv">
	<div class="row">
		<div class="col-md-12 no_pad_lr">
			<h3 class="user_blue_title cart_yellow_h_mob" >YOUR SHOPPING CART</h3> 
			<!--progress strip-->
		</div>
		<div class="col-md-12">
			<div class="width_100 cart_progress_strip">
				<div class="col-3 cart_strip">
				</div>
			</div>
			<!--end progress strip-->
			<div>
					<?php
					// $util->Show($_SESSION['curr_usr_cart']);
					?>
				<table class="p-2 cart-table table-borderless">
					<?php 
					// unset($_SESSION['curr_usr_cart']);
					if(!empty($_SESSION['curr_usr_cart'])){
							foreach($_SESSION['curr_usr_cart'] as $_cart_item ):
								if(isset($_cart_item['order_id'])){

								}elseif(isset($_cart_item['physical_address'])){

								}else{
								$raw_data = json_decode($box->get_byidf('00', $_cart_item[0]));
								$_box_data = $raw_data->data;
								$_b_cost = floor($_cart_item[1]*$_box_data->price);
								//$_total_cart[] = $_b_cost;
								//$_total_shipping = 0;
                                                                $_total_cart2[] = $_b_cost;
								$_total_shipping2 = 0;
								$_media = $picture->get_byitem('00', $_cart_item[0]);
								$_media = json_decode($_media, true)['data'];
								$_3d = 'shared/img/cart_img.png';
								foreach( $_media as $_mm ){
										if($_mm['type'] == '2'){$_3d = $_mm['path_name'];}
								}
					?>
					<tr id="reset_div_<?=$_cart_item[0]?>">
						<td class="pdt_img pdt_img_cart" style=""><img src="<?=$_3d?>" /></td>
						<td class="cart_des_mob"><h6><?=$_box_data->name?></h6> <span><?=$_box_data->description?></span><br><b>KES <?=number_format($_box_data->price, 2)?></b><br><span style="display:none;" class="alert alert-warning" id="vvv_<?=$_cart_item[0]?>">No enough boxes to service your order</span></td>
					</tr>
					<tr style="background:#00ACB31A;">
						<td><b>KES <?=number_format($_b_cost,2)?></b></td>
						<td><div class="center">
                            <div class="input-group">
                                    <span class="input-group-btn"><button type="button" class="btn btn-number"  data-type="minus" data-field="quant_<?=$_cart_item[0]?>[2]"><i class="fas fa-minus"></i></button></span>
                                    <input type="text" name="quant_<?=$_cart_item[0]?>[2]" class="form-control input-number cart_value" value="<?=$_cart_item[1]?>" min="1" max="10">
                                    <span class="input-group-btn"><button type="button" class="btn btn-number ongeza_btn" data-type="plus" data-field="quant_<?=$_cart_item[0]?>[2]"><i class="fas fa-plus"></i></button></span>
                            </div>
							</div></td>
					</tr>
					<tr>
						<td colspan="2" class="mob_shipping"><?=$util->ship_type_form($_cart_item[0], $_cart_item[2])?></td>
					</tr>
					<tr>
						<td><!-- <b>KES <?//=number_format($_b_cost,2)?></b>--></td>
						<td align="right"><img  onclick="remove_from_cart('<?=$_cart_item[0]?>')" class="" src="../shared/img/icn-delete-teal.svg"></td>
					</tr>
						</tr>
					
					<tr >
						<td colspan="2"><small><i>* Physical delivery only available in Nairobi at present.</i></small>
                                                    <br>
                                                      <small><i>**  E-boxes are limited to one per order.</i></small>
                                                </td>
					</tr>
					<?php 
											}
							endforeach;
					}else{
							print '
							<tr>
									<td colspan="2">
											<small>*No items in cart.</small>
									</td>
							</tr>';
					}
					?>
					<!-- <tr align="right " class="cart_totals tr_border_top">
						<td colspan="4"><span class="cart_totals_lbl">SHIPPING TOTAL</span></td>
						<td colspan="2">KES <=number_format($_total_shipping,2)?></td>
					</tr> -->
					<tr align="right" class="cart_totals tr_border_top">
                                            <td ><span class="cart_totals_lbl">ORDER TOTAL (Incl. VAT)</span></td>
						<td colspan="">KES <?=number_format((array_sum($_total_cart2)+$_total_shipping2), 2)?></td>
					</tr>
					<tr align="right" class="cart_totals tr_border_top cart_totals_actions">
						<td colspan="2 ">
                                                    <a href="<?=$util->AppHome()?>"><img src="<?=$util->AppHome()?>/shared/img/btn-continue-shopping.png"></a> 
                                                    <a href="<?=$util->ClientHome()?>/user-dash-shipping.php"><img src="<?=$util->AppHome()?>/shared/img/btn-shipping-method-blue.png"></a>
                                                </td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</section>

<!--end  mobile--> 
<!--end add to cart cards--> 
<!--our partners -->
<?php include '../shared/partials/partners.php'; ?>
<?php include '../shared/partials/footer.php'; ?>
<!-- Bootstrap core JavaScript -->
<?php include '../shared/partials/js.php'; ?>
</body>
</html>
<script>
   $(document).ready( function() {

    $('.btn-number').click(function(e){
        e.preventDefault();
        
        fieldName = $(this).attr('data-field');
        type      = $(this).attr('data-type');
        var input = $("input[name='"+fieldName+"']");
        var currentVal = parseInt(input.val());
        if (!isNaN(currentVal)) {
            if(type == 'minus') {
                
                if(currentVal > input.attr('min')) {
                    input.val(currentVal - 1).change();
                } 
                if(parseInt(input.val()) == input.attr('min')) {
                    $(this).attr('disabled', true);
                }

            } else if(type == 'plus') {

                if(currentVal < input.attr('max')) {
                    input.val(currentVal + 1).change();
                }
                if(parseInt(input.val()) == input.attr('max')) {
                    $(this).attr('disabled', true);
                }

            }
        } else {
            input.val(0);
        }
    });
    $('.input-number').focusin(function(){
    $(this).data('oldValue', $(this).val());
    });

    $('.input-number').change(function() {
        waitingDialog.show('Updating cart... please wait',{headerText:'',headerSize: 6,dialogSize:'sm'});
        minValue =  parseInt($(this).attr('min'));
        maxValue =  parseInt($(this).attr('max'));
        valueCurrent = parseInt($(this).val());
        name = $(this).attr('name');
        bx = name.split('_')[1];
        box = bx.split('[')[0];
        // ======== UPDATE CART =========
        var dataString = "internal_id=" + box + "&change_qty=1&qty=" + valueCurrent;
        $.ajax({
            type: 'post',
            url: '<?=$util->AjaxHome()?>?activity=add-to-cart',
            data: dataString,
            success: function(res){
                // console.log(res);
                var rtn = JSON.parse(res);
                if(rtn.hasOwnProperty("MSG")){
                    // $("#reset_div_" + box ).load(location.href+"  #reset_div"+ box +">*","");
                    // $("#yourDiv").load(" #yourDiv > *");
                    setTimeout(function(){
                        location.reload();
                    }, 100);
                    // $(".sttv").load(location.href + " .sttv" );
                    return;
                }
                else if(rtn.hasOwnProperty("ERR")){
                    $('#vvv_' + box ).text(rtn.ERR);
                    $('#vvv_' + box ).show();
                    waitingDialog.hide();
                    return;
                }
            }
        });
        //========= END UPDATE ==========
        console.log(box + " value= " + valueCurrent);
        if(valueCurrent >= minValue) {
            $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
        } else {
            alert('Sorry, the minimum value was reached');
            $(this).val($(this).data('oldValue'));
        }
        if(valueCurrent <= maxValue) {
            $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
        } else {
            alert('Sorry, the maximum value was reached');
            $(this).val($(this).data('oldValue'));
        }
    });
    $(".input-number").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
            // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) || 
            // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                // let it happen, don't do anything
                return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

    remove_from_cart = function(box){
        waitingDialog.show('Removing item... please wait',{headerText:'',headerSize: 6,dialogSize:'sm'});
        var dataString = "internal_id=" + box;
        $.ajax({
            type: 'post',
            url: '<?=$util->AjaxHome()?>?activity=remove-from-cart',
            data: dataString,
            success: function(res){
                // console.log(res);
                var rtn = JSON.parse(res);
                if(rtn.hasOwnProperty("MSG")){
                    // $("#yourDiv").load(" #yourDiv > *");
                    setTimeout(function(){
                        location.reload();
                    }, 100);
                    return;
                }
                else if(rtn.hasOwnProperty("ERR")){
                    $('#vvv_' + box ).text(rtn.ERR);
                    $('#vvv_' + box ).show();
                    waitingDialog.hide();
                    return;
                }
            }
        });
    }

    change_ship_type = function(id, uncheck=0){
        console.log(($('#'+id).val()));
        waitingDialog.show('Changing box type... please wait',{headerText:'',headerSize: 6,dialogSize:'sm'});
        var dataString = "internal_id=" + id;
        $.ajax({
            type: 'post',
            url: '<?=$util->AjaxHome()?>?activity=change-cart-box-type',
            data: dataString,
            success: function(res){
                console.log(res);
                var rtn = JSON.parse(res);
                if(rtn.hasOwnProperty("MSG")){
                    // $("#yourDiv").load(" #yourDiv > *");
                    setTimeout(function(){
                        location.reload();
                    }, 100);
                    return;
                }
                else if(rtn.hasOwnProperty("ERR")){
                    box = id.split('__')[1];
                    $('#vvv_' + box ).text(rtn.ERR);
                    $('#vvv_' + box ).show();
                    setTimeout(function(){
                        location.reload();
                    }, 5000);
                    waitingDialog.hide();
                    return;
                } 
            }
        });
    }

   });
</script>