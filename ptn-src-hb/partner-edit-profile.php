<?php
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
require_once('../lib/Topic.php');
$util = new Util();
$user = new User();
$topic = new Topic();
$token = json_decode($_SESSION['usr'])->access_token;
$topics = $topic->get($token);
$topics = json_decode($topics, true)['data'];
// $util->Show($topics);
?>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Happy Box:: Partner Edit Profile Dialogue</title>
  <!-- Bootstrap core CSS -->
 <?php include '../shared/partials/css.php'; ?>

</head>

<body>
  <!-- Navigation -->
 <?php include '../shared/partials/nav-logged-in.php'; ?>
  <?php 
  $user_info = json_decode($_SESSION['usr_info']);
  $user_ = json_decode($_SESSION['usr']);
  ?>
<section class="partner_edit_pro section_60" id="reset_div">
         <div class="container ">
                <div class="row justify-content-center">
                    <div class="col-md-10 desktop_view edit_pro_h">
                      <h3 class="partner_blueh text-center">EDIT YOUR PARTNER PROFILE</h3>
                    </div>
                          <section  class="blue_band text-center mobile_view">
			<h2 class="">HAPPYBOX PARTNER PORTAL</h2>
			</section>
                      <div  class="col-12 mob_maroon_section text-center">
			<h4 class="">HAPPYBOX PARTNER PORTAL</h4>
			</div>
                      <div class="col-md-10">
                          <div class="row justify-content-center blue_label">
                                <div class="col-md-5">
                                <form class="become_partner mob_top_20" id="edit_ac" name="edit_ac" method="post">
                                    <?=$util->msg_box()?>
                                    <div class="form-group">
                                      <label>Company Name</label>
                                      <input type="hidden" name="user_id" value="<?=$user_->user->id?>">
                                      <input type="text" name="business_name" class="form-control rounded_form_control" value="<?=$user_info->data->business_name?>">
                                    </div>
                                    <div class="form-group">
                                      <label>Partner PIN Number</label>
                                      <input type="text" name="business_reg_no" class="form-control rounded_form_control" id="select_box_type" value="<?=$user_info->data->business_reg_no?>"/>
                                    </div>
                                    <div class="form-group">
                                      <label>Contact Person's First Name</label>
                                      <input type="text" name="fname" class="form-control rounded_form_control" value="<?=$user_info->data->fname?>">
                                    </div>
                                    <div class="form-group">
                                      <label>Contact Person's Surname</label>
                                      <input type="text" name="sname" class="form-control rounded_form_control" value="<?=$user_info->data->sname?>" placeholder="Required Field">
                                    </div>
                                    <div class="form-group">
                                      <label>Contact Mobile Number</label>
                                      <input type="text" name="phone" class="form-control rounded_form_control" value="<?=$user_info->data->phone?>" placeholder="Required Field">
                                    </div>
                                  </div>
                                  <div class="col-md-5">
                                    <div class="form-group">
                                      <label>Business Description</label>
  <!--<input type="text" name="short_description" class="form-control rounded_form_control" value="<?=$user_info->data->short_description?>">-->
   <textarea name="short_description" placeholder="short description" class="form-control tinymce rounded_form_control">
              <?=$user_info->data->short_description?>
    </textarea>
                                    </div>
                                    <div class="form-group">
                                      <label>Business Category</label>
                                      <select name="business_category" class="form-control rounded_form_control select_ctrl">
                                        <?php
                                            foreach( $topics as $_topic ){
                                               if($_topic['internal_id'] == $user_info->data->business_category){
                                                  print '<option selected value="'.$_topic['internal_id'].'">'.$_topic['name'].'</option>';
                                               }else{
                                                  print '<option value="'.$_topic['internal_id'].'">'.$_topic['name'].'</option>';
                                               }
                                            }
                                        ?>
                                    </select>
                                    </div>
                                    <div class="form-group">
                                      <label>Email Address</label>
                                      <input type="email" readonly name="email" class="form-control rounded_form_control" value="<?=$user_->user->email?>" placeholder="Required Field">
                                    </div>  
                                    <div class="form-group">
                                      <label>Business Location</label>
                                      <select name="location" id="location" class="form-control rounded_form_control select_ctrl" id="select_box_type">
                                        <?php foreach($util->locations_list() as $_loc ){
                                            if(explode('|', $user_info->data->location)[0] == $_loc){
                                              print '<option selected value="'.$_loc.'">'.$_loc.'</option>';
                                            }else{
                                              print '<option value="'.$_loc.'">'.$_loc.'</option>';
                                            }
                                        } ?>
                                      </select>
                                    </div>
                                    <div class="form-group" id="sub_location" style="digsplay:none;">
                                        <label>Sub location</label>
                                        <input type="text" name="sub_location" class="form-control rounded_form_control" id="select_box_type" value="<?=explode('|', $user_info->data->location)[1]?>"/>
                                    </div>
                                      <div class="mob_center desk_align_right">
                                    <button type="button" name="update" onclick="edit_account('edit_ac')" class="btn btn_rounded btn-dark-blue">UPDATE MY PROFILE</button>
                                  </div></div>
                                </form>
                          </div>
                    </div>
                </div>
              </div>
        </section>
<?php  include '../shared/partials/loggedin-footer.php';?>
  <!-- Page Content -->
  <!-- Bootstrap core JavaScript -->
<?php include '../shared/partials/js.php';?>
  <!-- pop up -->
  <button type="button" id="popupid" style="display:none;" class="btn btn_rounded" data-toggle="modal" data-target="#partnerEdit"></button>
  <div class="modal fade" id="partnerEdit">
    <div class="modal-dialog general_pop_dialogue">
      <div class="modal-content">
        <div class="modal-body text-center">
        <div class="col-md-12 text-center forgot-dialogue-borderz">
        <h3 class="partner_blueh">THANK YOU!</h3>
        <p class="forgot_des text-center">
        Your details have been updated.                
        </p>
        <div>
        <img src="../shared/img/btn-okay-blue.svg" class="password_ok_img" data-dismiss="modal"/>
        </div>
        </div>
      </div>
      </div>
    </div>
  </div>
<!-- end pop up -->
 
 

</body>
<script>  
    $(document).ready(function(){
        $('#location').on('change', function() {
        if ( this.value == 'nn'){ $("#sub_location").hide(); }
        else{ $("#sub_location").show(); }
        });
   
      edit_account = function(FormId){
      waitingDialog.show('updating... Please wait',{headerText:'',headerSize: 6,dialogSize:'sm'});
      // var dataString = $("form[name=" + FormId + "]").serialize();
      var dataString =  new FormData($('#' + FormId )[0]);
      $.ajax({
          type: 'post',
          url: '<?=$util->AjaxHome()?>?activity=edit-ptn-account',
          data: dataString,
          contentType: false,
          processData: false,
          success: function(res){
              // console.log(res);
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
</html>
