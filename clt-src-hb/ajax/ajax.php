<?php 
session_start();
require_once '../../lib/Util.php';
$util = new Util();
// $util->ShowErrors();
require_once '../../lib/User.php';

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
}
?>