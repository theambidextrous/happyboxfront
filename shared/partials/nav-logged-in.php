 
 <?php 
  $user_info = json_decode($_SESSION['usr_info']);
  // print_r($user_info);
  $profile_pic_  = $util->AppUploads() . 'profiles/default.jpg';
  $_name = json_decode($_SESSION['usr'])->user->username;
  if($user_info->data->picture != 'default.jpg'){
    $profile_pic_  = $user_info->data->picture;
  }
  if($user_info->data->id > 0){
    $_name = $user_info->data->business_name;
  }
  // echo $profile_pic_;
?>
 <nav id="top" class="navbar navbar-expand-lg top-bar-logged-in text-white desktop_view">
    <div class="container">
        <a class="navbar-brand" href="#"><img src="../shared/img/happybox-logo-white.svg"> <span> | PARTNER PORTAL</span></a>
 
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"><i class="fas fa-tasks"></i></span>
      </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="nav navbar-nav ml-auto">
           <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
          
    <?=$_name?> <img src="../shared/img/menu_drop.svg" class="menu_drop"> <img src="../shared/img/icons/icn-partner-full-white.svg" class="user_icon">
      </a>
      <div class="dropdown-menu drop_partner">
          <div class="card">
               <div class="card-body">
                   <div class="row partner_drop">
                  <div class="col-2 no_pad_left no_pad_right">
                     <span><img src="../shared/img/icons/partneruser.svg" class="dropdown_user_img"></span>
                  </div>
                   <div class="col-10 text-white partner_pro_data no_pad_left">
                       <span><b><?=$_name?></b></span>
                   <span class="email_dropdown"><?=json_decode($_SESSION['usr'])->user->email?></span>
                  </div>
                      </div>
               </div>
                  <div class="row text-center row_no_margin">
                  <div class="col-6 drop_down_profile drop_down_footer_col">
                      <a href="partner-edit-profile.php">EDIT PROFILE</a>
                  </div>
                      <div class="col-6 drop_down_logout drop_down_footer_col">
                                           <a href="exit.php">LOGOUT</a>

                  </div>
                   
                    </div>
          </div>
      </div>
    </li>
    <li class="nav-item ">
       <!--  <a href="" class="nav-link">
           <img src="../shared/img/icons/call_nav.svg" class="call_btn" data-toggle="tooltip" title="Hooray!"> 
        </a>-->
         <a href="tel:+254112454540" class="nav-link tooltips">
             <img src="../shared/img/icons/call_nav.svg" class="call_btn"> <span>Contact Partner Care Team<br>
             Tel:+254 112 454 540</span>
        
        </a>
    </li>
    </ul>
  </div>
  </div>
</nav>
<!-- mobile view -->
      <nav class="site-nav mobile_view">
            <h1 class="logo">  <a href="<?=$util->ClientHome()?>/index.php">
            <img  class="logo_img" src="<?=$util->AppHome()?>/shared/img/logo.svg">
        </a>
               <!--  <a class="mob_cart" >
            <img src="<?=$util->ClientHome()?>/shared/img/icn-cart.svg"> <span class="count"><?=count($_SESSION['curr_usr_cart'])?></span>
        </a>-->
            
            </h1>
          

            <div class="menu-toggle">
              <div class="hamburger"></div>
            </div>

    <ul class="open desktop opened_menu">
        <li>  <a class="userlogin-nav-a" href="<?=$util->PartnerHome()?>/partner-make-booking.php">   How it Works</a></li>

       <li >
                <a class="" href="<?=$util->PartnerHome()?>/partner-make-booking.php#mob-val">Take A Booking: Check Validity</a>
            </li>
             <li >
                <a class="" href="<?=$util->PartnerHome()?>/partner-voucher-list.php">My Voucher List</a>
            </li>
            <li>
                <a class="" href="<?=$util->PartnerHome()?>/partner-experience.php">My Experience List</a>
            </li>
            <li>
                <a class="" href="<?=$util->PartnerHome()?>/partner-edit-profile.php">Edit Profile</a>
            </li>
             <li>
                <a class="" href="">Contact Partner Care Team</a>
            </li>
            <li>
                <a class="" href="exit.php">Logout</a>
            </li>
            
             <div class="menu-close">
   <img src="<?=$util->AppHome()?>/shared/img/icn-close-window-blue.svg">
    </div>
    </ul>
        </nav>
      <!-- end mobile view -->
<section class=" section_padding_top top_menu desktop_view">
    <div class="container">
            <div class="row">
                <div class="col-md-12">
                  <ul>
                        <li><a class="t-booking" href="partner-make-booking.php">Take A Booking</a></li>
                        <li><a class="t-voucher" href="partner-voucher-list.php">My Voucher List</a></li>
                        <li><a class="t-experience" href="partner-experience.php">My Experience List</a></li>
                        <?php //if(json_decode($_SESSION['usr'])->user->id){?>
                          <!--  <li><a class="user-profmile" href="exit.php">Logout</a></li>-->
                        <?php // } ?>
                    </ul>
                </div>

            </div></div>
        </section>
