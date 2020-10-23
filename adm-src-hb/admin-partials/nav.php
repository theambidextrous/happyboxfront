<?php 

 $user_root = json_decode($_SESSION['usr']);
  $user_info = json_decode($_SESSION['usr_info']);
  // print_r($user_info);
  //$profile_pic_  = $util->AppUploads() . 'profiles/default.jpg';
  $_name = json_decode($_SESSION['usr'])->user->username;
  $_email = json_decode($_SESSION['usr'])->user->email;
 /* if($user_info->data->picture != 'default.jpg'){
    $profile_pic_  = $user_info->data->picture;
  }*/
  $profile_pic_="img/admin_user_icon.svg";
  $dropdown_user_icon="img/drop_user.svg";
   $dropdown_arrow="img/user_drop.svg";
  if($user_info->data->id > 0){
    $_name = $user_info->data->fname . ' ' . $user_info->data->sname;
  }

?>
<nav id="top" class="navbar navbar-expand-lg navbar-light bg-admin text-white">
    <div class="container">
        <a class="navbar-brand" href="#"><img src="img/inverse-logo.png"> <span> | ADMINISTRATOR PORTAL</span></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="nav navbar-nav ml-auto">
           <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle admin_name_txt" href="#" id="navbardrop" data-toggle="dropdown">
     <?=$_name;?> <img src="<?=$dropdown_arrow?>"  class="user_icon_drop"> <img src="<?=$profile_pic_?>" class="user_icon rounded-circle">
      </a>
      <div class="dropdown-menu">
          <div class="card">
               <div class="card-body">
                   <div class="row">
                  <div class="col-2">
                     <span><img src="<?=$dropdown_user_icon?>" class="dropdown_user_img rounded-circle"></span>
                  </div>
                   <div class="col-10 admin_drop_details">
                   <span class="user_dropdown_txt"><?=$_name;?></span>
                 
                   <span class="email_dropdown">
                   <?=$_email;?>
                   </span>
                  </div>
                      </div>
                  
                   
             
               </div>
              <div class="card-footer">
                                    <div class="row text-center row_no_margin">
                  <div class="col-6 drop_down_profile drop_down_footer_col">
                     <a href="<?=$util->AdminHome()?>/admin-profile.php">EDIT PROFILE</a>
                  </div>
                   <div class="col-6 drop_down_logout drop_down_footer_col">
                                   <a href="<?=$util->AdminHome()?>/exit.php">LOGOUT</a>

                  </div>
                      </div>
              </div>
          </div>
       
     
      </div>
    </li>
    </ul>
  </div>
  </div>
</nav>