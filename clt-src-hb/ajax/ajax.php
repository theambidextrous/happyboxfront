<?php 
session_start();
require_once '../../lib/Util.php';
$util = new Util();
$util->ShowErrors(1);
require_once '../../lib/User.php';
require_once '../../lib/Inventory.php';

switch($_REQUEST['activity']){
    default:
        exit(json_encode(['ERR' => 'Mission Failed!']));
    break;
    case 'forgot-rest-link':
        if(!empty($_POST['email'])){
            try{
            $user = new User(null, $_POST['email']);
            $resp = $user->pwd_reset_link();
            if(json_decode($resp)->status == '0'){
                exit(json_encode(['MSG' => 'Password reset link has been sent to your email']));
            }else{
                exit(json_encode(['ERR' => json_decode($resp)->message]));
            }
            }catch(Exception $e){
                exit(json_encode(['ERR' => $e->getMessage()]));
            }
        }else{
            exit(json_encode(['ERR' => 'Email is empty']));
        }
    break;
    case 'new-account':
        try{
            $username = explode('@', $_POST['email'])[0];
            $password = $_POST['password'];
            $c_password = $_POST['c_password'];
            $u = new User($username, $_POST['email'], $password, $c_password);
            $u_resp = $u->new_customer();
            if( json_decode($u_resp)->status == '0' && json_decode($u_resp)->data->id > 0){
                $created_user_id = json_decode($u_resp)->data->id;
                $token = json_decode($u_resp)->data->token;
                $reset_resp = $u->pwd_reset_link();
                if(json_decode($reset_resp)->status == '0'){
                    $body = [
                        'fname' => $_POST['fname'],
                        'mname' => $_POST['mname'],
                        'sname' => $_POST['sname'],
                        'phone' => $_POST['phone']
                    ];
                    $prof_resp = $u->add_details_client($body, $token, $created_user_id);
                    if(json_decode($prof_resp)->status == '0' && json_decode($prof_resp)->userid > 0){
                        exit(json_encode(['MSG' => 'Account created and a message containing password reset link has been send your email address']));
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
            $username = explode('@', $_POST['email'])[0];
            $password = $_POST['password'];
            $c_password = $_POST['c_password'];
            $u = new User($username, $_POST['email'], $password, $c_password);
            $u_resp = $u->new_customer();
            if( json_decode($u_resp)->status == '0' && json_decode($u_resp)->data->id > 0){
                $created_user_id = json_decode($u_resp)->data->id;
                $token = json_decode($u_resp)->data->token;
                $reset_resp = $u->pwd_reset_link();
                if(json_decode($reset_resp)->status == '0'){
                    $body = [
                        'fname' => $_POST['fname'],
                        'mname' => $_POST['mname'],
                        'sname' => $_POST['sname'],
                        'phone' => $_POST['phone']
                    ];
                    $prof_resp = $u->add_details_client($body, $token, $created_user_id);
                    if(json_decode($prof_resp)->status == '0' && json_decode($prof_resp)->userid > 0){
                        exit(json_encode(['MSG' => 'Account created and a message containing password reset link has been send your email address']));
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
    case 'edit-adm-account':
        try{

            $u = new User();
            $editing_user_id = $_POST['user_id'];
            if(empty($_POST['sub_location'])){
                throw new Exception('Sub location is required, please correct');
            }
            $body = [
                'fname' => $_POST['fname'],
                'mname' => $_POST['mname'],
                'sname' => $_POST['sname'],
                'short_description' => $_POST['short_description'],
                'location' => $_POST['location'].' | '. $_POST['sub_location'],
                'phone' => $_POST['phone'],
                'business_name' => $_POST['business_name'],
                'business_category' => $_POST['business_category'],
                'business_reg_no' => $_POST['business_reg_no']
            ];
            $_img_resp = $u->edit_profile_pic($editing_user_id, 'img');
            if(empty($_img_resp)){
                exit(json_encode([ 'ERR' => 'Logo upload failed' ]));
            }
            if(json_decode($_img_resp)->status != '0'){
                exit(json_encode([ 'ERR' => json_decode($_img_resp)->status ]));
            }
            $prof_resp = $u->edit_details_partner($body, 0, $editing_user_id);
            // print $prof_resp;
            if(json_decode($prof_resp)->status == '0' && json_decode($prof_resp)->userid > 0){
                $info = $u->get_details($editing_user_id);
                $_SESSION['usr_info'] = $info;
                $_img_resp = $u->edit_profile_pic($editing_user_id, 'img');
                exit(json_encode(['MSG' => 'Partner information updated!']));
            }else{
                exit(json_encode(['ERR' => json_decode($prof_resp)->message]));
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
            $redeemed_date = date('Y-m-d h:i:s');
            $body = [
                'redeemed_date' => $redeemed_date,
                'partner_identity' => $_POST['partner'],
                'booking_date' => $_POST['booking_date']
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
}
?>