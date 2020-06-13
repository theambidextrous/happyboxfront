<?php 
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
require_once('../lib/Topic.php');
require_once('../lib/Picture.php');
require_once('../lib/Price.php');
$util = new Util();
$user = new User();
$topic = new Topic();
$price = new Price();
$util->ShowErrors(1);
$user->is_loggedin();
$token = json_decode($_SESSION['usr'])->access_token;
$topics = $topic->get($token);
$topics = json_decode($topics, true)['data'];
$prices = $price->get($token);
$prices = json_decode($prices, true)['data'];
// $util->Show($prices);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Happy Box:: Admin Portal</title>
        <!-- Bootstrap core CSS -->
        <?php include 'admin-partials/css.php'; ?>
        <style>
            .admin-p-list{
                color: #c20a2b!important;
                text-decoration: none!important;
                border-bottom: solid 2px #c20a2b!important;
            }
        </style>
    </head>

    <body>

        <!-- Navigation -->
        <?php include 'admin-partials/nav.php'; ?>


        <section class="container section_padding_top top_menu">
            <div class="row">
                <div class="col-md-12">
                <?php include 'admin-partials/mid-nav.php'; ?>
                </div>

            </div>
        </section>
        <!--end discover our selection-->
        <section class=" top_blue_bar ">
            <div class="container">
                <div class="row">
                    <div class="col-6 section_title">
                        <h3>CREATE PARTNER</h3>
                    </div>
                    <div class="col-6 text-right">
                        <a class="btn generate_rpt" href="admin-partner-listing.php">Back</a>
                    </div>

                </div>
            </div>
        </section>
        <section class=" data+table_section ">
            <div class="container">
            <div class="row ">
                    <div class="col-md-12 ">
                        <br><br>
                        <h4 class="filter_title text-center">New Partner </h4>                  
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-7 ">
                        <?php 
                            $_SESSION['frm'] = $services = [];
                            
                            if( isset($_POST['create'])){
                                try{
                                    $services = array_combine($_POST['range'], $_POST['experience']);
                                    if(count($services) < 1){
                                        throw new Exception('You must add at least one experience for this partner');
                                    }
                                    // $util->Show($services);
                                    $_SESSION['frm'] = $_POST;
                                    $username = explode('@', $_POST['email'])[0];
                                    $password = $util->createCode(10);
                                    $u = new User($username, $_POST['email'], $password, $password);
                                    /** register */
                                    $u_resp = $u->new_partner($token);
                                    if( json_decode($u_resp)->status == '0' && json_decode($u_resp)->data->id > 0){
                                        $created_user_id = json_decode($u_resp)->data->id;
                                        /** reset password */
                                        $reset_resp = $u->pwd_reset_link();
                                        // print $reset_resp;
                                        if(json_decode($reset_resp)->status == '0'){
                                        // if($services){
                                            if(empty($_POST['sub_location'])){
                                                throw new Exception('Sub location is required, please correct');
                                            }
                                            /** complete profile */
                                            $body = [
                                                'fname' => $_POST['fname'],
                                                'sname' => $_POST['sname'],
                                                'short_description' => $_POST['short_description'],
                                                'location' => $_POST['location'].' | '. $_POST['sub_location'],
                                                'phone' => $_POST['phone'],
                                                'business_name' => $_POST['business_name'],
                                                'business_category' => $_POST['business_category'],
                                                'business_reg_no' => $_POST['business_reg_no'],
                                                'services' => json_encode($services)
                                            ];
                                            if(!empty($_POST['internal_id'])){
                                                $body['internal_id'] = $_POST['internal_id'];
                                            }
                                            $prof_resp = $u->add_details_partner($body, $token, $created_user_id);
                                            // print $prof_resp;
                                            if(json_decode($prof_resp)->status == '0' && json_decode($prof_resp)->userid > 0){
                                                /** upload media */
                                                $p_internal_id = json_decode($prof_resp)->internal_id;
                                                if(is_uploaded_file($_FILES['p_picture']['tmp_name'])) {
                                                    /** pic */
                                                    $p_pic = new Picture($p_internal_id, 'p_picture', '2');
                                                    $p_pic_resp = $p_pic->create($token);
                                                    if(json_decode($p_pic_resp)->status != '0'){
                                                        throw new Exception('Partner picture could not be uploaded!');
                                                    }
                                                }
                                                if(is_uploaded_file($_FILES['p_logo']['tmp_name'])) {
                                                /** logo */
                                                    $p_logo = new Picture($p_internal_id, 'p_logo', '3');
                                                    $p_logo_resp = $p_logo->create($token);
                                                    if(json_decode($p_logo_resp)->status != '0'){
                                                        throw new Exception('Partner logo could not be uploaded!');
                                                    }
                                                }
                                                unset($_SESSION['frm']);
                                                print $util->success_flash('Partner created! An email containing password reset link has been send');
                                            }else{
                                                print $util->error_flash(json_decode($prof_resp)->message);
                                            }
                                        }else{
                                            print $util->error_flash(json_decode($reset_resp)->message);
                                        }
                                    }else{
                                        print $util->error_flash(json_decode($u_resp)->message);
                                    }
                                }catch(Exception $e){
                                    print $util->error_flash($e->getMessage());
                                }
                            }
                        ?>
                        <form class="filter_form" method="post" enctype="multipart/form-data">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="BoxType" class="col-form-label">Partner Name</label>
                                    <input type="text" placeholder="partner name" name="business_name" class="form-control rounded_form_control"  value="<?=$_SESSION['frm']['business_name']?>"/>
                                </div>
                                <div class="col-md-6">
                                    <label for="BoxType" class="col-form-label">Partner PIN Number</label>
                                    <input type="text" placeholder="PIN number" name="business_reg_no" class="form-control rounded_form_control"  value="<?=$_SESSION['frm']['business_reg_no']?>"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="BoxType" class="col-form-label">Partner Topic</label>
                                    <select name="business_category" class="form-control rounded_form_control" >
                                        <option value="nn">Select a topic</option>
                                        <?php
                                            foreach( $topics as $_topic ){
                                                print '<option value="'.$_topic['internal_id'].'">'.$_topic['name'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="BoxType" class="col-form-label">Partner location</label>
                                    <select name="location" id="location" class="form-control rounded_form_control" >
                                        <option value="nn">Select a location</option>
                                        <?php foreach($util->locations_list() as $_loc ){ 
                                            print '<option value="'.$_loc.'">'.$_loc.'</option>';
                                        } ?>
                                    </select>
                                </div>
                                <div class="col-md-12" id="sub_location" style="display:none;">
                                    <label for="BoxType" class="col-form-label">Sub location</label>
                                    <input type="text" placeholder="enter precise location e.g Karen" name="sub_location" class="form-control rounded_form_control"  value="<?=$_SESSION['frm']['sub_location']?>"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="BoxType" class="col-form-label">Partner business description</label>
                                    <textarea name="short_description" placeholder="short description" class="form-control rounded_form_control" ><?=$_SESSION['frm']['short_description']?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="BoxType" class="col-form-label">Partner Picture</label>
                                    <input type="file" name="p_picture" class="form-control rounded_form_control"/>
                                </div>
                                <div class="col-md-6">
                                    <label for="BoxType" class="col-form-label">Partner Logo</label>
                                    <input type="file" name="p_logo" class="form-control rounded_form_control"/>
                                </div>
                            </div>
                            <hr>
                            <h4 class="filter_title text-center"> experiences offered </h4>  
                            <div id="exprs">
                                <?php if(!empty($services)){ foreach( $services as $sk => $sv ): ?>
                                <div class="form-group row clonables">
                                    <div class="col-md-6">
                                        <label for="BoxType" class="col-form-label">Experience</label>
                                        <input type="text" placeholder="type here e.g. massage" name="experience[]" value="<?=$sv?>" class="form-control rounded_form_control"/>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="BoxType" class="col-form-label">Price range</label>
                                        <select name="range[]" class="form-control rounded_form_control">
                                            <!-- <option value="nn">Select a topic</option> -->
                                            <?php
                                                foreach( $prices as $_price ){
                                                    if($_price['name'] == $sk){
                                                        print '<option selected value="'.$_price['name'].'">'.$_price['name'].'</option>';
                                                    }else{
                                                        print '<option value="'.$_price['name'].'">'.$_price['name'].'</option>';
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <button type="button" class="clone btn btn-link btn-admin-link"><i class="fas fa-plus"></i> Add another</button> 
                                    <button type="button" class="remove btn btn-link btn-admin-link"><i class="fas fa-trash"></i>  Remove this</button>
                                </div>
                                <?php endforeach;}else{?>
                                <div class="form-group row clonables">
                                    <div class="col-md-6">
                                        <label for="BoxType" class="col-form-label">Experience</label>
                                        <input type="text" placeholder="type here e.g. massage" name="experience[]" value="<?=$sv?>" class="form-control rounded_form_control"/>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="BoxType" class="col-form-label">Price range</label>
                                        <select name="range[]" class="form-control rounded_form_control">
                                            <!-- <option value="nn">Select a topic</option> -->
                                            <?php
                                                foreach( $prices as $_price ){
                                                     print '<option value="'.$_price['name'].'">'.$_price['name'].'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <button type="button" class="clone btn btn-link btn-admin-link"><i class="fas fa-plus"></i> Add another</button> 
                                    <button type="button" class="remove btn btn-link btn-admin-link"><i class="fas fa-trash"></i>  Remove this</button>
                                </div>
                                <?php } ?>
                            </div>
                            <hr>
                            <h4 class="filter_title text-center"> contact Details </h4>   
                            <div class="form-group row">
                                <label for="DateRange" class="col-md-3 col-form-label">Contact Name</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control rounded_form_control"  placeholder="First name" name="fname" value="<?=$_SESSION['frm']['fname']?>"/>
                                </div>
                                <div class="col-md-5">
                                    <input type="text" class="form-control rounded_form_control"  placeholder="Surname" name="sname" value="<?=$_SESSION['frm']['sname']?>" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="DateRange" class="col-md-3 col-form-label">Phone & Email</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control rounded_form_control"  placeholder="Phone Number" name="phone" value="<?=$_SESSION['frm']['phone']?>"/>
                                </div>
                                <div class="col-md-5">
                                    <input type="text" class="form-control rounded_form_control"  placeholder="Email Address" name="email" value="<?=$_SESSION['frm']['email']?>" />
                                </div>
                            </div>
                            <div class=" row">
                                <div class="col-md-12 text-right text-white">
                                    <button type="submit" name="create" class="btn btn_view_report">Create</button>
                                </div>
                            </div>
                        </form>
                    </div> 
                </div>
            </div>
        </section><br><br>




 <?php include 'admin-partials/footer.php'; ?>
        <!-- Bootstrap core JavaScript -->
        <?php include 'admin-partials/js.php'; ?>
    </body>
    <script>  
        $(document).ready(function(){
            var regex = /^(.+?)(\d+)$/i;
            var cloneIndex = $(".clonables").length;
            function clone(){
                $(this).parents(".clonables").clone()
                    .appendTo("#exprs")
                    // .attr("id", "clonables" +  cloneIndex)
                    // .find("*")
                    .each(function() {
                        var id = this.id || "";
                        var match = id.match(regex) || [];
                        if (match.length == 3) {
                            this.id = match[1] + (cloneIndex);
                        }
                    })
                    .on('click', 'button.clone', clone)
                    .on('click', 'button.remove', remove);
                cloneIndex++;
            }
            function remove(){
                children = $(".clonables").length;
                console.log("it has " + children);
                if( children > 1 ){
                    $(this).parents(".clonables").remove();
                }else{

                }
            }
            $("button.clone").on("click", clone);
            $("button.remove").on("click", remove);


            // location
            $('#location').on('change', function() {
            if ( this.value == 'nn'){ $("#sub_location").hide(); }
            else{ $("#sub_location").show(); }
            });
        });
    </script>
</html>
