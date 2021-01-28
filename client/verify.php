<?php
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
require_once('../lib/Picture.php');
$util = new Util();
$user = new User();
$picture = new Picture();
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

        <title>HappyBox :: User Create Account Pop Up</title>

        <!-- Bootstrap core CSS -->
        <?php include '../shared/partials/css.php'; ?>
    </head>

   <body class="client_body">
        <!-- Navigation -->
        <?php include '../shared/partials/nav.php'; ?>
        <!-- Page Content --> 

        <section class=" user_account">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h3 class="text-white">ACCOUNT ACTIVATED</h3>         
                    </div>

                </div> </div>
        </section>
        <section class=" user_account_sub_banner">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-9 text-center">
                        <h4 class=""><?php
                        if(!empty($_REQUEST['success'])){
                           // print ucwords(strtolower($_REQUEST['success'].'!'));?>
                             
                            <h5 class=""> Email Successfully Verified! <br>You can login. </h5>
                            
                       <?php }
                        ?></h4>

                    </div>

                </div> </div>
        </section>

        <!--end discover our selection-->
        <section class="container section_padding_top contact_content" id="reset_div">
            <div class="row justify-content-center">
                <div class="col-md-5 user_login_l  ">

                </div>
                <div class="col-md-5  user_login_r">
                    <div class=" user_create_r">
                    </div>
                </div>
            </div>
        </section>
        <!--end add to cart cards-->
        <!--our partners -->

        <?php include '../shared/partials/partners.php'; ?>
        <?php include '../shared/partials/footer.php'; ?>

        <!-- Bootstrap core JavaScript -->

        <?php include '../shared/partials/js.php'; ?>
        <!-- pop up -->
        <button type="button" id="popupid" style="display:none;" class="btn btn_rounded" data-toggle="modal" data-target="#userCreatedModal"></button>
        <div class="modal fade" id="userCreatedModal">
            <div class="modal-dialog general_pop_dialogue">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <div class="col-md-12 text-center forgot-dialogue-borderz">
                            <h3 class="partner_blueh">YOU HAVE SUCCESSFULLY CREATED YOUR ACCOUNT!</h3>
                            <p class="forgot_des text-center txt-orange">A confirmation email has been sent to you. Please click on the link to activate your account.</p><div><img src="<?=$util->AppHome()?>/shared/img/btn-okay-blue.svg" class="password_ok_img" data-dismiss="modal"/></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end pop up -->
<script>
  $(document).ready(function(){
    new_account = function(FormId){
    waitingDialog.show('creating... Please wait',{headerText:'',headerSize: 6,dialogSize:'sm'});
    var dataString = $("form[name=" + FormId + "]").serialize();
    $.ajax({
        type: 'post',
        url: '<?=$util->AjaxHome()?>?activity=new-account',
        data: dataString,
        success: function(res){
            console.log(res);
            var rtn = JSON.parse(res);
            if(rtn.hasOwnProperty("MSG")){
                $("#reset_div").load(window.location.href + " #reset_div" );
                $('#popupid').trigger('click');
                waitingDialog.hide();
                return;
            }
            else if(rtn.hasOwnProperty("ERR")){
                $('#err').text(rtn.ERR);
                $('#err').show(rtn.ERR);
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
