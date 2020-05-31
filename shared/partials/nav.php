<nav class="navbar navbar-expand-lg navbar-light static-top client-partner-nav">
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
              <a class="nav-link" href="<?=$util->ClientHome()?>/user-login.php">  <img class="top-bar-nav-icon" src="<?=$util->ClientHome()?>/shared/img/icons/icn-user-teal.svg"> User Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?=$util->PartnerHome()?>/login.php"> <img src="<?=$util->ClientHome()?>/shared/img/icons/icn-partner-blue.svg"> Partner Portal</a>
          </li>
            <li class="nav-item ">
                <div class="nav-item-with-cart">
                 <a class="nav-link" href="#"> <img src="<?=$util->ClientHome()?>/shared/img/icons/icn-cart.svg"><span class="count">2</span></a>   
                </div>
          </li>
        </ul>
      </div>
        </div>
    </div>
  </nav>
<div class="container main-menu-wrap">
    <div class="row">
          <div class="col-6 main-menu-left">
             <nav class="navbar navbar-expand-sm">
                <!-- Links -->
                <ul class="navbar-nav ">
                  <li class="nav-item">
                    <a class="nav-link" href="<?=$util->ClientHome()?>/category-well-being.php">Well-Being</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="<?=$util->ClientHome()?>/category-gastronomy.php">Gastronomy</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="<?=$util->ClientHome()?>/category-sports-adventure.php">Sports & Adventure</a>
                  </li>
                </ul>
              </nav>
          </div>
          <div class="col-6 main-menu-right">
            <nav class="navbar navbar-expand-sm navbar-rightmenu">
              <!-- Links -->
              <ul class="navbar-nav  ml-auto right_menu">
                <li class="nav-item">
                  <a class="nav-link" href="<?=$util->ClientHome()?>/contact-us.php">Contact HAPPYBOX</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="user-dash-activate-voucher.php">
                      <img src="<?=$util->ClientHome()?>/shared/img/icons/btn-register-your-voucher.svg">
                    </a>
                </li>
              </ul>
            </nav>
        </div>
 </div></div></div>