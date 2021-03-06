<?php
    session_start();
    require_once('../lib/Util.php');
    require_once('../lib/User.php');
    $util = new Util();
    // $util->ShowErrors();
    $err = $msg = '';
    if(isset($_POST['login'])){
      try{
          $user = new User(null, $_POST['email'], $_POST['password']);
          $login = $user->login();
         if(isset(json_decode($login)->status)){
              if(json_decode($login)->status == '0'){
                  $_SESSION['usr'] = $login;
                  $info = $user->get_details(json_decode($login)->user->id);
                  $_SESSION['usr_info'] = $info;
                  if(!$util->is_partner()){
                      throw new Exception('Permission denied!');
                      session_destroy();
                  }
                  $util->redirect_to('partner-make-booking.php');
              }else{
                  $err = $util->error_flash(json_decode($login)->message);
              }
         }else{
          $err = $util->error_flash('No response from server');
         }
      }catch(Exception $e){
          $err = $util->error_flash($e->getMessage());
          session_destroy();
      }
     }
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
  <title>Happy Box:: Partner Login</title>
  <!-- Bootstrap core CSS -->
 <?php include '../shared/partials/css.php'; ?>
</head>
<body class="partner_wrap">
  <!-- Navigation -->
 <?php include '../shared/partials/nav.php'; ?>
 <section  class="blue_band text-center">
			<h2 class="">HAPPYBOX PARTNER PORTAL</h2>
			</section>
<section class=" text-center  section_60 partner_login">
          <div class="container">
        <div class="row justify-content-center">
        <div class="col-md-4 text-center ">
          <h3 class="partner_blueh">PARTNER LOGIN</h3>
            <form class="p_login" method="post">
                <?=$err?>
              <div class="form-group ">
                <input type="text" class="form-control mob_center rounded_form_control" name="email" placeholder="Email address">
              </div>
              <div class="form-group ">
                <input type="password" name="password" class="form-control mob_center rounded_form_control" placeholder="Password">
              </div>
              <button type="submit" name="login" class="btn btn_rounded">LOGIN</button>
              <p class="text-center gray_text small_p_margin_top">
                <a href="forgot.php">Forgot password?</a>
                  <a class="desktop_view " href="become-a-partner.php">| Not a registered partner? SIGN UP</a>
                  <br>
                <a class="mob_top_space mobile_view gray_text_mob" href="become-a-partner.php"> Not a registered partner? SIGN UP</a>
              </p>
            </form>
          </div>
                </div>
              </div>
        </section>


<?php include '../shared/partials/footer.php';?>
  <!-- Page Content -->

  <!-- Bootstrap core JavaScript -->
  
<?php include '../shared/partials/js.php';?>
   
  
 
 

</body>

</html>
