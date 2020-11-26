<?php 
/** 
 * @author - j.o
 * @license propriatery
 * @file - Order.php
 * @usage - Order objects
 */
require_once dirname(__DIR__).'/lib/Util.php';
require_once dirname(__DIR__).'/lib/Order.php';
$util = new Util();
require_once dirname(__DIR__).'/lib/Box.php';
require_once dirname(__DIR__).'/lib/Picture.php';

//require_once 'C:\xampp\htdocs\happyboxfront\lib\Util.php';
//require_once 'C:\xampp\htdocs\happyboxfront\lib\Order.php';
//$util = new Util();
//require_once 'C:\xampp\htdocs\happyboxfront\lib\Box.php';
//require_once 'C:\xampp\htdocs\happyboxfront\lib\Picture.php';

 class Order
 {
    private $token;
    function __construct($token){
        $this->token = $token;
    }
    function process_mpesa_c2b($mpesa){
        global $util;
        // $util->Show($mpesa);
        try{
            date_default_timezone_set('Africa/Nairobi');
            $Mpesa_Order = $mpesa['BillRefNumber'];
            $Mpesa_code = $mpesa['TransID'];
            $mpesa_desc = 'Paid by '. $mpesa['FirstName']. ' ' . $mpesa['LastName'] . ' via mpesa number ' . $mpesa['MSISDN'];
            $this_order = $this->get_one_by_order_req_id($Mpesa_Order);
            if( json_decode($this_order)->status != '0' || !json_decode($this_order, true)['data'] ){
                throw new Exception('get_one_by_order_req_id()::: Errors or empty response for pay:: '.$Mpesa_code . ' =>' . $Mpesa_Order);
            }
            if( json_decode($this_order)->status == '0'){
                $order_meta = json_decode($this_order, true)['data'];
                $order_id = $order_meta['order_id'];
                $order_amount = floor($order_meta['order_totals']);
                $token = $order_meta['token'];
                if( floor($mpesa['TransAmount']) >= $order_amount ) /** fully paid */
                {
                    $req_body = [
                        'order' => $order_id,
                        'amount' => $mpesa['TransAmount'],
                        'ref' => $Mpesa_code,
                        'status' => 0,
                        'date_time' => $mpesa['TransTime'],
                        'description' => $mpesa_desc,
                        'method' => 'MPESA C2B',
                        'phone' => $mpesa['MSISDN'],
                        'pay_string' => json_encode($mpesa)
                    ];
                    $_pay_resp = $this->add_a_payment($token, $req_body);
                    if( json_decode($_pay_resp)->status != '0' ){
                        throw new Exception($_pay_resp);
                    }
                    $order_full_data = $this->get_ord_one($token, $order_id);
                    if( json_decode($order_full_data)->status != '0' ){
                        throw new Exception('get_ord_one() Order full data error:::: ' .$order_full_data);
                    }
                    if( count(json_decode($order_full_data, true)['data']) < 1 ){
                        throw new Exception('Order not found: ' .$order_full_data);
                    }
                    $order_full_data = json_decode($order_full_data, true)['data'];
                    $cust_buyer = $order_full_data['customer_buyer'];
                    $order_items = json_decode($order_full_data['order_string'], true);
                    $e_vouchers = $p_vouchers = [];
                    $box = new Box();
                    $picture = new Picture();
                    foreach( $order_items  as $_order_item ):
                        if(!isset($_order_item['order_id'])){
                            $_box_data_resp = $box->get_byidf('00', $_order_item[0]);
                            if(json_decode($_box_data_resp)->status != '0'){
                                throw new Exception($_box_data_resp);
                            }
                            $_box_data = json_decode($_box_data_resp)->data;
                            $_media = $picture->get_byitem('00', $_order_item[0]);
                            if(json_decode($_media)->status != '0'){
                                throw new Exception($_media);
                            }
                            $_media = json_decode($_media, true)['data'];
                            if($_order_item[2] == 2){ /** ebox */
                                /** generate evouchers and populate inventry */
                                $_llp = 0;
                                $ev = [] ;
                                while( $_llp < $_order_item[1] ){
                                    array_push($ev, 'E-' . $util->createCode(8));
                                    $_llp ++;
                                }
                                /** create the evouchers */
                                $purchase_date = date('Y-m-d', time());
                                $box_validity_object = new DateTime("+6 months");
                                $box_validity_date = $box_validity_object->format("Y-m-d");
                                $evouchers_this_ = implode(',', $ev);
                                $body = [
                                    'box_internal_id' => $_order_item[0],
                                    'order_number' => $order_id,
                                    'customer_buyer_id' => $cust_buyer,
                                    'customer_payment_method' => $Mpesa_code . '~Mpesa C2B',
                                    'box_purchase_date' => $purchase_date,
                                    'box_validity_date' => $box_validity_date,
                                    'customer_buyer_invoice' => $order_id,
                                    'box_vouchers' => $evouchers_this_,
                                    'box_voucher_status' => '2',
                                    'box_delivery_address' => $_order_item[4][0]
                                ];
                                $_c_resp = $this->create_c_buyer_ebox($token, $body);
                                if(json_decode($_c_resp)->status != '0'){
                                    throw new Exception($_c_resp);
                                }
                            }else{ /** pbox */
                                /** there is pbox write to cron logs */
                                $mcron_body = [
                                    'order_id' => $order_id,
                                    'customer_buyer' => $cust_buyer,
                                    'box_voucher' => $_box_data->name,
                                    'order_meta' => $order_full_data['order_string'], 
                                    'deliver_to' => $order_physical_address[1],
                                    'sendy_log' => 'sendy_log',
                                ];
                                $cron_resp = $this->new_cron($token, $mcron_body);
                                if(json_decode($cron_resp)->status != '0'){
                                    throw new Exception($cron_resp);
                                }
                                /** allocate pvouchers to this order */
                                $_box_qty = $_order_item[1];
                                $purchase_date = date('Y-m-d', time());
                                $box_validity_object = new DateTime("+6 months");
                                $box_validity_date = $box_validity_object->format("Y-m-d");
                                $body = [
                                    'box_internal_id' => $_order_item[0],
                                    'order_number' => $order_id,
                                    'customer_buyer_id' => $cust_buyer,
                                    'customer_payment_method' => $Mpesa_code . '~Mpesa C2B',
                                    'box_purchase_date' => $purchase_date,
                                    'box_validity_date' => $box_validity_date,
                                    'customer_buyer_invoice' => $order_id,
                                    'box_qty' => $_box_qty,
                                    'box_voucher_status' => '2',
                                    'box_delivery_address' => $_order_item[4][1]
                                ];
                                $_c_resp = $this->assign_c_buyer_pbox($token, $body);
                                if(json_decode($_c_resp)->status != '0'){
                                    throw new Exception($_c_resp);
                                }
                            }
                        }
                    endforeach;


                    /** ============== EMAILS =============  */
                    $full_order_email_body = '
                    <table style="width:100%!important;font-size: 12px;text-transform:lowercase;">
                    <tr class="order_summary_tr_td">
                      <td class="b">ORDER NUMBER</td>
                      <td>'.$order_items[1000]['order_id'].'</td>
                      <td colspan="4" class="invisible_table"></td>
                    </tr>
                    <tr class="order_summary_tr_td">
                      <th class="b col_1">IMAGE</th>
                      <th>BOX NAME</th>
                      <th>BOX TYPE</th>
                      <th>RECIPIENT NAME</th>
                      <th>DELIVERY STATUS</th>               
                      <th>COST</th>
                    </tr>';
                    $_total_cart = [];
                    foreach( $order_items  as $_order_item_m ):
                        if(!isset($_order_item_m['order_id'])){
                            /** for each order item send email to buyer - admin -receiver */
                            $_box_data_resp = $box->get_byidf('00', $_order_item_m[0]);
                            if(json_decode($_box_data_resp)->status != '0'){
                                throw new Exception($_box_data_resp);
                            }
                            $_box_data = json_decode($_box_data_resp)->data;

                            $_b_cost = floor($_order_item_m[1]*$_box_data->price);
                            $_total_cart[] = $_b_cost;
                            $_media = $picture->get_byitem('00', $_order_item_m[0]);
                            if(json_decode($_media)->status != '0'){
                                throw new Exception($_media);
                            }
                            $_media = json_decode($_media, true)['data'];
                            $_3d = $util->ClientHome(). '/shared/img/cart_img.png';
                            $_pdf = '';
                            foreach( $_media as $_mm ){
                               if($_mm['type'] == '2'){$_3d = $_mm['path_name'];}else{$_pdf = $_mm['path_name'];}
                            }
                            if($_order_item_m[2] == 2){ /** ebox */
                                $payload = [
                                    'order_id' => $order_id,
                                    'customer_buyer_id' => $cust_buyer,
                                    'box_internal_id' => $_order_item_m[0],
                                    'receiver' => $_order_item_m[4][0],
                                    'type' => '11'
                                ];
                                $evouchers_ = $this->find_order_vouchers($token, $payload);
                                if( json_decode($evouchers_)->status != '0' || count(json_decode($evouchers_, true)['vouchers']) < 1 ){
                                    throw new Exception($evouchers_);
                                }
                                $email_data = [
                                    'image' => $_3d,
                                    'order_id' => $order_id,
                                    'ebook' => $_pdf,
                                    'box' => $_box_data->name,
                                    'type' => 'E-box',
                                    'qty' => $_order_item_m[1],
                                    'price' => $_box_data->price,
                                    'cost' => floor($_order_item_m[1]*$_box_data->price),
                                    'receiver_email' => $_order_item_m[4][0],
                                    'vouchers' => json_decode($evouchers_, true)['vouchers']
                                ];
                                // $util->Show($email_data['vouchers']);
                                $deliver_ebox_resp = $this->deliver_ebox_by_mail($token, $email_data);
                                if( json_decode($deliver_ebox_resp)->status != '0' ){
                                    throw new Exception($deliver_ebox_resp);
                                }
                                $full_order_email_body .= '
                                <tr>
                                    <td class="">
                                    <img style="width:70px!important;" src="'.$_3d.'">
                                    </td>
                                    <td>'.$_box_data->name.'</td>
                                    <td>E-box</td>
                                    <td>'.$_order_item_m[4][1].'</td>
                                    <td>Emailed</td>
                                    <td>KES '.number_format($_b_cost, 2).'</td>
                                </tr>
                                ';
                            }else{ /** pbox */
                                $_address_string = ucwords(strtolower($_order_item_m[4][1])).', '. strtoupper($_order_item_m[4][2]).', '. $_order_item_m[4][3];

                                $full_order_email_body .= '
                                <tr>
                                    <td class="">
                                    <img style="width:70px!important;" src="'.$_3d.'">
                                    </td>
                                    <td>'.$_box_data->name.'</td>
                                    <td>Physical Box</td>
                                    <td>'.$_order_item_m[4][0].'</td>
                                    <td>Pending</td>
                                    <td>KES '.number_format($_b_cost, 2).'</td>
                                </tr>
                                ';
                            }
                        }
                    endforeach;
                    $full_order_email_body .= '
                    <tr class="">
                    <td colspan="1" class=""></td>
                    <td colspan="5" align="right" class="">
                      <table style="font-size:14px;">
                        <tr>
                          <td>SUB TOTAL (Incl. VAT)</td>
                          <td>KES '.number_format(array_sum($_total_cart), 2).'</td>
                        </tr>
                        <tr>
                          <td>SHIPPING</td>
                          <td>KES '.number_format(floor($order_full_data['shipping_cost']),2).'</td>
                        </tr>
                        <tr class="bold_txt">
                          <td>TOTAL PRICE (Incl. VAT)</td>
                          <td>KES '.number_format((array_sum($_total_cart)+floor($order_full_data['shipping_cost'])), 2).'</td>
                        </tr>
                        <tr class="bold_txt">
                          <td>TOTAL PAID</td>
                          <td>KES '.number_format($mpesa['TransAmount'], 2).'</td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  </table>
                    ';
                    $mail_payload = [
                        'mail_body' => $full_order_email_body,
                        'buyer' => $cust_buyer,
                        'order_id' => $order_id
                    ];
                    $full_mail_resp = $this->email_full_order_to_admin_and_buyer($token, $mail_payload);
                    if( json_decode($full_mail_resp)->status != '0' ){
                        throw new Exception($full_mail_resp);
                    }
                    /** ========== END EMAILS ================ */
                }
                else
                {
                    /** payment failed!!!! */
                    throw new Exception(json_encode($mpesa));
                }
            }
        }catch( Exception $e){
            /** write to file */
            // print($e->getMessage());
            file_put_contents("order_c2b_logs.log", PHP_EOL . $e->getMessage() . PHP_EOL, FILE_APPEND | LOCK_EX);
            print  $e->getMessage();
        }
    }
    function process_jp($jpdata){
        global $util;
        // $util->Show($jpdata);
        try{
            date_default_timezone_set('Africa/Nairobi');
            if (isset($jpdata['JP_PASSWORD'])) {
                $JP_TRANID = $jpdata['JP_TRANID'];
                $JP_MERCHANT_ORDERID = $jpdata['JP_MERCHANT_ORDERID'];
                $JP_ITEM_NAME = $jpdata['JP_ITEM_NAME'];
                $JP_AMOUNT = $jpdata['JP_AMOUNT'];
                $JP_CURRENCY = $jpdata['JP_CURRENCY'];
                $JP_TIMESTAMP = $jpdata['JP_TIMESTAMP'];
                $JP_PASSWORD = $jpdata['JP_PASSWORD'];
                $JP_CHANNEL = $jpdata['JP_CHANNEL'];
                $sharedkey = 'A4A3781A-A4B3-4C13-9BDD-50AFA74BAD81';
                $str = $JP_MERCHANT_ORDERID . $JP_AMOUNT . $JP_CURRENCY . $sharedkey . $JP_TIMESTAMP;
                if (md5(utf8_encode($str)) == $JP_PASSWORD) {
                // if (md5(utf8_encode($str))) {
                    echo '<div class="alert alert-success"><strong>Thank you!</strong> Your payment of KES '.$JP_AMOUNT.' was reveived. Check your email for order details.</div>';	
                    $this_order =  $this->get_one_by_order_req_id($JP_MERCHANT_ORDERID);
                    if( json_decode($this_order)->status != '0' || !json_decode($this_order, true)['data'] ){
                        throw new Exception('JP get_one_by_order_req_id()::: Errors or empty response for pay:: '.$JP_MERCHANT_ORDERID . ' =>' . $this_order);
                    }
                    if( json_decode($this_order)->status == '0'){
                        $order_meta = json_decode($this_order, true)['data'];
                        $order_id = $order_meta['order_id'];
                        $token = $order_meta['token'];
                            // $util->Show($jpdata);
                            $req_body = [
                                'order' => $order_id,
                                'amount' => $JP_AMOUNT,
                                'ref' => $JP_TRANID,
                                'status' => 'Success',
                                'date_time' => $JP_TIMESTAMP,
                                'description' => $JP_CHANNEL . ' ' . $JP_CURRENCY,
                                'method' => 'JamboPay ~ '.$JP_CHANNEL,
                                'phone' => '0700000000',
                                'pay_string' => json_encode($jpdata)
                            ];
                            $_pay_resp = $this->add_a_payment($token, $req_body);
                            // print($_pay_resp);
                            if( json_decode($_pay_resp)->status != '0' ){
                                throw new Exception($_pay_resp);
                            }
                            $order_full_data = $this->get_ord_one($token, $order_id);
                            if( json_decode($order_full_data)->status != '0' ){
                                throw new Exception('JP get_ord_one() Order full data error:::: ' .$order_full_data);
                            }
                            if( count(json_decode($order_full_data, true)['data']) < 1 ){
                                throw new Exception('JP Order not found: ' .$order_full_data);
                            }
                            $order_full_data = json_decode($order_full_data, true)['data'];
                            $cust_buyer = $order_full_data['customer_buyer'];
                            $order_items = json_decode($order_full_data['order_string'], true);
                            $e_vouchers = $p_vouchers = [];
                            $box = new Box();
                            $picture = new Picture();
                            $order_physical_address = $order_items[2000]['physical_address'];
                            foreach( $order_items  as $_order_item ):
                                if(isset($_order_item['order_id'])){

                                }elseif(isset($_order_item['physical_address'])){

                                }else{
                                    $_box_data_resp = $box->get_byidf('00', $_order_item[0]);
                                    if(json_decode($_box_data_resp)->status != '0'){
                                        throw new Exception($_box_data_resp);
                                    }
                                    $_box_data = json_decode($_box_data_resp)->data;
                                    $_media = $picture->get_byitem('00', $_order_item[0]);
                                    if(json_decode($_media)->status != '0'){
                                        throw new Exception($_media);
                                    }
                                    $_media = json_decode($_media, true)['data'];
                                    if($_order_item[2] == 2){ /** ebox */
                                        /** generate evouchers and populate inventry */
                                        $_llp = 0;
                                        $ev = [];
                                        while( $_llp < $_order_item[1] ){
                                            array_push($ev, 'E-' . $util->createCode(8));
                                            $_llp ++;
                                        }
                                        /** create the evouchers */
                                        $purchase_date = date('Y-m-d', time());
                                        $box_validity_object = new DateTime("+6 months");
                                        $box_validity_date = $box_validity_object->format("Y-m-d");
                                        $evouchers_this_ = implode(',', $ev);
                                        $body = [
                                            'box_internal_id' => $_order_item[0],
                                            'order_number' => $order_id,
                                            'customer_buyer_id' => $cust_buyer,
                                            'customer_payment_method' => 'JamboPay~'.$JP_CHANNEL,
                                            'box_purchase_date' => $purchase_date,
                                            'box_validity_date' => $box_validity_date,
                                            'customer_buyer_invoice' => $order_id,
                                            'box_vouchers' => $evouchers_this_,
                                            'box_voucher_status' => '2',
                                            'box_delivery_address' => $_order_item[4][0]
                                        ];
                                        $_c_resp = $this->create_c_buyer_ebox($token, $body);
                                        if(json_decode($_c_resp)->status != '0'){
                                            throw new Exception($_c_resp);
                                        }
                                    }else{ /** pbox */
                                        /** there is pbox write to cron logs */
                                        $cron_body = [
                                            'order_id' => $order_id,
                                            'customer_buyer' => $cust_buyer,
                                            'box_voucher' => $_box_data->name,
                                            'order_meta' => $order_full_data['order_string'], 
                                            'deliver_to' => $order_physical_address[1],
                                            'sendy_log' => 'sendy_log',
                                        ];
                                        $cron_resp = $this->new_cron($token, $cron_body);
                                        if(json_decode($cron_resp)->status != '0'){
                                            throw new Exception($cron_resp);
                                        }
                                        /** allocate pvouchers to this order */
                                        $_box_qty = $_order_item[1];
                                        $purchase_date = date('Y-m-d', time());
                                        $box_validity_object = new DateTime("+6 months");
                                        $box_validity_date = $box_validity_object->format("Y-m-d");
                                        $body = [
                                            'box_internal_id' => $_order_item[0],
                                            'order_number' => $order_id,
                                            'customer_buyer_id' => $cust_buyer,
                                            'customer_payment_method' => 'JamboPay~'.$JP_CHANNEL,
                                            'box_purchase_date' => $purchase_date,
                                            'box_validity_date' => $box_validity_date,
                                            'customer_buyer_invoice' => $order_id,
                                            'box_qty' => $_box_qty,
                                            'box_voucher_status' => '2',
                                            'box_delivery_address' => $order_physical_address[1]
                                        ];
                                        $_c_resp = $this->assign_c_buyer_pbox($token, $body);
                                        if(json_decode($_c_resp)->status != '0'){
                                            throw new Exception($_c_resp);
                                        }
                                    }
                                }
                            endforeach;
                            /** ============== EMAILS =============  */
                            $full_order_email_body = '
                            <table style="width:100%!important;font-size: 12px;text-transform:lowercase;">
                            <tr class="order_summary_tr_td">
                            <td class="b">ORDER NUMBER</td>
                            <td>'.$order_items[1000]['order_id'].'</td>
                            <td colspan="4" class="invisible_table"></td>
                            </tr>
                            <tr class="order_summary_tr_td">
                            <th class="b col_1">IMAGE</th>
                            <th>BOX NAME</th>
                            <th>BOX TYPE</th>
                            <th>RECIPIENT NAME</th>
                            <th>DELIVERY STATUS</th>               
                            <th>COST</th>
                            </tr>';
                            $_total_cart = [];
                            foreach( $order_items  as $_order_item_m ):
                                if(isset($_order_item_m['order_id'])){

                                }elseif(isset($_order_item_m['physical_address'])){

                                }else{
                                    /** for each order item send email to buyer - admin -receiver */
                                    $_box_data_resp = $box->get_byidf('00', $_order_item_m[0]);
                                    if(json_decode($_box_data_resp)->status != '0'){
                                        throw new Exception($_box_data_resp);
                                    }
                                    $_box_data = json_decode($_box_data_resp)->data;

                                    $_b_cost = floor($_order_item_m[1]*$_box_data->price);
                                    $_total_cart[] = $_b_cost;
                                    $_media = $picture->get_byitem('00', $_order_item_m[0]);
                                    if(json_decode($_media)->status != '0'){
                                        throw new Exception($_media);
                                    }
                                    $_media = json_decode($_media, true)['data'];
                                    $_3d = $util->ClientHome(). '/shared/img/cart_img.png';
                                    $_pdf = '';
                                    foreach( $_media as $_mm ){
                                    if($_mm['type'] == '2'){$_3d = $_mm['path_name'];}else{$_pdf = $_mm['path_name'];}
                                    }
                                    if($_order_item_m[2] == 2){ /** ebox */
                                        $payload = [
                                            'order_id' => $order_id,
                                            'customer_buyer_id' => $cust_buyer,
                                            'box_internal_id' => $_order_item_m[0],
                                            'receiver' => $_order_item_m[4][0],
                                            'type' => '11'
                                        ];
                                        $evouchers_ = $this->find_order_vouchers($token, $payload);
                                        if( json_decode($evouchers_)->status != '0' || count(json_decode($evouchers_, true)['vouchers']) < 1 ){
                                            throw new Exception($evouchers_);
                                        }
                                        $email_data = [
                                            'image' => $_3d,
                                            'order_id' => $order_id,
                                            'ebook' => $_pdf,
                                            'box' => $_box_data->name,
                                            'type' => 'E-box',
                                            'qty' => $_order_item_m[1],
                                            'price' => $_box_data->price,
                                            'cost' => floor($_order_item_m[1]*$_box_data->price),
                                            'receiver_email' => $_order_item_m[4][0],
                                            'vouchers' => json_decode($evouchers_, true)['vouchers']
                                        ];
                                        // $util->Show($email_data['vouchers']);
                                        $deliver_ebox_resp = $this->deliver_ebox_by_mail($token, $email_data);
                                        if( json_decode($deliver_ebox_resp)->status != '0' ){
                                            throw new Exception($deliver_ebox_resp);
                                        }
                                        $full_order_email_body .= '
                                        <tr>
                                            <td class="">
                                            <img style="width:70px!important;" src="'.$_3d.'">
                                            </td>
                                            <td>'.$_box_data->name.'</td>
                                            <td>E-box</td>
                                            <td>'.$_order_item_m[4][1].'</td>
                                            <td>Emailed</td>
                                            <td>KES '.number_format($_b_cost, 2).'</td>
                                        </tr>
                                        ';
                                    }else{ /** pbox */
                                        $_address_string = $order_physical_address[1];
                                        /** write to cron  */
                                        $full_order_email_body .= '
                                        <tr>
                                            <td class="">
                                            <img style="width:70px!important;" src="'.$_3d.'">
                                            </td>
                                            <td>'.$_box_data->name.'</td>
                                            <td>Physical Box</td>
                                            <td>'.$_address_string.'</td>
                                            <td>Pending</td>
                                            <td>KES '.number_format($_b_cost, 2).'</td>
                                        </tr>
                                        ';
                                    }
                                }
                            endforeach;
                            $full_order_email_body .= '
                            <tr class="">
                            <td colspan="1" class=""></td>
                            <td colspan="5" align="right" class="">
                            <table style="font-size:14px;">
                                <tr>
                                <td>SUB TOTAL (Incl. VAT)</td>
                                <td>KES '.number_format(array_sum($_total_cart), 2).'</td>
                                </tr>
                                <tr>
                                <td>SHIPPING</td>
                                <td>KES '.number_format(floor($order_full_data['shipping_cost']),2).'</td>
                                </tr>
                                <tr class="bold_txt">
                                <td>TOTAL PRICE (Incl. VAT)</td>
                                <td>KES '.number_format((array_sum($_total_cart)+floor($order_full_data['shipping_cost'])), 2).'</td>
                                </tr>
                                <tr class="bold_txt">
                                <td>TOTAL PAID</td>
                                <td>KES '.number_format($JP_AMOUNT, 2).'</td>
                                </tr>
                            </table>
                            </td>
                        </tr>
                        </table>';
                        $mail_payload = [
                            'mail_body' => $full_order_email_body,
                            'buyer' => $cust_buyer,
                            'order_id' => $order_id
                        ];
                        $full_mail_resp = $this->email_full_order_to_admin_and_buyer($token, $mail_payload);
                        if( json_decode($full_mail_resp)->status != '0' ){
                            throw new Exception($full_mail_resp);
                        }
                        /** ========== END EMAILS ================ */
                    }
                }else{
                    //INVALID TRANSACTION
                    echo '<div class="alert alert-danger"><strong>Failed!</strong> The transaction failed, please try again.</div>';	
                    exit();
                }
            }
        }catch( Exception $e){
            /** write to file */
            // print($e->getMessage());
            file_put_contents("order_logs.log", date('Y-m-d H:i:s a') . PHP_EOL . $e->getMessage() . PHP_EOL, FILE_APPEND | LOCK_EX);
            echo '<div class="alert alert-danger"><strong>Error!</strong> Order payment timed out.</div>';
            // print  $e->getMessage();
        }
    }
    function process_mpesa_express($mpesa){
        global $util;
        // $util->Show($mpesa);
        try{
            date_default_timezone_set('Africa/Nairobi');
            $stkCallback = $mpesa['Body']['stkCallback'];
            $CheckoutRequestID = $stkCallback['CheckoutRequestID'];
            
            $this_order = $this->get_one_by_checkout_req_id($CheckoutRequestID);
            if( json_decode($this_order)->status != '0' || !json_decode($this_order, true)['data'] ){
                throw new Exception('get_one_by_checkout_req_id()::: Errors or empty response for pay:: '.$CheckoutRequestID . ' =>' . $this_order);
            }
            
            if( json_decode($this_order)->status == '0'){
                $order_meta = json_decode($this_order, true)['data'];
                $order_id = $order_meta['order_id'];
                $token = $order_meta['token'];
                if( $stkCallback['ResultCode'] == '0' ) /** success */
                {
                    $stk_meta_data = $stkCallback['CallbackMetadata']['Item'];
                    // $util->Show($stk_meta_data);
                    $req_body = [
                        'order' => $order_id,
                        'amount' => $stk_meta_data[0]['Value'],
                        'ref' => $stk_meta_data[1]['Value'],
                        'status' => $stkCallback['ResultCode'],
                        'date_time' => $stk_meta_data[3]['Value'],
                        'description' => $stkCallback['ResultDesc'],
                        'method' => 'MPESA STK',
                        'phone' => $stk_meta_data[4]['Value'],
                        'pay_string' => json_encode($mpesa)
                    ];
                    $_pay_resp = $this->add_a_payment($token, $req_body);
                    if( json_decode($_pay_resp)->status != '0' ){
                        throw new Exception($_pay_resp);
                    }
                    $order_full_data = $this->get_ord_one($token, $order_id);
                    if( json_decode($order_full_data)->status != '0' ){
                        throw new Exception('get_ord_one() Order full data error:::: ' .$order_full_data);
                    }
                    if( count(json_decode($order_full_data, true)['data']) < 1 ){
                        throw new Exception('Order not found: ' .$order_full_data);
                    }
                    $order_full_data = json_decode($order_full_data, true)['data'];
                    $cust_buyer = $order_full_data['customer_buyer'];
                    $order_items = json_decode($order_full_data['order_string'], true);
                    $e_vouchers = $p_vouchers = [];
                    $box = new Box();
                    $picture = new Picture();
                    $order_physical_address = $order_items[2000]['physical_address'];
                    foreach( $order_items  as $_order_item ):
                        if(isset($_order_item['order_id'])){

                        }elseif(isset($_order_item['physical_address'])){

                        }else{
                            $_box_data_resp = $box->get_byidf('00', $_order_item[0]);
                            if(json_decode($_box_data_resp)->status != '0'){
                                throw new Exception($_box_data_resp);
                            }
                            $_box_data = json_decode($_box_data_resp)->data;
                            $_media = $picture->get_byitem('00', $_order_item[0]);
                            if(json_decode($_media)->status != '0'){
                                throw new Exception($_media);
                            }
                            $_media = json_decode($_media, true)['data'];
                            if($_order_item[2] == 2){ /** ebox */
                                /** generate evouchers and populate inventry */
                                $_llp = 0;
                                $ev = [];
                                while( $_llp < $_order_item[1] ){
                                    array_push($ev, 'E-' . $util->createCode(8));
                                    $_llp ++;
                                }
                                /** create the evouchers */
                                $purchase_date = date('Y-m-d', time());
                                $box_validity_object = new DateTime("+6 months");
                                $box_validity_date = $box_validity_object->format("Y-m-d");
                                $evouchers_this_ = implode(',', $ev);
                                $body = [
                                    'box_internal_id' => $_order_item[0],
                                    'order_number' => $order_id,
                                    'customer_buyer_id' => $cust_buyer,
                                    'customer_payment_method' => $stk_meta_data[1]['Value'] . '~Mpesa Express',
                                    'box_purchase_date' => $purchase_date,
                                    'box_validity_date' => $box_validity_date,
                                    'customer_buyer_invoice' => $order_id,
                                    'box_vouchers' => $evouchers_this_,
                                    'box_voucher_status' => '2',
                                    'box_delivery_address' => $_order_item[4][0]
                                ];
                                $_c_resp = $this->create_c_buyer_ebox($token, $body);
                                if(json_decode($_c_resp)->status != '0'){
                                    throw new Exception($_c_resp);
                                }
                            }else{ /** pbox */
                                /** there is pbox write to cron logs */
                                $mcron_body = [
                                    'order_id' => $order_id,
                                    'customer_buyer' => $cust_buyer,
                                    'box_voucher' => $_box_data->name,
                                    'order_meta' => $order_full_data['order_string'], 
                                    'deliver_to' => $order_physical_address[1],
                                    'sendy_log' => 'sendy_log',
                                ];
                                $cron_resp = $this->new_cron($token, $mcron_body);
                                if(json_decode($cron_resp)->status != '0'){
                                    throw new Exception($cron_resp);
                                }
                                /** allocate pvouchers to this order */
                                $_box_qty = $_order_item[1];
                                $purchase_date = date('Y-m-d', time());
                                $box_validity_object = new DateTime("+6 months");
                                $box_validity_date = $box_validity_object->format("Y-m-d");
                                $body = [
                                    'box_internal_id' => $_order_item[0],
                                    'order_number' => $order_id,
                                    'customer_buyer_id' => $cust_buyer,
                                    'customer_payment_method' => $stk_meta_data[1]['Value'] . '~Mpesa Express',
                                    'box_purchase_date' => $purchase_date,
                                    'box_validity_date' => $box_validity_date,
                                    'customer_buyer_invoice' => $order_id,
                                    'box_qty' => $_box_qty,
                                    'box_voucher_status' => '2',
                                    'box_delivery_address' => $order_physical_address[1]
                                ];
                                $_c_resp = $this->assign_c_buyer_pbox($token, $body);
                                if(json_decode($_c_resp)->status != '0'){
                                    throw new Exception($_c_resp);
                                }
                            }
                        }
                    endforeach;
                    /** ============== EMAILS =============  */
                    $full_order_email_body = '
                    <table style="width:100%!important;font-size: 12px;text-transform:lowercase;">
                    <tr class="order_summary_tr_td">
                      <td class="b">ORDER NUMBER</td>
                      <td>'.$order_items[1000]['order_id'].'</td>
                      <td colspan="4" class="invisible_table"></td>
                    </tr>
                    <tr class="order_summary_tr_td">
                      <th class="b col_1">IMAGE</th>
                      <th>BOX NAME</th>
                      <th>BOX TYPE</th>
                      <th>RECIPIENT NAME</th>
                      <th>DELIVERY STATUS</th>               
                      <th>COST</th>
                    </tr>';
                    $_total_cart = [];
                    foreach( $order_items  as $_order_item_m ):
                        if(isset($_order_item_m['order_id'])){

                        }elseif(isset($_order_item_m['physical_address'])){

                        }else{
                            /** for each order item send email to buyer - admin -receiver */
                            $_box_data_resp = $box->get_byidf('00', $_order_item_m[0]);
                            if(json_decode($_box_data_resp)->status != '0'){
                                throw new Exception($_box_data_resp);
                            }
                            $_box_data = json_decode($_box_data_resp)->data;

                            $_b_cost = floor($_order_item_m[1]*$_box_data->price);
                            $_total_cart[] = $_b_cost;
                            $_media = $picture->get_byitem('00', $_order_item_m[0]);
                            if(json_decode($_media)->status != '0'){
                                throw new Exception($_media);
                            }
                            $_media = json_decode($_media, true)['data'];
                            $_3d = $util->ClientHome(). '/shared/img/cart_img.png';
                            $_pdf = '';
                            foreach( $_media as $_mm ){
                               if($_mm['type'] == '2'){$_3d = $_mm['path_name'];}else{$_pdf = $_mm['path_name'];}
                            }
                            if($_order_item_m[2] == 2){ /** ebox */
                                $payload = [
                                    'order_id' => $order_id,
                                    'customer_buyer_id' => $cust_buyer,
                                    'box_internal_id' => $_order_item_m[0],
                                    'receiver' => $_order_item_m[4][0],
                                    'type' => '11'
                                ];
                                $evouchers_ = $this->find_order_vouchers($token, $payload);
                                if( json_decode($evouchers_)->status != '0' || count(json_decode($evouchers_, true)['vouchers']) < 1 ){
                                    throw new Exception($evouchers_);
                                }
                                $email_data = [
                                    'image' => $_3d,
                                    'order_id' => $order_id,
                                    'ebook' => $_pdf,
                                    'box' => $_box_data->name,
                                    'type' => 'E-box',
                                    'qty' => $_order_item_m[1],
                                    'price' => $_box_data->price,
                                    'cost' => floor($_order_item_m[1]*$_box_data->price),
                                    'receiver_email' => $_order_item_m[4][0],
                                    'vouchers' => json_decode($evouchers_, true)['vouchers']
                                ];
                                // $util->Show($email_data['vouchers']);
                                $deliver_ebox_resp = $this->deliver_ebox_by_mail($token, $email_data);
                                if( json_decode($deliver_ebox_resp)->status != '0' ){
                                    throw new Exception($deliver_ebox_resp);
                                }
                                $full_order_email_body .= '
                                <tr>
                                    <td class="">
                                    <img style="width:70px!important;" src="'.$_3d.'">
                                    </td>
                                    <td>'.$_box_data->name.'</td>
                                    <td>E-box</td>
                                    <td>'.$_order_item_m[4][1].'</td>
                                    <td>Emailed</td>
                                    <td>KES '.number_format($_b_cost, 2).'</td>
                                </tr>
                                ';
                            }else{ /** pbox */
                                $_address_string = $order_physical_address[1];
                                /** write to cron  */
                                $full_order_email_body .= '
                                <tr>
                                    <td class="">
                                    <img style="width:70px!important;" src="'.$_3d.'">
                                    </td>
                                    <td>'.$_box_data->name.'</td>
                                    <td>Physical Box</td>
                                    <td>'.$_address_string.'</td>
                                    <td>Pending</td>
                                    <td>KES '.number_format($_b_cost, 2).'</td>
                                </tr>
                                ';
                            }
                        }
                    endforeach;
                    $full_order_email_body .= '
                    <tr class="">
                    <td colspan="1" class=""></td>
                    <td colspan="5" align="right" class="">
                      <table style="font-size:14px;">
                        <tr>
                          <td>SUB TOTAL (Incl. VAT)</td>
                          <td>KES '.number_format(array_sum($_total_cart), 2).'</td>
                        </tr>
                        <tr>
                          <td>SHIPPING</td>
                          <td>KES '.number_format(floor($order_full_data['shipping_cost']),2).'</td>
                        </tr>
                        <tr class="bold_txt">
                          <td>TOTAL PRICE (Incl. VAT)</td>
                          <td>KES '.number_format((array_sum($_total_cart)+floor($order_full_data['shipping_cost'])), 2).'</td>
                        </tr>
                        <tr class="bold_txt">
                          <td>TOTAL PAID</td>
                          <td>KES '.number_format($stk_meta_data[0]['Value'], 2).'</td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  </table>
                    ';
                    $mail_payload = [
                        'mail_body' => $full_order_email_body,
                        'buyer' => $cust_buyer,
                        'order_id' => $order_id
                    ];
                    $full_mail_resp = $this->email_full_order_to_admin_and_buyer($token, $mail_payload);
                    if( json_decode($full_mail_resp)->status != '0' ){
                        throw new Exception($full_mail_resp);
                    }
                    /** ========== END EMAILS ================ */
                }
                else
                {
                    /** payment failed!!!! */
                    throw new Exception(json_encode($mpesa));
                }
            }
        }catch( Exception $e){
            /** write to file */
            // print($e->getMessage());
            file_put_contents("order_logs.log", PHP_EOL . $e->getMessage() . PHP_EOL, FILE_APPEND | LOCK_EX);
            print  $e->getMessage();
        }
    }
    function email_full_order_to_admin_and_buyer($token, $body){
        $endpoint = 'services/orders/order/mail/fullorder';
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
    function new_cron($token, $cron_body){
        $endpoint = 'services/orders/new/cron';
        $util = new Util();
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $util->AppAPI() . $endpoint);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers($token));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($cron_body));
        curl_setopt($curl, CURLOPT_HEADER, false);
        $res = curl_exec($curl);
        return $res;
    }
    function run_cron($token = null){
        $endpoint = 'services/orders/find/crons/date';
        $util = new Util();
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $util->AppAPI() . $endpoint);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers($token));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode([]));
        curl_setopt($curl, CURLOPT_HEADER, false);
        $res = curl_exec($curl);
        return $res;
    }
    function update_ship_request($body, $token = null){
        $endpoint = 'services/orders/find/crons/update';
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
    function deliver_ebox_by_mail($token, $body){
        $endpoint = 'services/orders/order/mail/evouchers';
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
    function find_order_vouchers($token, $body){
        $endpoint = 'services/orders/order/find/vouchers';
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
    function create_c_buyer_ebox($token, $body){
        $endpoint = 'services/orders/order/create/order/evouchers';
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
    function assign_c_buyer_pbox($token, $body){
        $endpoint = 'services/orders/order/assign/order/pvouchers';
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
    function add_a_payment($token, $body){
        $endpoint = 'services/orders/order/add/a/pay';
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
    function create($body){
        $endpoint = 'services/orders/order';
        $util = new Util();
        $this->validate();
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $util->AppAPI() . $endpoint);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers($this->token));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
        curl_setopt($curl, CURLOPT_HEADER, false);
        $res = curl_exec($curl);
        return $res;
    }
    function exists($order){
        $endpoint = 'services/orders/order/ex/' . $order;
        $util = new Util();
        $this->validate();
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $util->AppAPI() . $endpoint);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers($this->token));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
        curl_setopt($curl, CURLOPT_HEADER, false);
        $res = curl_exec($curl);
        return $res;
    }
    function mark_pay_success($body, $order){
        $endpoint = 'services/orders/order/pay/true/' . $order;
        $util = new Util();
        $this->validate();
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $util->AppAPI() . $endpoint);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers($this->token));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
        curl_setopt($curl, CURLOPT_HEADER, false);
        $res = curl_exec($curl);
        return $res;
    }
    function update_checkout_req_id($req_id, $order){
        $endpoint = 'services/orders/order/checkout/reqid/' . $order;
        $util = new Util();
        $this->validate();
        $body = [
            'checkout_request_id' => $req_id
        ];
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $util->AppAPI() . $endpoint);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers($this->token));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
        curl_setopt($curl, CURLOPT_HEADER, false);
        $res = curl_exec($curl);
        return $res;
    }
    function mark_pay_fail($body, $order){
        $endpoint = 'services/orders/order/pay/false/' . $order;
        $util = new Util();
        $this->validate();
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $util->AppAPI() . $endpoint);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers($this->token));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
        curl_setopt($curl, CURLOPT_HEADER, false);
        $res = curl_exec($curl);
        return $res;
    }
    function update_shipment($body, $order){
        $endpoint = 'services/orders/order/shipment/' . $order;
        $util = new Util();
        $this->validate();
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $util->AppAPI() . $endpoint);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers($this->token));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
        curl_setopt($curl, CURLOPT_HEADER, false);
        $res = curl_exec($curl);
        return $res;
    }
    function get(){
        $endpoint = 'services/orders/orders';
        $util = new Util();
        $body = [];
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $util->AppAPI() . $endpoint);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers($this->token));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
        curl_setopt($curl, CURLOPT_HEADER, false);
        $res = curl_exec($curl);
        return $res;
    }
    function get_one_by_checkout_req_id($id){
        $endpoint = 'services/orders/order/req/id/' . $id;
        $util = new Util();
        $body = [];
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $util->AppAPI() . $endpoint);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers($this->token));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
        curl_setopt($curl, CURLOPT_HEADER, false);
        $res = curl_exec($curl);
        return $res;
    }
    function get_one_by_order_req_id($id){
        $endpoint = 'services/orders/order/ord/id/' . $id;
        $util = new Util();
        $body = [];
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $util->AppAPI() . $endpoint);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers($this->token));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
        curl_setopt($curl, CURLOPT_HEADER, false);
        $res = curl_exec($curl);
        return $res;
    }
    function get_ord_one($token, $order_id){
        $endpoint = 'services/orders/order/order/' . $order_id;
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
    function get_one($id){
        $endpoint = 'services/orders/order/' . $id;
        $util = new Util();
        $body = [];
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $util->AppAPI() . $endpoint);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers($this->token));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
        curl_setopt($curl, CURLOPT_HEADER, false);
        $res = curl_exec($curl);
        return $res;
    }
    function get_one_byorder_limited($orderid){
        $endpoint = 'services/orders/order/order/lmt/' . $orderid;
        $util = new Util();
        $body = [];
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $util->AppAPI() . $endpoint);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers($this->token));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
        curl_setopt($curl, CURLOPT_HEADER, false);
        $res = curl_exec($curl);
        return $res;
    }
    function get_one_byorder($orderid){
        $endpoint = 'services/orders/order/order/' . $orderid;
        $util = new Util();
        $body = [];
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $util->AppAPI() . $endpoint);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers($this->token));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
        curl_setopt($curl, CURLOPT_HEADER, false);
        $res = curl_exec($curl);
        return $res;
    }
    function get_bycustomer($customerid){
        $endpoint = 'services/orders/order/customer/' . $customerid;
        $util = new Util();
        $body = [];
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $util->AppAPI() . $endpoint);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers($this->token));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
        curl_setopt($curl, CURLOPT_HEADER, false);
        $res = curl_exec($curl);
        return $res;
    }
    function headers($token = ''){
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: Bearer ' . $token;
        return $headers;
    }
    function validate(){
        return;
    }
 }
 
?>
