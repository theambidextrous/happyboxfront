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
        // print($login);
       if(isset(json_decode($login)->status)){
            if(json_decode($login)->status == '0'){
                $_SESSION['usr'] = $login;
                $info = $user->get_details(json_decode($login)->user->id);
                $_SESSION['usr_info'] = $info;
                if(!$util->is_admin()){
                    throw new Exception('Permission denied!');
                    session_destroy();
                }
                $util->redirect_to('admin-box-inventory.php');
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
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Happy Box:: Admin Login</title>
        <!-- Bootstrap core CSS -->
        <?php include 'admin-partials/css.php'; ?>
        <style>
        .admin-login{
            background: rgb(194, 31, 43); 
        }
           .login-logo img{
  height: 40px;
    margin-top: 50px;
    margin-bottom: 30px
}
.login-btn{
    background: #00ACB3 0% 0% no-repeat padding-box;
    border-radius: 13px;
    color: white !important;
    padding: 5px 16px;
    font-size: 15px;
}
        </style>

    </head>

    <body class="admin-login">

           <section>
            <div class="mt-5 pb-5 container">
                <div class="justify-content-center row">
                    <div class="col-md-7 col-lg-5">
                         <div class="text-center login-logo">
                                    <img src="img/inverse-logo.png">
                                    </div>
                        <div class=" shadow border-0 card">
                            <div class="bg-transparent  card-header">
                                <div class="text-muted text-center mt-2 mb-3">
                                    <h4>Admin Sign in</h4></div>
                                
                                       </div>
                                    <div class="px-lg-5 py-lg-5 card-body">
                                        <?=$err?>
                                        <form role="form" class="" method="post">
                                            <div class="mb-3 form-group">
                                                <div class="input-group-alternative input-group">
                               <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-envelope"></i></span></div>
                               <input placeholder="Email" name="email" type="email" class="form-control"></div></div>
                               <div class="form-group"><div class="input-group-alternative input-group">
                                   <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-lock-open"></i></span></div>
                                   <input placeholder="Password" name="password" type="password" class="form-control"></div></div>
                                   <div class="custom-control custom-control-alternative custom-checkbox">
                                       <input class="custom-control-input" id=" customCheckLogin" type="checkbox">
                                       <label class="custom-control-label" for=" customCheckLogin"><span class="text-muted">Remember me</span></label></div>
                                       <div class="text-center"><button type="submit" class="btn login-btn" name="login">Sign in</button></div></form></div></div>
                                       <div class="mt-3 row"><div class="col-6"><a class="text-light" href="javascript();"></a></div>
                                       <div class="text-right col-6"><a class="text-light" href="/auth/register"></a></div>
                                       </div></div></div></div>
        </section>
        






      


        <!-- Bootstrap core JavaScript -->

        <?php include 'admin-partials/js.php'; ?>





    </body>

</html>
