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
    function timed_redirect($to){
        print '<script>
            window.setTimeout(function() {
                window.location.href = "'.$to.'";
            }, 2000);
        </script>';
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
    function v_search_table($data){
        $div = '<div class="voucher_result_bar">
            <div class="voucher_no">
                VOUCHER NUMBER
            </div> 
            <div class="voucher_no_value ">
                '.$data[0].'
            </div>
            <div class="voucher_status">
                STATUS
            </div>
            <div class="voucher_status_value">
                '.$this->get_v_status_name($data[1]).'
            </div>
            <div class="voucher_partner">
                PARTNER
            </div>
            <div class="voucher_partner_val col-md-3 border_right">
                '.$data[2].'
            </div>
            <div class="voucher_partner2 col-md-3">
            '.$data[3].' 
            </div>
        </div>';
    return $div;
    }
    function Show($toshow){
        print'<pre>';
        print_r($toshow);
        print'</pre>';
    }
    function cust_buyer_keys(){
        return [
            'customer_buyer_id_0',
            'customer_buyer_id_1',
            'customer_buyer_id_2',
            'customer_buyer_id_3'
        ];
    }
    function cust_user_keys(){
        return [
            'customer_user_id_0',
            'customer_user_id_1',
            'customer_user_id_2',
            'customer_user_id_3'
        ];
    }
    function box_keys(){
        return [
            'box_internal_id_0',
            'box_internal_id_1'
        ];
    }
    function indirect_cols(){
        return [
            'customer_buyer_id_0',
            'customer_buyer_id_1',
            'customer_buyer_id_2',
            'customer_buyer_id_3',
            'customer_user_id_0',
            'customer_user_id_1',
            'customer_user_id_2',
            'customer_user_id_3',
            'partner_internal_id',
            'box_internal_id_0',
            'box_internal_id_1'
        ];
    }
    function report_headers($cols){
        $h = '<thead><tr>';
        foreach( $this->report_cols() as $k => $v ){
            if(in_array($k, $cols)){
                $h .= '<th>'.$v.'</th>';
            }
        }
        $h .= '</tr></thead>';
        return $h;
    }
    function get_v_status_name($v){
        if($v == 1){
            return 'Not purchased';
        }elseif($v == 2){
            return 'Purchased';
        }elseif($v == 3){
            return 'Redeemed';
        }elseif($v == 4){
            return 'Cancelled';
        }elseif($v == 5){
            return 'Expired';
        }else{
            return 'N/A';
        }
    }
    function report_body($results, $cols, $user_ob, $box_ob, $token){
        $b = '<tbody>';
        $n_a = 'N/A';
        foreach( $results as $result ):
            $b .= '<tr>';
            foreach( $this->report_cols() as $k => $v ){
                if( array_key_exists($k, $result) && in_array($k, $cols)  && !in_array($k, $this->indirect_cols())){
                    if($k == 'box_voucher_status'){
                        $b .= '<td>'.$this->get_v_status_name($result[$k]).'</td>';
                    }else{
                        $value = !empty($result[$k])?$result[$k]:'N/A';
                        $b .= '<td>'.$value.'</td>';
                    }
                }elseif(in_array($k, $this->indirect_cols()) && in_array($k, $cols) ){
                    if(in_array($k, $this->cust_buyer_keys())){
                        $cust_buyer_id = $result['customer_buyer_id'];
                        $cust_data = json_decode($user_ob->get_details_byidf($cust_buyer_id))->data;
                        if($k == 'customer_buyer_id_0'){
                            $n = $cust_data->fname . '' . $cust_data->mname;
                            $cname = !empty($n)?$n:'N/A';
                            $b .= '<td>'.$cname.'</td>';
                        }elseif($k == 'customer_buyer_id_1'){
                            $cname = !empty($cust_data->sname)?$cust_data->sname:'N/A';
                            $b .= '<td>'.$cname.'</td>';
                        }elseif($k == 'customer_buyer_id_2'){
                            $email = !empty($cust_data->email)?$cust_data->email:'N/A';
                            $b .= '<td>'.$email.'</td>';
                        }elseif($k == 'customer_buyer_id_3'){
                            $phone = !empty($cust_data->phone)?$cust_data->phone:'N/A';
                            $b .= '<td>'.$phone.'</td>';
                        }
                    }elseif(in_array($k, $this->cust_user_keys())){
                        $cust_user_id = $result['customer_user_id'];
                        $cust_data = json_decode($user_ob->get_details_byidf($cust_user_id))->data;
                        if($k == 'customer_user_id_0'){
                            $n = $cust_data->fname . '' . $cust_data->mname;
                            $cname = !empty($n)?$n:'N/A';
                            $b .= '<td>'.$cname.'</td>';
                        }elseif($k == 'customer_user_id_1'){
                            $cname = !empty($cust_data->sname)?$cust_data->sname:'N/A';
                            $b .= '<td>'.$cname.'</td>';
                        }elseif($k == 'customer_user_id_2'){
                            $email = !empty($cust_data->email)?$cust_data->email:'N/A';
                            $b .= '<td>'.$email.'</td>';
                        }elseif($k == 'customer_user_id_3'){
                            $phone = !empty($cust_data->phone)?$cust_data->phone:'N/A';
                            $b .= '<td>'.$phone.'</td>';
                        }
                    }elseif(in_array($k, $this->box_keys())){
                        $box_internal_id = $result['box_internal_id'];
                        $bbb_ = $box_ob->get_byidf($token, $box_internal_id);
                        $box_data = json_decode($bbb_)->data;
                        if($k == 'box_internal_id_0'){
                            $bname = !empty($box_data->name)?$box_data->name:$n_a;
                            $b .= '<td>'.$bname.'</td>';
                        }elseif($k == 'box_internal_id_1'){
                            $bprice = !empty($box_data->price)?$box_data->price:'N/A';
                            $b .= '<td> KES '.$bprice.'</td>';
                        }
                    }elseif($k == 'partner_internal_id'){
                        $partner_internal_id = $result['partner_internal_id'];
                        $partner_data = json_decode($user_ob->get_details_byidf($partner_internal_id))->data;
                        $bname = !empty($partner_data->business_name)?$partner_data->business_name:'N/A';
                        $b .= '<td>'.$bname.'</td>';
                    }
                }else{

                }
            }
            $b .= '</tr>';
        endforeach;
        $b .= '</tbody>';
        return $b;
    }
    function build_report_table($results, $cols,$user, $box, $token){
        $cols = explode(',', $cols);
        $table = '<div class="table-responsive"><table id="report_id" class="table table_data1 table-bordered">';
        $table .= $this->report_headers($cols);
        $table .= $this->report_body($results, $cols,$user, $box, $token);
        $table .= '</table></div>';
        return $table;
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