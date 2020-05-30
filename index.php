<?php
    session_start();
    require_once('lib/Util.php');
    require_once('lib/User.php');
    $util = new Util();
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Happy Box:: Staging</title>
        <!-- Bootstrap core CSS -->
        <?php include 'adm-src-hb/admin-partials/css.php'; ?>
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

    <body class="admin-login" style="background: rgb(235, 238, 241);">
        <section>
        <div class="mt-5 pb-5 container">
            <div class="justify-content-center row">
                <div class="col-md-8 col-lg-5">
                    <div class="border-0 card" style="background: transparent;color: #fff;">
                        <div class="bg-transparent  card-header">
                            <div class="text-muted text-center mt-2 mb-1">
                                <h1>Happy Box:: Staging</h1>
                                <p>If you seeing this, it means Happybox.ke is in staging environment. Orders made will not be fulfilled</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 row">
                        <div class="col-md-3">
                            <a class="text-light btn btn-primary" target="_blank" href="<?=$util-> AdminHome()?>"> Admin</a>
                        </div>
                        <div class="col-md-3">
                            <a class="text-light btn btn-primary" href="#">Partner</a>
                        </div>
                        <div class="col-md-3">
                            <a class="text-light btn btn-primary" href="#">Customer</a>
                        </div>
                        <div class="col-md-3">
                            <a class="text-light btn btn-primary" href="#">Website</a>
                        </div>
                    </div>
                        </div>
                    </div>
                </div>
            </section>
        <!-- Bootstrap core JavaScript -->
        <?php include 'adm-src-hb/admin-partials/js.php'; ?>
    </body>

</html>
