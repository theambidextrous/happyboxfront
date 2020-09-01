<?php
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
require_once('../lib/Topic.php');
require_once('../lib/Picture.php');
$util = new Util();
$user = new User();
$topic = new Topic();
$picture = new Picture();
$util->ShowErrors(1);
$topics = $topic->get('00');
// $util->Show($topics);
$topics = json_decode($topics, true)['data'];
$_partners_slide_data = json_decode($user->get_ptn_inf_all(), true)['data'];
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Happy Box:: Become a partner</title>
  <!-- Bootstrap core CSS -->
 <?php include '../shared/partials/css.php'; ?>

</head>

<body>
  <!-- Navigation -->
 <?php include '../shared/partials/nav.php'; ?>
 <section  class="blue_band text-center">
			<h2 class="">HAPPYBOX PARTNER PORTAL</h2>
			</section>
  <!--desktop-->
  <section  class="green_strip text-center desktop_view">
			<h4 class="partner_blue2">Becoming a HAPPYBOX partner means you are always a winner!</h4>
			</section>
  
<section class=" text-center desktop_view">
            <div class="container">
		
               
                    <div class="row justify-content-center become_boxes">
                    <div class="col-md-6">
                        <div class="become_card become_card1">
                           <div class="become_card_txt">Free advertising year round on our website and in our boxes</div>
                            <img src="../shared/img/becomecard1a.svg" class=""/>
                            
                        </div>		
                        </div>
                         <div class="col-md-6">
                        <div class="become_card become_card2">
                       <span class="become_card_txt">Zero upfront cost, Zero cash out, Zero investment</span>
                           
                            <img src="../shared/img/become-card2.svg" class=""/>
                            
                        </div>		
                        </div>
                          <div class="col-md-6">
                        <div class="become_card become_card3">
                           <span class="become_card_txt">Increase your turnaround by attracting a new typology of clientele</span>
                            <img src="../shared/img/become-card3.svg" class=""/>
                            
                        </div>		
                        </div>
                          <div class="col-md-6">
                        <div class="become_card become_card4">
                        <span class="become_card_txt">Easy going partnership with Zero constraint, 100% independence on your bookings, all made under your T&C’s</span>
                            <img src="../shared/img/become-card4.svg" class=""/>
                            
                        </div>		
                        </div>
                         <div class="col-md-12 text-center">
                             <button class="btn btn-block btn-zero">0% RISK AND 100% WIN  <img src="../shared/img/icons/icn-arrow-blue.svg" class="become_arrow"/></button>	
                        </div>

                </div>
              </div>
        </section>
  <!--mobile-->
  <section  class="green_strip text-center mobile_view">
			<h4 class="partner_blue2 mob_bold">Becoming a HAPPYBOX partner means you are always a winner!</h4>
			</section>
  
<section class=" text-center mobile_view">
            <div class="container">
		
               
                    <div class="row justify-content-center become_boxes">
                    <div class="col-12 no_padd">
                        <div class="become_card become_card1">
                           <div class="become_card_txt">Free advertising year round on our website and in our boxes</div>
                          
                            
                        </div>		
                        </div>
                         <div class="col-12 no_padd">
                        <div class="become_card become_card2">
                       <span class="become_card_txt">Zero upfront cost, Zero cash out, Zero investment</span>
                    
                            
                        </div>		
                        </div>
                          <div class="col-12 no_padd">
                        <div class="become_card become_card3">
                           <span class="become_card_txt">Increase your turnaround by attracting a new typology of clientele</span>
                           
                            
                        </div>		
                        </div>
                          <div class="col-12 no_padd">
                        <div class="become_card become_card4">
                        <span class="become_card_txt">Easy going partnership with Zero constraint, 100% independence on your bookings, all made under your T&C’s</span>
                         
                            
                        </div>		
                        </div>
                         <div class="col-md-12 text-center desktop_view">
                             <button class="btn btn-block btn-zero">0% RISK AND 100% WIN  <img src="../shared/img/icons/icn-arrow-blue.svg" class="become_arrow"/></button>	
                        </div>
                          <div class="col-md-12 text-center mobile_view btn_zero_mob">
                             0% RISK AND 100% WIN  <img src="../shared/img/icons/icn-arrow-blue.svg" class="become_arrow"/>	
                        </div>

                </div>
              </div>
        </section>
  
    <section class="pad_top20 desktop_view">
                     <div class="container-fluid">
                    <div class="row ">
                        <div class="col-md-12">
                               <img src="../shared/img/become_part_img.svg" class="become_part_floating_img desktop_view"/>
                            
                        </div> </div></div>
                
    </section>
    <section class="pad_top20 mobile_view">
                     <div class="container-fluid">
                    <div class="row ">
                        <div class="col-md-12">
                            
                               <img src="../shared/img/becomeHappyMob.svg" class="happy_become_mobile"/>
                            
                        </div> </div></div>
                
    </section>
  <!--become partner steps-->
  <section class=" text-center become_partner_steps pad_top20">
            <div class="container">
		
               
                    <div class="row ">
                    <div class="col-md-6">
                        <div class="card become_part_card">
                            <div>
                                <span class="become_badge">1</span>
                            </div>
                            <div class="become_part_card_txt">
                                <h4>  Sign your contract and annex</h4>
                         We will support you in defining the best set of services you want to promote.         
                                
                            </div>                          
                        </div>  
                    </div>
       <div class="col-md-6">
                        <div class="card become_part_card">
                            <div>
                                <span class="become_badge">2</span>
                            </div>
                            <div class="become_part_card_txt">
                                <h4>  Check and control your promoted services</h4>
                       Through your Partner Portal personalised access.        
                                
                            </div>                          
                         </div>
   </div>
       <!--row 2-->
