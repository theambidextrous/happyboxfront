<?php 
//check current page to assign active nav
$ACTIVE_NAV='';
$CURR_PAGE=basename($_SERVER["SCRIPT_FILENAME"], '.php');
 $CURR_PAGE=$CURR_PAGE.'.php';
if($CURR_PAGE=='category-well-being.php'){
    $ACTIVE_NAV1='catwell_active_nav';
}
elseif ($CURR_PAGE=='category-gastronomy.php') {
    
    $ACTIVE_NAV2='catgas_active_nav';

}
elseif ($CURR_PAGE=='category-sports-adventure.php') {
    $ACTIVE_NAV3='catspor_active_nav';

}
elseif ($CURR_PAGE=='contact-us.php') {
    $ACTIVE_NAV4='contact_active_nav';

}
else{
    
}
$login_ = '<a class="nav-link" href="'.$util->ClientHome().'/user-login.php">  <img class="top-bar-nav-icon" src="'.$util->ClientHome().'/shared/img/icons/icn-user-teal.svg"> User Login</a>';
if(!empty(json_decode($_SESSION['usr'])->access_token) && $util->is_client()){
  $name_ = json_decode($_SESSION['usr_info'])->data->fname . ' ' .json_decode($_SESSION['usr_info'])->data->sname;
  $login_ = '<a class="nav-link" href="#">  <img class="top-bar-nav-icon" src="'.$util->ClientHome().'/shared/img/icons/icn-user-teal.svg"> '.$name_.'</a>';
}
?>
<!--<nav class="navbar navbar-expand-lg navbar-light static-top client-partner-nav">
    <div class="container top-bar">
      <a class="navbar-brand" href="<?=$util->ClientHome()?>/">
        <img src="<?=$util->ClientHome()?>/shared/img/logo.svg">
      </a>  
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
          <div class="form_search_nav_wrap"> <span><i class="fas fa-search"></i></span> <input type="text" name="" class="form-control form_search_nav"></div>
        <ul class="navbar-nav ml-auto top-bar-nav">
          <li class="nav-item">
              <?=$login_?>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?=$util->PartnerHome()?>/login.php"> <img src="<?=$util->ClientHome()?>/shared/img/icons/icn-partner-blue.svg"> Partner Portal</a>
          </li>
            <li class="nav-item ">
                <div class="nav-item-with-cart" id="reset_div">
                 <a class="nav-link" href="<?=$util->ClientHome()?>/user-dash-shoppingcart.php"> <img src="<?=$util->ClientHome()?>/shared/img/icons/icn-cart.svg"><span class="count"><?=count($_SESSION['curr_usr_cart'])?></span></a>   
                </div>
          </li>
        </ul>
      </div>
        </div>
    </div>
  </nav>-->


<nav class="navbar navbar-expand-lg navbar-light static-top client-partner-nav desktop_view">
	<div class="container top-bar">
		<a class="navbar-brand" href="<?=$util->ClientHome()?>/"> <img src="<?=$util->ClientHome()?>/shared/img/logo.svg"> </a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
		<div class="collapse navbar-collapse" id="navbarResponsive">
			<!--<div class="form_search_nav_wrap">
				<span><img src="<?=$util->ClientHome()?>/shared/img/icn-search.svg"></span>
				<input type="text" name="" class="form-control form_search_nav">
			</div>-->
			<ul class="navbar-nav ml-auto top-bar-nav">
				<li class="nav-item">
				<?php //$login_?>
				</li>
				<?php if(!empty($name_)){ ?>
				<li class="nav-item dropdown client_drop"> <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown"> <img src="<?=$util->ClientHome()?>/shared/img/icons/icn-user-teal.svg">
				<?=$name_?>
				</a>
				<div class="dropdown-menu">
					<a class="dropdown-item client_drop_1" href="<?=$util->ClientHome()?>/user-dash-profile.php">PROFILE</a> <a class="dropdown-item" href="exit.php">LOGOUT</a>
				</div>
				</li>
				<?php } else{ ?>
				<li class="nav-item"> <a class="nav-link cli_user_login" href="<?=$util->ClientHome()?>/user-login.php"> <img src="<?=$util->ClientHome()?>/shared/img/icons/icn-user-teal.svg"> <span class="cli_user_login">User Login</span></a> </li>
				<?php } ?>
				<!-- Dropdown --> 
				<!-- <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
         <?=$login_?>
      </a>
      <div class="dropdown-menu drop_down_user_login">
        <a class="dropdown-item" href="#">EDIT PROFILE</a>
        <a class="dropdown-item" href="#">LOGOUT</a>
     
      </div>
    </li>-->
				<li class="nav-item"> <a class="nav-link" href="<?=$util->PartnerHome()?>/login.php"> <img src="<?=$util->ClientHome()?>/shared/img/icons/icn-partner-blue.svg"> Partner Portal</a> </li>
				<li class="nav-item ">
				<div class="nav-item-with-cart" id="reset_div">
				<?php
				$CartCount = $util->cartCount();
				if( $CartCount > 0 ){
					?>
					<a class="nav-link" href="<?=$util->ClientHome()?>/user-dash-shoppingcart.php"> <img src="<?=$util->ClientHome()?>/shared/img/icons/icn-cart-red.svg"><span class="count text-danger"><?=$CartCount?>
					</span></a>
					<?php
				}else{
					?>
					<a class="nav-link" href="<?=$util->ClientHome()?>/user-dash-shoppingcart.php"> <img src="<?=$util->ClientHome()?>/shared/img/icons/icn-cart.svg"><span class="count"><?=$CartCount?>
					</span></a>
					<?php
				}
				?>
				</div>
				</li>
			</ul>
		</div>
	</div>
