<ul class="">
    <li><a class="user-register" href="user-dash-activate-voucher.php">Register Your Voucher</a></li>
    <li><a class="user-vlist" href="user-voucher-list.php">My Voucher List</a></li>
    <li><a class="user-vhistory" href="user-dash-purchase-history.php">My Purchase History</a></li>
    <li><a class="user-profile" href="user-dash-profile.php">My Profile</a></li>
    <?php if(isset($_SESSION['usr']) && json_decode($_SESSION['usr'])->user->id){?>
        <li><a class="user-profmile" href="exit.php">Logout</a></li>
    <?php } ?>
</ul>