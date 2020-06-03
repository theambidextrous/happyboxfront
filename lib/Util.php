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
    function AjaxHome(){
        return $this->LoadEnv()->APP_CLIENT_HOME . '/ajax/ajax.php';
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
    function msg_box(){
        print '<p style="display:none;" id="succ" class="alert alert-success"></p>
        <p style="display:none;" id="err" class="alert alert-danger"></p>';
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
            error_reporting(E_ALL ^ E_NOTICE);
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
    function locations_list(){
        return  ['Nairobi','Mombasa','Nakuru','Naivasha','Kisumu','Lamu','Malindi','Kitale'];
    }
    function ValidatePasswordStrength($password){
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number    = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);
        if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
            throw new Exception('Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.');
            return false;
        }
        return true;
    }
    function Show($toshow){
        print'<pre>';
        print_r($toshow);
        print'</pre>';
    }
    function report_cols(){
        $r  = [
            'order_number' => 'Order Number',
            'customer_buyer_id_0' => 'Customer Buyer Name',
            'customer_buyer_id_1' => 'Customer Buyer Surname',
            'customer_buyer_id_2' => 'Customer Buyer Email',
            'customer_buyer_id_3' => 'Customer Buyer Phone',
            'customer_payment_method' => 'Customer Buyer Payment Method',
            'box_delivery_address' => 'Box Delivery Address',
            'box_purchase_date' => 'Box Puchase Date',
            'box_validity_date' => 'Box Validity Date',
            'customer_buyer_invoice' => 'Customer Buyer Invoice Number',
            'box_barcode' => 'Box Barcode',
            'box_internal_id_0' => 'Box Name',
            'box_voucher' => 'Voucher Code',
            'box_voucher_new' => 'New Voucher Code',
            'box_voucher_status' => 'Voucher Status',
            'voucher_activation_date' => 'Voucher Activation Date',
            'customer_user_id_0' => 'Customer User Name',
            'customer_user_id_1' => 'Customer User Surname',
            'customer_user_id_2' => 'Customer User Email',
            'customer_user_id_3' => 'Customer User Phone',
            'redeemed_date' => 'Redeemed Date',
            'cancellation_date' => 'Cancellation Date',
            'booking_date' => 'Booking Date',
            'box_internal_id_1' => 'Box Price',
            'partner_pay_due_date' => 'Partner Reimbursment Due Date',
            'partner_pay_effec_date' => 'Partner Reimbursment Effective Date',
            'partner_pay_amount' => 'Partner Reimbursment',
            'partner_internal_id' => 'Partner Identity',
            'partner_invoice' => 'Partner Invoice number'
        ];
        return $r;
    }
    function get_media_types(){
        return ['Image', '3D Image', 'PDF Booklet', 'Video File'];
    }
    function is_partner(){
        if(json_decode($_SESSION['usr'])->user->is_partner){
            return true;
        }
        return false;
    }
    function is_admin(){
        if(json_decode($_SESSION['usr'])->user->is_admin){
            return true;
        }
        return false;
    }
    function modal_click($id){
        print '
        <script>
            var link = document.getElementById("'.$id.'");
            link.click();
        </script>
        ';
    }
 }
 
?>