<?php 
session_start();
require_once '../../lib/Util.php';
$util = new Util();
$util->ShowErrors(0);
require_once '../../lib/User.php';
require_once '../../lib/Inventory.php';
require_once '../../lib/Shipping.php';
require_once '../../lib/Box.php';
require_once '../../lib/MPesa.php';
require_once '../../lib/Order.php';

switch($_REQUEST['activity']){
    default:
        exit(json_encode(['ERR' => 'Mission Failed!']));
    break;
    case 'mpesa-express-status-check':
        /** check order payment status.. if paid redirect */
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        $event_data = 'Payment Still Processing...';
        if($_SESSION['status_chk_order']){
            $token = json_decode($_SESSION['usr'])->access_token;
            $order_number = $_SESSION['status_chk_order'];
            $o = new Order($token);
            $resp_ =  $o->get_one_byorder($order_number);
            if(json_decode($resp_)->status == '0'){
                $_data = json_decode($resp_, true)['data'];
                if($_data['payment_status'] && $_data['paid']){
                    $event_data = '<div title="'.$resp_.'" class="d-flex justify-content-center"><div class="alert alert-success"><b>Success!</b> Payment of KES '.$_data['paid_amount'].' has been received. Check your email for your order details.</div></div>';
                }else{
                    $event_data = '<div title="'.$resp_.'" class="d-flex justify-content-center"><div class="spinner-border spinner-border-lg spinner-grow-lg" role="status"><span class="sr-only">Loading...</span></div></div>';
                }
            }else{
                $event_data = '<div title="'.$resp_.'" class="d-flex justify-content-center"><div class="spinner-border spinner-border-lg spinner-grow-lg" role="status"><span class="sr-only">Loading...</span></div></div>';
            }
        }else{
            $event_data = ' ';
        }
        echo "data: {$event_data}\n\n";
        flush();
    break;
    case 'make-payment-mpesa':
        try{
            $token = json_decode($_SESSION['usr'])->access_token;
            $mpesa_phone = '254' . intval($_POST['mpesaphone']);
            $order_number = $_POST['ordernumber'];
            $order_amount = 10;//$_POST['orderamount'];
            if(empty($order_number) || empty($mpesa_phone) || $order_amount < 10 ){
                throw new Exception('Error occured. Make sure the order amount is not zero and phone starts with 07..');
            }
            $mpesa_instructions = $util->mpesa_process($util->AppPayBill(), $order_number, $order_amount);
            $express = new MPesaExpress(
                $util->AppConsumerKey(),
                $util->AppConsumerSecret(),
                $util->AppPayBill(),
                $util->AppPassKey(),
                [$util->AppMpesaEnv()],
                $util->AppMpesaTransType(),
                $order_amount,
                $mpesa_phone,
                $util->ClientHome().$util->AppMpesaCallBack(),
                $order_number,
                'HappyBox orders',
                'no remarks'
            );
            $express_response = $express->TriggerStkPush();
            /** c2b simulation here */
            // $c2b = new MPesaC2b(
            //     $util->AppC2bConsumerKey(),
            //     $util->AppC2bConsumerSecret(),
            //     $util->AppC2bPayBill(),
            //     $util->AppC2bPhone(),
            //     $order_amount,
            //     $order_number,
            //     [$util->AppMpesaEnv(), $util->ClientHome() . $util->AppMpesaConfirmation(), $util->ClientHome() . $util->AppMpesaValidation()]
            // );
            // $reg_url_response = $c2b->RegisterUrl();
            // $c2b_response = $c2b->Simulate();
            $_SESSION['status_chk_order'] = $order_number;
            $both_msg = '<div class="alert alert-success">Mpesa Automatic Charge Notification has been sent to your phone.<br> Enter your pin to complete order.</div>';
            $manual_msg = '<div class="alert alert-warning">Mpesa Automatic Charge Notification could not be sent<br> Make sure your phone is switched on and try again.</div>';
            if( json_decode($express_response)->ResponseCode != '0' ){
                exit(json_encode(['MSG' => $manual_msg, 'reg' =>$reg_url_response, 'c2b' => $c2b_response, 'exp' => $express_response, 'inst' => $mpesa_instructions]));
            }
            /** update order checkoutrequestid */
            $order = new Order($token);
            $checkout_req_id = json_decode($express_response)->CheckoutRequestID;
            $order_resp = $order->update_checkout_req_id($checkout_req_id, $order_number);
            if(json_decode($order_resp)->status == '0'){
                exit( json_encode(['MSG' => $both_msg, 'reg' =>$reg_url_response, 'c2b' => $c2b_response, 'exp' => $express_response, 'inst' => $mpesa_instructions]));
            }else{
                $err_msg = '<div class="alert alert-danger">Could not update your order with payment information. Try again.</div>';
                exit(json_encode(['ERR' =>$err_msg ]));
            }
        }catch(Exception $e){
            $err_msg = '<div class="alert alert-danger">'.$e->getMessage().'</div>';
            exit(json_encode(['ERR' =>$err_msg ]));
        }
    break;
    case 'get-partner-services':
        try{
            $u = new User();
            if(empty($_POST['p']) || empty($_POST['r']) ){
                throw new Exception('Nothing found!');
            }
            $d = $u->get_details_byidf($_POST['p']);
            $d = json_decode($d, true)['data'];
            $d = json_decode($d['services'], true);
            if( !is_array($d) )
            {
                throw new Exception('Nothing found!');
            }
            $rtn = [];
            $_loop = 0;
            foreach($d as $k => $v ){
                $_meta = explode('~', $v);
                $_range = $_meta[0];
                $_service = $_meta[1];
                if( $_range == $_POST['r']){
                    $rtn[$_loop] = $_service;
                }
                $_loop++;
            }
            exit(json_encode(['MSG' => 'found', 'data' => $rtn ]));
        }catch(Exception $e){
            exit(json_encode(['ERR' => $e->getMessage()]));
        }
    break;
    case 'change-cart-box-type':
        try{
            $i = new Inventory();
            $bx = explode('__', $_POST['internal_id']);
            $type = $bx[0];
            $item = $bx[1];
            $stock = json_decode($i->get_purchasable('', $item))->stock;
            if($type == 'pbx'){
                $ship_type = 1;//p-box
            }elseif($type == 'ebx'){
                $ship_type = 2;//e-box
            }
            $util->change_cart_box_type($item, $ship_type, $stock);
            exit(json_encode(['MSG' => 'updated successfully!']));
        }catch( Exception $e ){
            exit(json_encode(['ERR' => $e->getMessage()]));
        }
    break;
    case 'remove-from-cart':
        try{
            $item = $_POST['internal_id'];
            $util->remove_from_cart($item);
            exit(json_encode(['MSG' => 'removed successfully!']));
        }catch( Exception $e ){
            exit(json_encode(['ERR' => $e->getMessage()]));
        }
    break;
    case 'add-to-cart':
        try{
            $i = new Inventory();
            $stock = json_decode($i->get_purchasable('', $_POST['internal_id']))->stock;
            $ship_type = 2;//e-box
            if($stock > 0){
                $ship_type = 1;//p-box
            }
            $item = $_POST['internal_id'];
            $qty = 1;
            $cart_item = [$item, $qty, $ship_type, $stock];
            if(!isset($_SESSION['curr_usr_cart'])){
                $_SESSION['curr_usr_cart'] = [$cart_item];
            }else{
                if($util->is_in_cart($item)){
                    if($_POST['change_qty'] == '1'){
                        if(intval($_POST['qty']) < 1){
                            exit(json_encode(['ERR' => 'Invalid qty']));
                        }
                        $util->change_cart_item_qty($item, $_POST['qty'], $stock);
                    }else{
                        $util->update_cart_item($item, $qty, $stock);
                    }
                }else{
                    array_push($_SESSION['curr_usr_cart'], $cart_item);
                }
            }
            exit(json_encode(['MSG' => 'Added to cart successfully!']));
        }catch( Exception $e ){
            exit(json_encode(['ERR' => $e->getMessage()]));
        }
    break;
    case 'forgot-rest-link':
        if(!empty($_POST['email'])){
            try{
            $user = new User(null, $_POST['email']);
            $resp = $user->pwd_reset_link();
            if(json_decode($resp)->status == '0'){
                exit(json_encode(['MSG' => 'Password reset link has been sent to your email']));
            }else{
                exit(json_encode(['ERR' => $resp.json_decode($resp)->message]));
            }
            }catch(Exception $e){
                exit(json_encode(['ERR' => $e->getMessage()]));
            }
        }else{
            exit(json_encode(['ERR' => 'Email is empty']));
        }
    break;
    case 'contact-us':
        try{
            $name = $_POST['name'];
            $email = $_POST['email'];
            $enquiry = $_POST['enquiry'];
            $detail = $_POST['detail'];
            if( 
                empty($name) || 
                empty($email) ||
                empty($enquiry) ||
                empty($detail)
            )
            {
                exit(json_encode(['ERR' => "Fill in all fields."]));
            }
            $u = new User();
            $u_resp = $u->contact_us($_POST);
            if( json_decode($u_resp)->status == '0' ){
                exit(json_encode(['MSG' => "success"]));
            }else{
                exit(json_encode(['ERR' => json_decode($u_resp)->message]));
            }
        }catch(Exception $e){
            exit(json_encode(['ERR' => $e->getMessage()]));
        }
    break;
    case 'new-account':
        try{
            $username = explode('@', $_POST['email'])[0];
            if( $_POST['password'] != $_POST['c_password'] ){
                exit(json_encode(['ERR' => 'Passwords do not match!']));
            }
            if( !$util->isValidPassword($_POST['password']) ){
                exit(json_encode(['ERR' => 'Weak password!']));
            }
            $password = $_POST['password'];
            $c_password = $_POST['c_password'];
            $full_name_ = $_POST['fname'] . ' ' . $_POST['sname'];
            $u = new User($username, $_POST['email'], $password, $c_password, $full_name_);
            $u_resp = $u->new_customer();
            // exit(json_encode(['ERR' => $u_resp]));
            if( json_decode($u_resp)->status == '0' && json_decode($u_resp)->data->id > 0){
                $created_user_id = json_decode($u_resp)->data->id;
                $token = json_decode($u_resp)->data->token;
                $reset_resp = 0;//$u->verify_email_link($token);
                // if(json_decode($reset_resp)->status == '0'){
                if( $reset_resp == 0 ){
                    $body = [
                        'fname' => $_POST['fname'],
                        'sname' => $_POST['sname'],
                        'phone' => $_POST['phone']
                    ];
                    $prof_resp = $u->add_details_client($body, $token, $created_user_id);
                    // exit(json_encode(['ERR' => $prof_resp]));
                    if(json_decode($prof_resp)->status == '0' && json_decode($prof_resp)->userid > 0){
                        exit(json_encode(['MSG' => 'Account created! A link to verify your email address has been sent!']));
                    }else{
                        exit(json_encode(['ERR' => json_decode($prof_resp)->message]));
                    }
                }else{
                    exit(json_encode(['ERR' => json_decode($reset_resp)->message]));
                }
            }else{
                exit(json_encode(['ERR' => json_decode($u_resp)->message]));
            }
        }catch(Exception $e){
            exit(json_encode(['ERR' => $e->getMessage()]));
        }
    break;
    case 'new-account-ptn':
        try{
            if($_POST['business_category'] == 'nn'){
                throw new Exception('business category field is required');
            }
            if($_POST['location'] == 'nn'){
                throw new Exception('Location field is required');
            }
            if(!$_POST['sub_location']){
                throw new Exception('Sub location field is required');
            }
            $body = [
                'email' => $_POST['email'],
                'fname' => $_POST['fname'],
                'sname' => $_POST['sname'],
                'short_description' => $_POST['short_description'],
                'location' => $_POST['location'] .' | '.$_POST['sub_location'],
                'phone' => $_POST['phone'],
                'business_name' => $_POST['business_name'],
                'business_category' => $_POST['business_category'],
                'business_reg_no' => $_POST['business_reg_no']
            ];
            $u = new User();
            $prof_resp = $u->become_partner($body);
            if(json_decode($prof_resp)->status == '0'){
                exit(json_encode(['MSG' => 'Request received. We will review the information and contact you']));
            }else{
                exit(json_encode(['ERR' => json_decode($prof_resp)->message]));
            }
        }catch(Exception $e){
            exit(json_encode(['ERR' => $e->getMessage()]));
        }
        exit();
        /** ================================================================ */
        /** ================================================================ */
        try{
            if($_POST['business_category'] == 'nn'){
                throw new Exception('business category field is required');
            }
            if($_POST['location'] == 'nn'){
                throw new Exception('Location field is required');
            }
            if(!$_POST['sub_location']){
                throw new Exception('Sub location field is required');
            }
            /**================================================== */
            $username = strtolower($util->createCode(6));
            $password = $util->createCode(10);
            $u = new User($username, $_POST['email'], $password, $password);
            /** register */
            $u_resp = $u->new_partner('none');
            // print $u_resp;
            if( json_decode($u_resp)->status == '0' && json_decode($u_resp)->data->id > 0){
                $created_user_id = json_decode($u_resp)->data->id;
                $token = json_decode($u_resp)->data->token;
                /** very email ,,,, reset password */
                $v_email_resp = $u->pwd_reset_link();
                $r_pwd_resp = $u->verify_email_link($token);
                if(json_decode($r_pwd_resp)->status == '0' && json_decode($v_email_resp)->status == '0'){
                    /** complete profile */
                    $body = [
                        'fname' => $_POST['fname'],
                        'sname' => $_POST['sname'],
                        'short_description' => $_POST['short_description'],
                        'location' => $_POST['location'] .' | '.$_POST['sub_location'],
                        'phone' => $_POST['phone'],
                        'business_name' => $_POST['business_name'],
                        'business_category' => $_POST['business_category'],
                        'business_reg_no' => $_POST['business_reg_no']
                    ];
                    $prof_resp = $u->add_details_partner($body, $token, $created_user_id);
                    if(json_decode($prof_resp)->status == '0' && json_decode($prof_resp)->userid > 0){
                        exit(json_encode(['MSG' => 'Account created! A link to verify your email address has been sent!']));
                    }else{
                        exit(json_encode(['ERR' => json_decode($prof_resp)->message]));
                    }
                }else{
                    exit(json_encode(['ERR' => json_decode($r_pwd_resp)->message . ' ' . json_decode($v_email_resp)->message]));
                }
            }else{
                exit(json_encode(['ERR' => json_decode($u_resp)->message]));
            }
        }catch(Exception $e){
            exit(json_encode(['ERR' => $e->getMessage()]));
        }
    break;
    case 'edit-clt-account':
        try{
            $u = new User();
            $uploads = '';
            $editing_user_id = $_POST['user_id'];
            if(empty($editing_user_id)){
                exit(json_encode([ 'ERR' => 'Missing valid user session' ])); 
            }
            $body = [
                'fname' => $_POST['fname'],
                'sname' => $_POST['sname'],
                'phone' => $_POST['phone']
            ];
            if(is_uploaded_file($_FILES['img']['tmp_name'])){
                $_img_resp = $u->edit_profile_pic($editing_user_id, 'img');
                if(empty($_img_resp)){
                    exit(json_encode([ 'ERR' => 'no valid photo was found. Upload failed' ]));
                }
                if(json_decode($_img_resp)->status != '0'){
                    $uploads = 'However, profile pic was not uploaded. Please try again later';
                    // exit(json_encode([ 'ERR' => $_img_resp ]));
                }
            }
            $prof_resp = $u->edit_details_client($body, 0, $editing_user_id);
            // print 'xdvcvcv' . $prof_resp;
            if(json_decode($prof_resp)->status == '0' && json_decode($prof_resp)->userid > 0){
                $info = $u->get_details($editing_user_id);
                $_SESSION['usr_info'] = $info;
                exit(json_encode(['MSG' => 'information updated! ' . $uploads]));
            }else{
                exit(json_encode(['ERR' => json_decode($prof_resp)->message]));
            }
        }catch(Exception $e){
            exit(json_encode(['ERR' => $e->getMessage()]));
        }
    break;
    case 'add-clt-shipping':
        try{
            $token = json_decode($_SESSION['usr'])->access_token;
            // print_r($_POST);
            $s = new Shipping(
                $_POST['customer_id'],
                $_POST['address'],
                $_POST['city'],
                $_POST['province'],
                $_POST['postal_code']
            );
            if($_POST['act'] == '1'){
                $response = $s->create($token);
            }else{
                $response = $s->update($token);
            }
            // exit(json_encode(['ERR' => $response]));
            if(json_decode($response)->status == '0'){
                $_SESSION['usr_shipping'] = $s->get_one($token, $_POST['customer_id']);
                exit(json_encode(['MSG' => 'information updated!']));
            }else{
                exit(json_encode(['ERR' => json_decode($response)->message]));
            }
        }catch(Exception $e){
            exit(json_encode(['ERR' => $e->getMessage()]));
        }
    break;
    case 'edit-ptn-account':
        try{

            $u = new User();
            $editing_user_id = $_POST['user_id'];
            if(empty($_POST['sub_location'])){
                // throw new Exception('Sub location is required, please correct');
                $_POST['sub_location'] = "";
            }else
            {
                $_POST['sub_location'] = ' | ' . $_POST['sub_location']; 
            }
            $body = [
                'fname' => $_POST['fname'],
                'sname' => $_POST['sname'],
                'short_description' => $_POST['short_description'],
                'location' => $_POST['location'] . $_POST['sub_location'],
                'phone' => $_POST['phone'],
                'email' => $_POST['email'],
                'business_name' => $_POST['business_name'],
                'business_category' => $_POST['business_category'],
                'business_reg_no' => $_POST['business_reg_no']
            ];
            /** $_img_resp = $u->edit_profile_pic($editing_user_id, 'img');
            * if(empty($_img_resp)){
            *     exit(json_encode([ 'ERR' => 'Logo upload failed' ]));
            * }
            * if(json_decode($_img_resp)->status != '0'){
            *     exit(json_encode([ 'ERR' => json_decode($_img_resp)->message ]));
            * }
            */
            $prof_resp = $u->edit_details_partner($body, 0, $editing_user_id);
            // print $prof_resp;
            if(json_decode($prof_resp)->status == '0' && json_decode($prof_resp)->userid > 0){
                $info = $u->get_details($editing_user_id);
                $_SESSION['usr_info'] = $info;
                // $_img_resp = $u->edit_profile_pic($editing_user_id, 'img');
                exit(json_encode(['MSG' => 'Partner information updated!']));
            }else{
                exit(json_encode(['ERR' => $prof_resp.json_decode($prof_resp)->message]));
            }
        }catch(Exception $e){
            exit(json_encode(['ERR' => $e->getMessage()]));
        }
    break;
    case 'declare-lost-voucher':
        try{
            $i = new Inventory();
            if(empty($_POST['voucher'])){
                throw new Exception('voucher code is required');
            }
            if(empty($_POST['customer_user_id'])){
                throw new Exception('User Id is required');
            }
            $cancellation_date = date('Y-m-d');
            $body = [
                'cancellation_date' => $cancellation_date,
                'customer_user_id' => $_POST['customer_user_id'],
                'cancelled_by' => $_POST['customer_user_id']
            ];
            $resp_ = $i->customer_cancel_voucher($body, $_POST['voucher']);
            // print $resp_;
            if( json_decode( $resp_)->status == '0'){
                exit(json_encode(['MSG' => json_decode( $resp_)->message, 'V' => json_decode( $resp_)->voucher]));
            }else{
                exit(json_encode(['ERR' => json_decode( $resp_)->message]));
            }
        }catch(Exception $e){
            exit(json_encode(['ERR' => $e->getMessage()]));
        }
    break;
    case 'activate-clt-voucher':
        try{
            $i = new Inventory();
            if(empty($_POST['vcode'])){
                throw new Exception('voucher code is required');
            }
            $activation_date = date('Y-m-d');
            $body = [
                'activation_date' => $activation_date,
                'customer_user_id' => $_POST['customer_user_id']
            ];
            $resp_ = $i->customer_activate($body, $_POST['vcode']);
            // print $resp_;
            if( json_decode( $resp_)->status == '0'){
                $v_date = date('d/m/Y', strtotime(json_decode( $resp_)->validity));
                exit(json_encode(['MSG' => json_decode( $resp_)->message, 'V' => json_decode( $resp_)->voucher, 'Valid' => $v_date]));
            }else{
                exit(json_encode(['ERR' => json_decode( $resp_)->message]));
            }
        }catch(Exception $e){
            exit(json_encode(['ERR' => $e->getMessage()]));
        }
    break;
    case 'update-ptn-paydate':
        try{
            $i = new Inventory();
            if(empty($_POST['e_id'])){
                throw new Exception('entry code is required');
            }
            if( empty($_POST['ed'])){
                throw new Exception('Select date');
            }
            $partner_pay_effec_date = date('Y-m-d', strtotime($_POST['ed']));
            $body = [
                'partner_pay_effec_date' => $partner_pay_effec_date
            ];
            $resp_ = $i->partner_pay_effec_date($body, $_POST['e_id']);
            if( json_decode( $resp_)->status == '0'){
                exit(json_encode(['MSG' => 'Date updated!']));
            }else{
                exit(json_encode(['ERR' => json_decode( $resp_)->message]));
            }
        }catch(Exception $e){
            exit(json_encode(['ERR' => $e->getMessage()]));
        }
    break;
    case 'redeem-ptn-voucher':
        try{
            $i = new Inventory();
            if(empty($_POST['voucher'])){
                throw new Exception('voucher code is required');
            }
            if( empty($_POST['rservice']) || $_POST['rservice'] == 'nn' ){
                throw new Exception('Select service to redeem');
            }
            if( empty($_POST['booking_date']) ){
                throw new Exception('Select a valid booking date');
            }
            if( $_POST['partner_pay_amount'] < 1 ){
                throw new Exception('Pay amount is invalid');
            }
            $redeemed_date = date('Y-m-d');
            $booking_date = date('Y-m-d', strtotime($_POST['booking_date']));
            if( $redeemed_date > $booking_date){
                throw new Exception('Select a valid booking date. You cannot book in the past');
            }
            $body = [
                'redeemed_date' => $redeemed_date,
                'partner_identity' => $_POST['partner'],
                'booking_date' => $booking_date,
                'redeemed_service' => $_POST['rservice'],
                'partner_pay_amount' => $_POST['partner_pay_amount']
            ];
            $resp_ = $i->partner_redeem($body, $_POST['voucher']);
            if( json_decode( $resp_)->status == '0'){
                exit(json_encode(['MSG' => 'Voucher redeemed & service booked for customer', 'V' => json_decode( $resp_)->voucher]));
            }else{
                exit(json_encode(['ERR' => json_decode( $resp_)->message]));
            }
        }catch(Exception $e){
            exit(json_encode(['ERR' => $e->getMessage()]));
        }
    break;
    case 'modify-voucher-booking':
        try{
            $i = new Inventory();
            if(empty($_POST['modi_voucher'])){
                throw new Exception('Invalid voucher!');
            }
            if(empty($_POST['new_booking_date'])){
                throw new Exception('Invalid date!');
            }
            if(empty($_POST['partner'])){
                throw new Exception('Invalid partner code!');
            }
            $today = date('Y-m-d');
            $new_booking_date = date('Y-m-d', strtotime($_POST['new_booking_date']));
            if( $today > $new_booking_date ){
                throw new Exception('Invalid date! You cannot book a past date');
            }
            $body = [
                'new_booking_date' => $new_booking_date,
                'partner_identity' => $_POST['partner']
            ];
            $resp_ = $i->partner_modify_booking($body, $_POST['modi_voucher']);
            if( json_decode( $resp_)->status == '0'){
                exit(json_encode(['MSG' => 'Voucher booking date has been changed to '.date('d/m/Y', strtotime($_POST['new_booking_date'])), 'V' => json_decode( $resp_)->voucher]));
            }else{
                exit(json_encode(['ERR' => json_decode( $resp_)->message]));
            }
        }catch(Exception $e){
            exit(json_encode(['ERR' => $e->getMessage()]));
        }
    break;
    case 'cancel-ptn-voucher':
        try{
            $i = new Inventory();
            $_POST['voucher'] = $_POST['vcode'];
            if(empty($_POST['voucher'])){
                throw new Exception('voucher code is required');
            }
            if(empty($_POST['partner'])){
                throw new Exception('Invalid partner code!');
            }
            if(empty($_POST['vreason'])){
                throw new Exception('Explain why you are cancelling this voucher!');
            }
            $cancellation_date = date('Y-m-d');
            $body = [
                'cancellation_date' => $cancellation_date,
                'partner_identity' => $_POST['partner'],
                'reason' => $_POST['vreason']
            ];
            $resp_ = $i->partner_cancel_voucher($body, $_POST['voucher']);
            if( json_decode( $resp_)->status == '0'){
                exit(json_encode([
                    'MSG' => 'Voucher has been successfully cancelled. The customer has been emailed a new voucher', 
                    'V' => null
                ]));
            }else{
                exit(json_encode(['ERR' => json_decode( $resp_)->message]));
            }
        }catch(Exception $e){
            exit(json_encode(['ERR' => $e->getMessage()]));
        }
    break;
}
?>