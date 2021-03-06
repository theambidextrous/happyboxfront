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
$picture = new Picture();
$util->ShowErrors(1);
$user->is_loggedin();
$token = json_decode($_SESSION['usr'])->access_token;
$topics = $topic->get($token);
$topics = json_decode($topics, true)['data'];
$prices = $price->get($token);
$prices = json_decode($prices, true)['data'];
function format_service($keys, $values){
    $lp = 0;
    $rtn = [];
    foreach ($keys as $k ) {
        array_push($rtn, $k . '~' . $values[$lp]);
        $lp++;
    }
    return array_unique($rtn);
}
function reloadcurrent(){
    print '<script>
    setTimeout(function() {
        window.location.replace("'.basename($_SERVER['REQUEST_URI']).'");
    }, 3000);
    </script>';
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
                        <h3>EDIT PARTNER</h3>
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
                        <h4 class="filter_title text-center">Edit Partner </h4>                  
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-7 ">
                        <?php 
                            // if( count($_GET['has-msg']) ){
                            //     $util->success_flash('Partner information updated! Note that email address is not updated and password is not reset too');
                            // }
                            $selected_partner = $user->get_one($_REQUEST['pt'], $token);
                            $selected_partner_data = $user->get_details($_REQUEST['pt']);
                            $selected_partner = json_decode($selected_partner, true)['data'];
                            $selected_partner_data = json_decode($selected_partner_data, true)['data'];
                            $services = json_decode($selected_partner_data['services'], true);
                            // $util->Show($services);
                            if(!isset($_REQUEST['pt']) || $_REQUEST['pt'] == ''){
                                print $util->error_flash('Wrong request');
                                exit;
                            }
                            $p_picture = $p_logo = '';
                            $_media = $picture->get_byitem($token, $selected_partner_data['internal_id']);
                            $_media = json_decode($_media, true)['data'];
                            // print_r($_media);
                            $_plogo = $_ppicture = '';
                            foreach( $_media as $_mm ){
                                if($_mm['type'] == '2'){
                                   $p_picture = $_mm['path_name'];
                                   $_ppicture = $_mm['id'];
                                }elseif($_mm['type'] == '3'){
                                    $p_logo = $_mm['path_name'];
                                    $_plogo = $_mm['id'];
                                }
                            }
                            // print $p_picture;
                            // if(!isset($_SESSION['frm'])){
                                $_SESSION['frm'] = $selected_partner;
                            // }
                            // if(!isset($_SESSION['frm_b'])){
                                $_SESSION['frm_b'] = $selected_partner_data;
                            // }
                            if( isset($_POST['update'])){
                                try{
                                    $_SESSION['frm'] = $_POST;
                                    $_SESSION['frm_b'] = $_POST;
                                    $u = new User();
                                    /** update profile */
                                    $services = format_service($_POST['range'], $_POST['experience']);
                                    // $util->Show($services);
                                    if(count($services) < 1){
                                        throw new Exception('You must add at least one experience for this partner');
                                    }
                                    if(empty($_POST['sub_location'])){
                                        $_POST['sub_location'] = "";
                                        // throw new Exception('Sub location is required, please correct');
                                    }else{
                                        $_POST['sub_location'] = " | " . $_POST['sub_location'];
                                    }
                                    $created_user_id = $_REQUEST['pt'];
                                    $body = [
                                        'fname' => $_POST['fname'],
                                        'sname' => $_POST['sname'],
                                        'short_description' => $_POST['short_description'],
                                        'location' => $_POST['location'] . $_POST['sub_location'],
                                        'phone' => $_POST['phone'],
                                        'email' => $_POST['email'],
                                        'business_name' => $_POST['business_name'],
                                        'business_category' => $_POST['business_category'],
                                        'business_reg_no' => $_POST['business_reg_no'],
                                        'services' => json_encode($services)
                                    ];
                                    $prof_resp = $u->edit_details_partner($body, $token, $created_user_id);
                                    // print $prof_resp;
                                    if(json_decode($prof_resp)->status == '0' && json_decode($prof_resp)->userid > 0){
                                        $_picture = new Picture();
                                        /** upload media */
                                        $p_internal_id = json_decode($prof_resp)->internal_id;
                                        if(is_uploaded_file($_FILES['p_picture']['tmp_name'])) {
                                            /** pic */
                                            $_data = [$_POST['p_picture_id'], 'p_picture'];
                                            if(empty($_POST['p_picture_id'])){
                                                $p_pic = new Picture($p_internal_id, 'p_picture', '2');
                                                $p_pic_resp = $p_pic->create($token);
                                                if(json_decode($p_pic_resp)->status != '0'){
                                                    throw new Exception('Partner picture could not be uploaded!');
                                                }
                                            }else{
                                                $p_pic_resp = $_picture->update($token, $_data);
                                                if(json_decode($p_pic_resp)->status != '0'){
                                                    throw new Exception('Partner picture could not be uploaded!');
                                                } 
                                            }
                                        }
                                        if(is_uploaded_file($_FILES['p_logo']['tmp_name'])) {
                                            /** logo */
                                            $_data = [$_POST['p_logo_id'], 'p_logo'];
                                            if(empty($_POST['p_logo_id'])){
                                                $p_logo = new Picture($p_internal_id, 'p_logo', '3');
                                                $p_logo_resp = $p_logo->create($token);
                                                if(json_decode($p_logo_resp)->status != '0'){
                                                    throw new Exception('Partner logo could not be uploaded!');
                                                }
                                            }else{
                                                $p_logo_resp = $_picture->update($token, $_data);
                                                if(json_decode($p_logo_resp)->status != '0'){
                                                    throw new Exception('Partner picture could not be uploaded!');
                                                } 
                                            }
                                        }
                                        unset($_SESSION['frm']);
                                        unset($_SESSION['frm_b']);
                                        // $_SESSION['kmsg'] = '';
                                        // $util->redirect_to(basename($_SERVER['REQUEST_URI']).'&has-msg=1', 2);
                                        print $util->success_flash('Partner information updated! Note that email address is not updated and password is not reset too');
                                        reloadcurrent();
                                    }else{
                                        print $util->error_flash(json_decode($prof_resp)->message);
                                    }
                                }catch(Exception $e){
                                    print $util->error_flash($e->getMessage());
                                }
                            }
                        ?>
                        <form class="filter_form" method="post" enctype="multipart/form-data">
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label for="BoxType" class="col-form-label">Partner Code(optional)</label>
                                    <input type="text" readonly placeholder="partner code" name="internal_id" class="form-control rounded_form_control" id="select_box_type" value="<?=$_SESSION['frm_b']['internal_id']?>"/>
                                </div>
                                <div class="col-md-5">
                                    <label for="BoxType" class="col-form-label">Partner Name</label>
                                    <input type="text" placeholder="partner name" name="business_name" class="form-control rounded_form_control" id="select_box_type" value="<?=$_SESSION['frm_b']['business_name']?>"/>
                                </div>
                                <div class="col-md-3">
                                    <label for="BoxType" class="col-form-label">Partner PIN Number</label>
                                    <input type="text" placeholder="inc/reg number" name="business_reg_no" class="form-control rounded_form_control" id="select_box_type" value="<?=$_SESSION['frm_b']['business_reg_no']?>"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="BoxType" class="col-form-label">Partner Topic</label>
                                    <select name="business_category" class="form-control rounded_form_control" id="select_box_type">
                                        <option value="nn">Select a topic</option>
                                        <?php
                                            foreach( $topics as $_topic ){
                                                if($_topic['internal_id'] == $_SESSION['frm_b']['business_category']){
                                                    print '<option selected value="'.$_topic['internal_id'].'">'.$_topic['name'].'</option>';
                                                }else{
                                                    print '<option value="'.$_topic['internal_id'].'">'.$_topic['name'].'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="BoxType" class="col-form-label">Partner location</label>
                                    <select name="location" id="location" class="form-control rounded_form_control" id="select_box_type">
                                        <option value="nn">Select a location</option>
                                        <?php foreach($util->locations_list() as $_loc ){ 
                                            if(trim(strtolower(explode('|',$_SESSION['frm_b']['location'])[0])) == trim(strtolower($_loc)) ){
                                                print '<option selected value="'.$_loc.'">'.$_loc.'</option>';
                                            }else{
                                                print '<option value="'.$_loc.'">'.$_loc.'</option>';
                                            }
                                        } ?>
                                    </select>
                                </div>
                                <div class="col-md-12" id="sub_location" style="display:none;">
                                    <label for="BoxType" class="col-form-label">Sub location</label>
                                    <input type="text" placeholder="enter precise location e.g Karen" name="sub_location" class="form-control rounded_form_control" id="select_box_type" value="<?=explode('|',$_SESSION['frm_b']['location'])[1]?>"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="BoxType" class="col-form-label">Partner business description</label>
    <textarea name="short_description" placeholder="short description" class="form-control tinymce rounded_form_control" id="select_box_type">
               <?=$_SESSION['frm_b']['short_description']?>
    </textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="BoxType" class="col-form-label">Partner Picture</label>
                                    <img src="<?=$p_picture?>" class="" width="50"/><br><br>
                                    <input type="hidden" name="p_picture_id" value="<?=$_ppicture?>"/>
                                    <input type="file" name="p_picture" class="form-control rounded_form_control"/>
                                </div>
                                <div class="col-md-6">
                                    <label for="BoxType" class="col-form-label">Partner Logo</label>
                                    <img src="<?=$p_logo?>" class="" width="50"/><br><br>
                                    <input type="hidden" name="p_logo_id" value="<?=$_plogo?>"/>
                                    <input type="file" name="p_logo" class="form-control rounded_form_control"/>
                                </div>
                            </div>
                            <hr>
                            <h4 class="filter_title text-center"> Experiences Offered </h4>  
                            <div id="exprs">
                                <?php 
                                if(count($services)){ 
                                    foreach( $services as $sk => $sv ): 
                                        $_meta = explode('~', $sv);
                                        $_pricename = $_meta[0];
                                        $_servicename = $_meta[1];
                                ?>
                                <div class="form-group row clonables">
                                    <div class="col-md-6">
                                        <label for="BoxType" class="col-form-label">Experience</label>
                                        <input type="text" placeholder="type here e.g. massage" name="experience[]" value="<?=$_servicename?>" class="form-control rounded_form_control"/>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="BoxType" class="col-form-label">Price range</label>
                                        <select name="range[]" class="form-control rounded_form_control">
                                            <option value="nn">Select a Price</option>
                                            <?php
                                                foreach( $prices as $_price ){
                                                    if($_price['name'] == $_pricename){
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
                                            <option value="nn">Select a Price</option>
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
                            <h4 class="filter_title text-center"> Contact Details </h4>   
                            <div class="form-group row">
                                <label for="DateRange" class="col-md-3 col-form-label">Contact Name</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control rounded_form_control" id="select_box_type" placeholder="First name" name="fname" value="<?=$_SESSION['frm_b']['fname']?>"/>
                                </div>
                                <div class="col-md-5">
                                    <input type="text" class="form-control rounded_form_control" id="select_box_type" placeholder="Surname" name="sname" value="<?=$_SESSION['frm_b']['sname']?>"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="DateRange" class="col-md-3 col-form-label">Phone & Email</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control rounded_form_control" id="select_box_type" placeholder="Phone Number" name="phone" value="<?=$_SESSION['frm_b']['phone']?>"/>
                                </div>
                                <div class="col-md-5">
                                    <input type="text" class="form-control rounded_form_control" id="select_box_type" placeholder="Email Address" name="email" value="<?=$_SESSION['frm']['email']?>" />
                                </div>
                            </div>
                            
                            <div class=" row">
                                <div class="col-md-12 text-right text-white">
                                    <button type="submit" name="update" class="btn btn_view_report">save changes</button>
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
                    $(this).find("input[type=text]").val("");
                    $(this).find('select').val("nn").attr("selected", "selected");
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
        $("#sub_location").show();
        $('#location').on('change', function() {
        if ( this.value == 'nn'){ $("#sub_location").hide(); }
        else{ $("#sub_location").show(); }
        });
    });
</script>
</html>
