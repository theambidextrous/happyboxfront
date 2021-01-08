<?php 
session_start();
require_once('../lib/Util.php');
require_once('../lib/User.php');
require_once('../lib/Topic.php');
require_once('../lib/Box.php');
require_once('../lib/Experience.php');
require_once('../lib/Picture.php');
require_once('../lib/Price.php');
$util = new Util();
$user = new User();
$topic = new Topic();
$price = new Price();
$util->ShowErrors(1);
$user->is_loggedin();
$token = json_decode($_SESSION['usr'])->access_token;
$prices = $price->get($token);
$prices = json_decode($prices, true)['data'];
// $util->Show();
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Happy Box:: Admin Portal</title>
        <!-- Bootstrap core CSS -->
        <?php include 'admin-partials/css.php'; ?>
        <style>
            .admin-box-new{
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
                        <h3>CREATE BOX</h3>
                    </div>
                    <div class="col-6 text-right">
                        <a class="btn generate_rpt" href="admin-box-all.php">Back</a>
                    </div>
                </div>
            </div>
        </section>
        <section class=" data+table_section ">
            <div class="container">
            <div class="row ">
                    <div class="col-md-12 ">
                    <br><br>
                        <h4 class="filter_title text-center">New Box </h4>                  
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-7 ">
                        <?php 
                            $_partners_list = json_decode($user->get_all_partner($token), true)['data'];
                            $_SESSION['frm'] = $__ranges = $__partners = $__services = [];
                            if( isset($_POST['create'])){
                                try{
                                    // $util->Show($_POST['partner']);
                                    // $util->Show($_POST['service']);

                                    if(count($_POST['service']) < 1){
                                        throw new Exception('You must select at least one experience');
                                    }
                                    foreach( $_POST['partner'] as $_e ){
                                        if($_e == 'nn'){
                                            throw new Exception('Empty partner field detected. You select a partner or remove the entire row');
                                        }
                                    }
                                    foreach($_POST['topics'] as $_t ){
                                        if($_t != 'nn'){
                                         $_tp[] = $_t;
                                        }
                                    }
                                    /** last post */
                                    $__ranges = $_POST['range'];
                                    $__partners = $_POST['partner'];
                                    $__services = $_POST['service'];
                                    /** format */
                                    $_c_count=0;
                                    foreach( $_POST['partner'] as $_p):
                                        $partner_services[] = $_p . '~~~' . $_POST['range'][$_c_count] . '~~~' . $_POST['service'][$_c_count];
                                        $_c_count++;
                                    endforeach;
                                    // $util->Show($partner_services);
                                    $_POST['topics'] = implode(',', $_tp);
                                    $b = new Box(
                                        $_POST['name'], $_POST['price'], $_POST['description'], $_POST['topics'],json_encode($partner_services),'00'
                                    );
                                    $resp = $b->create($token);
                                    if(json_decode($resp)->status == '0'){
                                        /** upload media */
                                        $box_internal_id = json_decode($resp)->box;
                                        /** 3d */
                                        $pc_3d = new Picture($box_internal_id, '3dimg', '2');
                                        $pc_3d_resp = $pc_3d->create($token, $box_internal_id);
                                        if(json_decode($pc_3d_resp)->status != '0'){
                                            throw new Exception('Box created but 3D image could not be uploaded! Go to box designs and modify');
                                        }
                                        /** pdf */
                                        $pc_pdf = new Picture($box_internal_id, 'pdfbooklet', '3');
                                        $pc_pdf_resp = $pc_pdf->create($token, $box_internal_id);
                                        if(json_decode($pc_pdf_resp)->status != '0'){
                                            throw new Exception('Box created but PDF could not be uploaded! Go to box designs and modify');
                                        }
                                        print $util->success_flash('Created successfully');
                                    }else{
                                        print $util->error_flash(json_decode($resp)->message);
                                    }
                                }catch(Exception $e){
                                    print $util->error_flash($e->getMessage());
                                }
                            }
                        ?>
                        <form class="filter_form" method="post" enctype="multipart/form-data">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="BoxType" class="col-form-label">Name</label>
                                    <input type="text" placeholder="Box name" name="name" class="form-control rounded_form_control" id="select_box_type" value="<?=$_SESSION['frm']['name']?>"/>
                                </div>
                                <div class="col-md-6">
                                    <label for="BoxType" class="col-form-label">Price</label>
                                    <input type="number" placeholder="Box price" name="price" class="form-control rounded_form_control" id="select_box_type" value="<?=$_SESSION['frm']['price']?>"/>
                                </div>
                            </div>
                            <!-- <hr> -->
                            <!-- <h4 class="filter_title text-center">  </h4>   -->
                            <div id="exprs">
                                <label for="BoxType" class="col-form-label">List of partners</label>
                                <?php if(!empty($__partners)){ $_loop=0; foreach( $__partners as $part_ ): ?>
                                <div class="form-group row clonables" id="clonables__<?=$_loop?>">
                                    <div class="col-md-4">
                                        <label class="label"><small><i>Select partner</i></small></label>
                                        <select id="partners__<?=$_loop?>" onchange="serviceSearch('partners__<?=$_loop?>')" class="partner form-control rounded_form_control" name="partner[]">
                                            <option value="nn">Select a partner</option>
                                            <?php 
                                                foreach( $_partners_list as $ptn ){
                                                    $_d = $user->get_details($ptn['id']);
                                                    $partner_name = json_decode($_d)->data->business_name;
                                                    $internal_id = json_decode($_d)->data->internal_id;
                                                    if($partner_name){
                                                        if( $part_ == $internal_id){
                                                            print '<option selected value="'.$internal_id.'">'.$partner_name.'</option>';
                                                        }else{
                                                           print '<option value="'.$internal_id.'">'.$partner_name.'</option>';
                                                       }
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="label"><small><i>Select price range</i></small></label>
                                        <select id="range__<?=$_loop?>" onchange="serviceSearch('range__<?=$_loop?>')" name="range[]" class="form-control rounded_form_control">
                                            <!-- <option value="nn">Select a topic</option> -->
                                            <?php
                                                foreach( $prices as $_price ){
                                                    if($_price['name'] == $__ranges[$_loop] ){
                                                        print '<option selected value="'.$_price['name'].'">'.$_price['name'].'</option>';
                                                    }else{
                                                        print '<option value="'.$_price['name'].'">'.$_price['name'].'</option>'; 
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="label"><small><i>Select experience</i></small></label>
                                        <select id="service__<?=$_loop?>" onchange="serviceSearch('service__<?=$_loop?>')" name="service[]" class="form-control rounded_form_control">
                                            <option value="<?=$__services[$_loop]?>"><?=$__services[$_loop]?></option>
                                        </select>
                                    </div>
                                    <button type="button" class="clone btn btn-link btn-admin-link"><i class="fas fa-plus"></i> Add another</button> 
                                    <button type="button" class="remove btn btn-link btn-admin-link"><i class="fas fa-trash"></i>  Remove this</button>
                                </div>
                                <?php $_loop++; endforeach;}else{?>
                                <div class="form-group row clonables" id="clonables__0">
                                    <div class="col-md-4">
                                        <label class="label"><small><i>Select partner</i></small></label>
                                        <select id="partners__0" onchange="serviceSearch('partners__0')" class="partner form-control rounded_form_control" name="partner[]">
                                            <option value="nn">Select a partner</option>
                                            <?php 
                                                foreach( $_partners_list as $ptn ){
                                                    $_d = $user->get_details($ptn['id']);
                                                    $partner_name = json_decode($_d)->data->business_name;
                                                    $internal_id = json_decode($_d)->data->internal_id;
                                                    if($partner_name){
                                                        print '<option value="'.$internal_id.'">'.$partner_name.'</option>';
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="label"><small><i>Select price range</i></small></label>
                                        <select id="range__0" onchange="serviceSearch('range__0')" name="range[]" class="form-control rounded_form_control">
                                            <option value="nn">Select Price Range</option>
                                            <?php
                                                foreach( $prices as $_price ){
                                                    print '<option value="'.$_price['name'].'">'.$_price['name'].'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="label"><small><i>Select experience</i></small></label>
                                        <select id="service__0" onchange="serviceSearch('service__0')" name="service[]" class="form-control rounded_form_control">
                                            <option value="nn">Select Experience</option>
                                        </select>
                                    </div>
                                    <button type="button" class="clone btn btn-link btn-admin-link"><i class="fas fa-plus"></i> Add another</button> 
                                    <button type="button" class="remove btn btn-link btn-admin-link"><i class="fas fa-trash"></i>  Remove this</button>
                                </div>
                                <?php } ?>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="BoxType" class="col-form-label">List of Topics</label>
                                    <select class="form-control select2" multiple name="topics[]" id="">
                                        <option value="nn">Select box related topic(s)</option>
                                        <?php 
                                            $topics = json_decode($topic->get($token), true)['data'];
                                            foreach( $topics as $ptn ){
                                                 print '<option value="'.$ptn['internal_id'].'">'.$ptn['name'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="BoxType" class="col-form-label">Description</label>
                                    <textarea name="description" placeholder="box description" class="form-control tinymce rounded_form_control" id="select_box_type"><?=$_SESSION['frm']['description']?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="BoxType" class="col-form-label">3D image</label>
                                    <input required type="file" name="3dimg" class="form-control rounded_form_control" id="select_box_type"/>
                                </div>
                                <div class="col-md-6">
                                    <label for="BoxType" class="col-form-label">PDF Booklet</label>
                                    <input required type="file" name="pdfbooklet" class="form-control rounded_form_control" id="select_box_type"/>
                                </div>
                            </div>
                            <hr>
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


        <script>  
        $(document).ready(function(){
            var regex = /^(.+?)(\d+)$/i;
            var cloneIndex = $(".clonables").length;
            function clone(){
                $(this).parents(".clonables").clone()
                    .appendTo("#exprs")
                    .attr("id", "clonables__" +  cloneIndex)
                    // .find("*")
                    .each(function() {
                        // set select IDs
                        $(this).find("select:eq(0)").attr("id", "partners__" + cloneIndex);
                        $(this).find("select:eq(1)").attr("id", "range__" + cloneIndex);
                        $(this).find("select:eq(2)").attr("id", "service__" + cloneIndex);
                        //set onchange func to 
                        $(this).find("select:eq(0)").attr("onchange", "serviceSearch('partners__" + cloneIndex + "')");
                        $(this).find("select:eq(1)").attr("onchange", "serviceSearch('range__" + cloneIndex + "')");
                        $(this).find('select').val("nn").attr("selected", "selected");
                        //onchange="serviceSearch()"
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


            // change
            serviceSearch = function(selected) {
                item_arr = selected.split("__");
                item = item_arr[0];
                index = item_arr[1];
                //switch case
                switch(item){
                    case 'partners': //user changed partner select, get its value 
                        p = $("#" + selected).val();
                        r = $('#range__' + index).val();
                        if( p == 'nn'){
                            return;
                        }
                        // use p & r to get services
                        waitingDialog.show('Updating... Please wait',{headerText:'',headerSize: 6,dialogSize:'sm'});
                        dataString = "p=" + p + "&r=" + r;
                        $.ajax({
                            type: 'post',
                            url: '<?=$util->AjaxHome()?>?activity=get-partner-services',
                            data: dataString,
                            success: function(res){
                                // console.log(res);
                                var rtn = JSON.parse(res);
                                if(rtn.hasOwnProperty("MSG")){
                                    console.log(rtn.data);
                                    s = "service__" + index;
                                    $('#' + s).empty();
                                    $.each(rtn.data, function (i, item) {
                                        $('#' + s).append($('<option>', { 
                                            value: item,
                                            text : item 
                                        }));
                                    });
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
                    break;
                    case 'range':
                        r = $("#" + selected).val();
                        p = $('#partners__' + index).val();
                        if( p == 'nn'){
                            return;
                        }
                        // use p & r to get services
                        // use p & r to get services
                        waitingDialog.show('Updating... Please wait',{headerText:'',headerSize: 6,dialogSize:'sm'});
                        dataString = "p=" + p + "&r=" + r;
                        $.ajax({
                            type: 'post',
                            url: '<?=$util->AjaxHome()?>?activity=get-partner-services',
                            data: dataString,
                            success: function(res){
                                // console.log(res);
                                var rtn = JSON.parse(res);
                                if(rtn.hasOwnProperty("MSG")){
                                    console.log(rtn.data);
                                    s = "service__" + index;
                                    $('#' + s).empty();
                                    $.each(rtn.data, function (i, item) {
                                        $('#' + s).append($('<option>', { 
                                            value: item,
                                            text : item 
                                        }));
                                    });
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
                    break;
                }

            }
        });
    </script>
    </body>

</html>