</nav>
<div class="container main-menu-wrap desktop_view">
	<div class="row">
		<div class="col-6 main-menu-left">
			<nav class="navbar navbar-expand-sm"> 
				<!-- Links -->
				<ul class="navbar-nav ">
					<li class="nav-item"> <a class="nav-link well_nav <?=$ACTIVE_NAV1;?>" href="<?=$util->ClientHome()?>/category-well-being.php">Well-Being</a> </li>
					<li class="nav-item"> <a class="nav-link gast_nav <?=$ACTIVE_NAV2;?>" href="<?=$util->ClientHome()?>/category-gastronomy.php">Gastronomy</a> </li>
					<li class="nav-item"> <a class="nav-link spor_nav <?=$ACTIVE_NAV3;?>" href="<?=$util->ClientHome()?>/category-sports-adventure.php">Sports & Adventure</a> </li>
				</ul>
			</nav>
		</div>
		<div class="col-6 main-menu-right">
			<nav class="navbar navbar-expand-sm navbar-rightmenu"> 
				<!-- Links -->
				<ul class="navbar-nav  ml-auto right_menu">
					<li class="nav-item"> <a class="nav-link contact_nav <?=$ACTIVE_NAV4;?>" href="<?=$util->ClientHome()?>/contact-us.php">Contact HAPPYBOX</a> </li>
					<li class="nav-item"> <a class="nav-link" href="<?=$util->ClientHome()?>/user-dash-activate-voucher.php"> <img src="<?=$util->ClientHome()?>/shared/img/icons/btn-register-your-voucher.svg"> </a> </li>
				</ul>
			</nav>
		</div>
	</div>
</div>
<!-- mobile view -->
<nav class="site-nav mobile_view"> <h1 class="logo"> <a href="<?=$util->ClientHome()?>/index.php"><img  class="logo_img" src="<?=$util->ClientHome()?>/shared/img/logo.svg"></a>
	<?php
	$CartCount = !empty($_SESSION['curr_usr_cart'])?count($_SESSION['curr_usr_cart']):0;
	if( $CartCount > 0 ){
		?>
        <a class="mob_cart" href="<?=$util->ClientHome()?>/user-dash-shoppingcart.php" ><img src="<?=$util->ClientHome()?>/shared/img/icons/icn-cart-red.svg"> <span class="count text-danger"><?=count($_SESSION['curr_usr_cart'])?>
		</span></a>
		<?php
	}else{
		?>
		<a class="mob_cart" ><img src="<?=$util->ClientHome()?>/shared/img/icn-cart.svg"> <span class="count"><?=count($_SESSION['curr_usr_cart'])?>
		</span></a>
		<?php
	}
	?>
	</h1>
	<div class="menu-toggle">
		<div class="hamburger">
		</div>
	</div>
	<ul class="open desktop opened_menu">
		<li> <a class="userlogin-nav-a" href="<?= $link; ?>user-login.php"> <img class="top-bar-nav-icon" src="<?= $link; ?>shared/img/icons/icn-user-teal.svg"> User Login</a></li>
		<li> <a class="partner-nav-a" href="<?=$util->PartnerHome()?>/login.php"> <img src="<?= $link; ?>shared/img/icons/icn-partner-blue.svg"> Partner Portal</a></li>
		<li> <a class="registervoucher-nav-a" href="<?=$util->ClientHome()?>/user-dash-activate-voucher.php"><i style="font-size: 23px;margin-right: 4px;" class="fas fa-gift"></i> Register your voucher </a> </li>
		<li > <a class="" href="<?=$util->ClientHome()?>/category-well-being.php">Well-Being</a> </li>
		<li> <a class="" href="<?=$util->ClientHome()?>/category-gastronomy.php">Gastronomy</a> </li>
		<li> <a class="" href="<?=$util->ClientHome()?>/category-sports-adventure.php">Sports & Adventure</a> </li>
		<li> <a class="" href="<?=$util->PartnerHome()?>/become-a-partner.php">Become A Partner</a> </li>
		<li> <a  href="<?=$util->ClientHome()?>/contact-us.php">Contact HAPPYBOX</a> </li>
		<li> <a href="#">Logout</a> </li>
		<li> <a href="#"></a> </li>
		<!--<li class="site-nav-seacrh"> <span>  <img src="<?=$util->ClientHome()?>/shared/img/icn-search.svg"></span>
		<input type="text" name="" class=" form_search_nav_mob" placeholder="Search">
		</li>-->
		<div class="menu-close">
			<img src="<?=$util->ClientHome()?>/shared/img/icn-close-window-blue.svg">
		</div>
	</ul>
</nav>
<!-- end mobile view --> 
