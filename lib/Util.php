<?php 
/** 
 * @author - j.o
 * @license propriatery
 * @file - Util.php
 * @usage - utilities objects
 */

 class Util
 {
    function LoadEnv(){
        $env = parse_ini_file('C:\xampp\htdocs\happyboxfront\.env');
        // $env = parse_ini_file('/var/www/happybox.ke/public_html/staging/.env');
        return json_decode(json_encode($env));
    }
    function AppHome(){
        return $this->LoadEnv()->APP_HOME;
    }
    function AdminHome(){
        return $this->LoadEnv()->APP_ADMIN_HOME;
    }
    function AppErrors(){
        return $this->LoadEnv()->APP_ERRORS;
    }
    function PartnerHome(){
        return $this->LoadEnv()->APP_PARTNER_HOME;
    }
    function ClientHome(){
        return $this->LoadEnv()->APP_CLIENT_HOME;
    }
    function AppAPI(){
        return $this->LoadEnv()->APP_API;
    }
    function AppUploads(){
        return $this->LoadEnv()->APP_UPLOADS;
    }
    function error_flash($e){
        return '<p class="alert alert-danger">'.$e.'</p>';
    }
    function success_flash($e){
        return '<p class="alert alert-success">'.$e.'</p>';
    }
    function redirect_to($to, $t = 0){
        if($t>0){
            print '<script>window.location.replace("'.$to.'")</script>';
            return;
        }
        header("Location: " . $to);
    }
    function ShowErrors($f=0){
        if($this->AppErrors() == 0){
            return;
        }
        if($f == 0){
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
        }else{
            error_reporting(0);
        }
    }
    function createCode($length = 20) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    function Show($toshow){
        print'<pre>';
        print_r($toshow);
        print'</pre>';
    }
    function get_media_types(){
        return ['Image', '3D Image', 'PDF Booklet', 'Video File'];
    }
    function is_admin(){
        if(json_decode($_SESSION['usr'])->user->is_admin){
            return true;
        }
        return false;
    }
 }
 
?>