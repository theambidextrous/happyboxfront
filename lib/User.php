<?php 
/** 
 * @author - j.o
 * @license propriatery
 * @file - User.php
 * @usage - User objects
 */

 class User
 {
    private $username;
    private $email;
    private $password;
    private $c_password;
    function __construct($username=null,$email=null,$password=null,$c_password=null){
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->c_password = $c_password;
    }
    function get_one($id, $token){
        $endpoint = 'users/findbyid/' . $id;
        $util = new Util();
        $body = [];
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $util->AppAPI() . $endpoint);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers($token));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
        curl_setopt($curl, CURLOPT_HEADER, false);
        $res = curl_exec($curl);
        return $res;
    }
    function get_all($token, $endpoint = 'users/findall'){
        $util = new Util();
        $body = [];
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $util->AppAPI() . $endpoint);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers($token));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
        curl_setopt($curl, CURLOPT_HEADER, false);
        $res = curl_exec($curl);
        return $res;
    }
    function get_all_partner($token){
        $endpoint = 'users/partners/findall';
        return $this->get_all($token, $endpoint);
    }
    function get_all_customers($token){
        $endpoint = 'users/clients/findall';
        return $this->get_all($token, $endpoint);
    }
    function get_all_admins($token){
        $endpoint = 'users/admins/findall';
        return $this->get_all($token, $endpoint);
    }
    function create($endpoint = 'users/clients/register', $token = ''){
        $util = new Util();
        $this->validate();
        $body = ['username' => $this->username, 'email' => $this->email, 'password' => $this->password, 'c_password' => $this->c_password];
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $util->AppAPI() . $endpoint);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers($token));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
        curl_setopt($curl, CURLOPT_HEADER, false);
        $res = curl_exec($curl);
        return $res;
    }
    function new_partner($token = ''){
        $endpoint = 'users/partners/register';
        return $this->create($endpoint);
    }
    function new_admin($token){
        $endpoint = 'users/admins/register';
        return $this->create($endpoint, $token);
    }
    function new_customer($token = ''){
        return $this->create();
    }
    function login($endpoint = 'users/login'){
        $util = new Util();
        $this->validate_login();
        $body = ['email' => $this->email, 'password' => $this->password];
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $util->AppAPI() . $endpoint);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers());
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
        curl_setopt($curl, CURLOPT_HEADER, false);
        $res = curl_exec($curl);
        // $util->Show(curl_getinfo($curl));
        return $res;
    }
    function get_details($userid, $endpoint = 'users/info/'){
        $this->is_loggedin();
        $token = json_decode($_SESSION['usr'])->access_token;
        $util = new Util();
        $body = [];
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $util->AppAPI() . $endpoint . $userid);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers($token));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
        curl_setopt($curl, CURLOPT_HEADER, false);
        $res = curl_exec($curl);
        // $util->Show(curl_getinfo($curl));
        return $res;
    }
    function get_details_byidf($idf, $endpoint = 'users/info/byidf/'){
        // $this->is_loggedin();
        $token = json_decode($_SESSION['usr'])->access_token;
        $util = new Util();
        $body = [];
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $util->AppAPI() . $endpoint . $idf);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers($token));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
        curl_setopt($curl, CURLOPT_HEADER, false);
        $res = curl_exec($curl);
        return $res;
    }
    function add_details($body, $endpoint, $token){
        // $this->is_loggedin();
        // if($token == 0){
        //     $token = json_decode($_SESSION['usr'])->access_token;
        // }
        $util = new Util();
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $util->AppAPI() . $endpoint);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers($token));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
        curl_setopt($curl, CURLOPT_HEADER, false);
        $res = curl_exec($curl);
        return $res;
    }
    function add_details_partner($body, $token, $user_id){
        $endpoint = 'users/partners/profile/' . $user_id;
        return $this->add_details($body, $endpoint, $token);
    }
    function add_details_client($body, $token, $user_id){
        $endpoint = 'users/clients/profile/' . $user_id;
        return $this->add_details($body, $endpoint, $token);
    }
    function edit_details($body, $endpoint = '', $token = 0){
        $this->is_loggedin();
        if($token == 0){
            $token = json_decode($_SESSION['usr'])->access_token;
        }
        $util = new Util();
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $util->AppAPI() . $endpoint);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers($token));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
        curl_setopt($curl, CURLOPT_HEADER, false);
        $res = curl_exec($curl);
        return $res;
    }
    function edit_details_partner($body, $token, $user_id){
        $endpoint = 'users/partners/profile/' . $user_id;
        return $this->edit_details($body, $endpoint, $token);
    }
    function edit_details_client($body, $token, $user_id){
        $endpoint = 'users/clients/profile/' . $user_id;
        return $this->edit_details($body, $endpoint, $token);
    }
    function edit_profile_pic($user, $img){
        $endpoint = 'users/profilepic/' . $user;
        $this->is_loggedin();
        $token = json_decode($_SESSION['usr'])->access_token;
        $util = new Util();
        $tmpfile = $_FILES[$img]['tmp_name'];
        $filename = basename($_FILES[$img]['name']);
        $cfile = new CURLFile($tmpfile,'image/jpeg', $filename);
        $body = [
            'img' => $cfile
        ];
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $util->AppAPI() . $endpoint);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->file_headers($token));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
        curl_setopt($curl, CURLOPT_HEADER, false);
        $res = curl_exec($curl);
        return $res;
    }
    function is_loggedin($endpoint = 'users/loginstatus'){
        $token = json_decode($_SESSION['usr'])->access_token;
        $util = new Util();
        $body = [];
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $util->AppAPI() . $endpoint);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers($token));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
        curl_setopt($curl, CURLOPT_HEADER, false);
        $res = curl_exec($curl);
        if( json_decode($res)->status == '0'){
            return true;
        }
        session_destroy();
        $util->redirect_to($util->AdminHome(), 1);
    }
    function pwd_reset_link($endpoint = 'users/forgotpassword'){
        $util = new Util();
        $body = [ 'email' => $this->email ];
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $util->AppAPI() . $endpoint);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers());
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
        curl_setopt($curl, CURLOPT_HEADER, false);
        $res = curl_exec($curl);
        return $res;
    }
    function pwd_reset($body){
        $endpoint = 'users/resetpassword';
        $util = new Util();
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $util->AppAPI() . $endpoint);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers());
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
        curl_setopt($curl, CURLOPT_HEADER, false);
        $res = curl_exec($curl);
        return $res;
    }
    function format_box_partners($csv){
        $_part = explode(',',$csv);
        foreach( $_part as $idf ){
            $data = json_decode($this->get_details_byidf($idf))->data;
            $_names[] = $data->business_name;
        }
        return implode(', ', $_names);
    }
    function headers($token = ''){
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: Bearer ' . $token;
        return $headers;
    }
    function file_headers($token = ''){
        $headers[] = 'Content-Type: multipart/form-data';
        $headers[] = 'Authorization: Bearer ' . $token;
        return $headers;
    }
    function validate_login(){
        if( !$this->is_valid_mail($this->email) ){
            throw new Exception('Invalid email address');
        }
        if( empty($this->password) ){
            throw new Exception('Password field is empty');
        }
        return true;
    }
    function validate(){
        if( empty($this->username) ){
            throw new Exception('Username field is empty');
        }
        if( !$this->is_valid_mail($this->email) ){
            throw new Exception('Invalid email address');
        }
        if( empty($this->password) ){
            throw new Exception('Password field is empty');
        }
        if( $this->c_password != $this->password ){
            throw new Exception('Passwords must match');
        }
        return true;
    }
    function is_valid_mail($email){
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }
 }
 
?>