<div class="col-md-6">
                        <div class="card become_part_card">
                            <div>
                                <span class="become_badge">3</span>
                            </div>
                            <div class="become_part_card_txt">
                                <h4>  Your services are published and promoted</h4>
               On our website and our boxes.
                                
                            </div>                           
                        </div>
  
       </div>
       <div class="col-md-6">
                        <div class="card become_part_card">
                            <div>
                                <span class="become_badge">4</span>
                            </div>
                            <div class="become_part_card_txt">
                                <h4>      Execute the service</h4>
                    Get paid once the service has been executed.        
                                
                            </div>
                             
                            
                            
                        </div>
  
       </div>
       <!--3-->
       <div class="col-md-6">
                        <div class="card become_part_card">
                            <div>
                                <span class="become_badge">5</span>
                            </div>
                            <div class="become_part_card_txt">
                                <h4>    Execute the service</h4>
                      Get paid once the service has been executed.         
                                
                            </div>                           
                        </div>
  
       </div>
       <div class="col-md-6">
                        <div class="card become_part_card">
                            <div>
                                <span class="become_badge">6</span>
                            </div>
                            <div class="become_part_card_txt">
                                <h4>Our Partner Care Team is available alongside you at each step.</h4>
                                
                            </div>
                             
                            
                            
                        </div>
  
       </div>
       <!--4-->
       <div class="col-md-6">
                        <div class="card become_part_card card_step_blue">
                            <div class="card_step_blue_txt text-white"> These Partners trust us with their promotion </div>
                        
                                                    
                        </div>
  
       </div>
       <div class="col-md-6 nomargin_lr">
                        <div class="become_logos row row_no_margin">
                        <?php 
                        //data dynamic
                            $_cnt = 1;
                            foreach( $_partners_slide_data as $_partners_slide ):
                                $_is_Active = json_decode($user->get_is_active($_partners_slide['userid']))->is_active->is_active;
                                if($_is_Active && $_cnt < 5){
                                    $_ptn_pic = json_decode($picture->get_byitem_one('00', $_partners_slide['internal_id']))->data;
                                    $_ptn_lg_path = $util->AppUploads().'profiles/'.$_partners_slide['picture'];
                                    if($_ptn_pic->path_name){
                                        $_ptn_lg_path = $_ptn_pic->path_name;
                                    }
                         ?>
                            <div class="col-3 ">
                                <div class="become_logos_item">
                                    <div class="">
                                        <img style="width:113px;height:auto;" src="<?=$_ptn_lg_path?>" alt="<?=$_partners_slide['business_name']?>">
                                    </div>
                                </div>                           
                            </div> 
                                <?php
                                    $_cnt++;
                                    }
                                endforeach;
                                ?>  
                        </div>
  
       </div>
                </div>
              </div>
        </section>
    <section class=" text-center" id="reset_div">
            <div class="container sound_good_wrap">
			<div class="col-md-12 sound_good">
                <div class="row justify-content-center ">
                    <div class="col-md-10">
                          <h3 class="partner_blueh">Sound Good?</h3>
                          <p class="forgot_des text-center sound_p">Complete the form below to become a HAPPYBOX Partner.</p>
                          <?=$util->msg_box()?>
                    </div>
                      <div class="col-md-10">
                          <div class="row justify-content-center become_partner_form">
                              <div class="col-md-5 become_partner_form">
                                <form class="" id="create_ptn_acc" name="create_ptn_acc">
                                    <div class="form-group">
                                        <label class="text-left">Company Name</label>
                                        <input type="text" name="business_name" class="form-control rounded_form_control" placeholder="Required Field">
                                    </div>
                                    <div class="form-group">
                                        <label class="text-left">Company Registration No.</label>
                                        <input type="text" name="business_reg_no" class="form-control rounded_form_control" placeholder="Required Field">
                                    </div>
                                    <div class="form-group">
                                        <label>Contact Person's Name</label>
                                        <input type="text" name="fname" class="form-control rounded_form_control" placeholder="Required Field">
                                    </div>
                                    <div class="form-group">
                                        <label>Email Address</label>
                                        <input type="email" name="email" class="form-control rounded_form_control" placeholder="Required Field">
                                    </div>
                                    <div class="form-group">
                                        <label>Contact Mobile Number</label>
                                        <input type="text" name="phone" class="form-control rounded_form_control" placeholder="Required Field">
                                    </div>
                                </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>Business Category</label>
                                            <select name="business_category" class="form-control rounded_form_control">
                                                <option value="nn">Select category</option>
                                                <?php
                                                    foreach( $topics as $_topic ){
                                                        print '<option value="'.$_topic['name'].'">'.$_topic['name'].'</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="text-left">Business Short Description</label>
                                            <input type="text" name="short_description" class="form-control rounded_form_control" placeholder="Required Field">
                                        </div>
                                        <div class="form-group">
                                            <label>Contact Person's Surname</label>
                                            <input type="text" name="sname" class="form-control rounded_form_control" placeholder="Required Field">
                                        </div>
                                        <div class="form-group">
                                            <label>Business Location</label>
                                            <select name="location" id="location" class="form-control rounded_form_control" id="select_box_type">
                                                <option value="nn">Select location</option>
                                                <?php 
                                                foreach($util->locations_list() as $_loc ){
                                                    print '<option value="'.$_loc.'">'.$_loc.'</option>';
                                                } ?>
                                            </select>
                                        </div>
                                        <div class="form-group" id="sub_location" style="display:none;">
                                            <label>Sub location</label>
                                            <input type="text" name="sub_location" class="form-control rounded_form_control" id="select_box_type"/>
                                        </div>
                                        <p class="text-right text-right-mob-center">
                                        <button type="button" onclick="create_account('create_ptn_acc')" name="becomeptn" class="btn btn_rounded become_dark_blue_btn btn-dark-blue">BECOME A PARTNER</button>
                                    </p></div>
                                </form>
                              
                              
                          </div>
                        
                    </div>
                    
                </div>    </div>
              
		
               
                </div>
    </section>
  <?php include '../shared/partials/partners.php';?>
  
   <!--end become partner steps-->
   <!--start sound good-->
   
   <!--end start good-->

<?php include '../shared/partials/footer.php';?>
  <!-- Page Content -->

  <!-- Bootstrap core JavaScript -->
  
<?php include '../shared/partials/js.php';?>
</body>
 <!-- pop up -->
 <button type="button" id="popupid" style="display:none;" class="btn btn_rounded" data-toggle="modal" data-target="#becomePart"></button>
 <div class="modal fade" id="becomePart">
    <div class="modal-dialog general_pop_dialogue">
      <div class="modal-content">
            <div class="modal-body text-center">
            <div class="col-md-12 text-center forgot-dialogue-borderz">
            <h3 class="partner_blueh">YOUR REQUEST HAS BEEN SENT</h3>
            <p class="forgot_des text-center">
            Thank you for your interest in a partnership with HAPPYBOX!  <br><br>
            Our Partner Care Team will review your submission and contact you.
            </p>
            <div>
            <img src="../shared/img/btn-okay-blue.svg" class="password_ok_img" data-dismiss="modal"/>
            </div>
            </div>
      </div>
      </div>
    </div>
  </div>
  <script>  
    $(document).ready(function(){
        $('#location').on('change', function() {
        if ( this.value == 'nn'){ $("#sub_location").hide(); }
        else{ $("#sub_location").show(); }
        });
   
      create_account = function(FormId){
      waitingDialog.show('sending... Please wait',{headerText:'',headerSize: 6,dialogSize:'sm'});
      var dataString = $("form[name=" + FormId + "]").serialize();
      $.ajax({
          type: 'post',
          url: '<?=$util->AjaxHome()?>?activity=new-account-ptn',
          data: dataString,
          success: function(res){
              // console.log(res);
              var rtn = JSON.parse(res);
              if(rtn.hasOwnProperty("MSG")){
                  $("#reset_div").load(" #reset_div > *");
                    // $("#reset_div").load(location.href + " #reset_div" );
                    $('#popupid').trigger('click');
                    setTimeout(function(){
                        location.reload();
                    }, 3000);
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
</html>


