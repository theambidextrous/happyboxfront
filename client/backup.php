<?php
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
$util = new Util();
?>
<!-- pop up -->
  <div class="modal fade" id="addedToCart">
    <div class="modal-dialog general_pop_dialogue added_tocart_dialogue">
        	
              
      <div class="modal-content">
   <a href="" data-dismiss="modal"> <img class="modal_close2" src="<?=$util->AppHome()?>/shared/img/icons/icn-close-window-blue.svg"></a> 
                       <div class="modal-body text-center">
                    <div class="col-md-12 text-center">
                        <h3>THIS BOX HAS BEEN ADDED TO YOUR CART</h3>   
                        <div >
                            <a href="" > <img class="" src="<?=$util->AppHome()?>/shared/img/btn-continue-shopping.svg"></a> 
                            <a href=""> <img class="" src="<?=$util->AppHome()?>/shared/img/btn-checkout.svg"></a> 
                        </div>
                       
                        </div>
      </div>
        
      </div>
    </div>
  </div>
   <script>
    $(document).ready(function(){
        $("#addedToCart").modal('show');
    });
</script>
<!-- end pop up -->