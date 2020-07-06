 
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
 <nav id="top" class="navbar navbar-expand-lg top-bar-logged-in text-white">
    <div class="container">
        <a class="navbar-brand" href="#"><img src="../shared/img/inverse-logo.png"> <span> | PARTNER PORTAL</span></a>
 
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"><i class="fas fa-tasks"></i></span>
      </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="nav navbar-nav ml-auto">
           <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
    <?=$_name?> <i class="fas fa-angle-down"></i> <img src="../shared/img/icons/icn-partner-full-white.svg" class="user_icon">
      </a>
      <div class="dropdown-menu drop_partner">
          <div class="card">
               <div class="card-body">
                   <div class="row partner_drop">
                  <div class="col-2">
                     <span><img src="../shared/img/icons/partneruser.svg" class="dropdown_user_img"></span>
                  </div>
                   <div class="col-10 text-white">
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
        <a href="" class="nav-link">
           <img src="../shared/img/icons/call_nav.svg" class="call_btn" data-toggle="tooltip" title="Hooray!"> 
        </a>
    </li>
    </ul>
  </div>
  </div>
</nav>
<section class="container section_padding_top top_menu">
            <div class="row">
                <div class="col-md-12">
                  <ul>
                        <li><a class="t-booking" href="partner-make-booking.php">Take A Booking</a></li>
                        <li><a class="t-voucher" href="partner-voucher-list.php">My Voucher List</a></li>
                        <li><a class="t-experience" href="partner-experience.php">My Experience List</a></li>
                        <?php if(json_decode($_SESSION['usr'])->user->id){?>
                            <li><a class="user-profmile" href="exit.php">Logout</a></li>
                        <?php } ?>
                    </ul>
                </div>

            </div>
        </section>
