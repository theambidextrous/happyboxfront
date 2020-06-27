<?php 
/** 
 * @author - j.o
 * @license propriatery
 * @file - Order.php
 * @usage - Order objects
 */

 class Order
 {
    private $token;
    function __construct($token){
        $this->token = $token;
    }
    function process_mpesa_express($mpesa){
        $stkCallback = $mpesa['Body']['stkCallback'];
        $CheckoutRequestID = $stkCallback['CheckoutRequestID'];
        $this_order = $this->get_one_by_checkout_req_id($CheckoutRequestID);
        if( json_decode($this_order)->status == '0'){
            $order_meta = json_decode($this_order, true)['data'];
            $order_id = $order_meta['order_id'];
            $token = $order_meta['token'];
            if( $stkCallback['ResultCode'] == '0' ) /** success */
            {
                $stk_meta_data = $stkCallback['CallbackMetadata']['Item'];
                $req_body = [
                    'order' => $order_id,
                    'amount' => $stk_meta_data[0]['value'],
                    'ref' => $stk_meta_data[1]['value'],
                    'status' => $stkCallback['ResultCode'],
                    'date_time' => $stk_meta_data[3]['value'],
                    'description' => $stkCallback['ResultDesc'],
                    'method' => 'MPESA STK',
                    'phone' => $stk_meta_data[4]['value']
                ];
                $this->add_a_payment($token, $body);
                $order_full_data = json_decode($this->get_ord_one($token, $order_id), true)['data'];
                $cust_buyer = $order_full_data['customer_buyer'];
                $order_items = json_decode($order_full_data['order_string'], true);
                $e_vouchers = $p_vouchers = [];
                $box = new Box();
                $picture = new Picture();
                foreach( $order_items  as $_order_item ):
                    if(!isset($_order_item['order_id'])){
                        $_box_data = json_decode($box->get_byidf('00', $_order_item[0]))->data;
                        $_media = $picture->get_byitem('00', $_order_item[0]);
                        $_media = json_decode($_media, true)['data'];
                        $_3d = $util->ClientHome(). '/shared/img/cart_img.png';
                        $_pdf = '';
                        foreach( $_media as $_mm ){
                            if($_mm['type'] == '2'){$_3d = $_mm['path_name'];}else{$_pdf = $_mm['path_name'];}
                        }
                        if($_order_item[2] == 2){ /** ebox */
                            /** generate evouchers and populate inventry */
                            $_llp = 0;
                            while( $_llp < $_order_item[1] ){
                                $ev[] = 'E-' . $util->createCode(8);
                                $_llp ++;
                            }
                            array_push($e_vouchers, $ev);
                        }else{ /** pbox */
                            /** allocate pvouchers to this order */
                        }
                    }
                endforeach;
            }
            else
            {

            }
        }
        
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
    function get_ord_one($token, $id){
        $endpoint = 'services/orders/order/' . $id;
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