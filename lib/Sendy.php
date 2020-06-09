<?php 
/** 
 * @author - j.o
 * @license propriatery
 * @file - Sendy.php
 * @usage - Sendy objects
 */

 class Sendy
 {
    private $key;
    function __construct($key){
        $this->key = $key;
    }
    function get_lat_long($location){
        $util = new Util();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $util->MapsUrl() . 'address='.urlencode($location).'&key='.$this->key);
        $content = curl_exec($ch);
        $resp = json_decode($content, true);
        // print_r($resp);
        $return = !empty($resp['results'][0]['geometry']['location'])?$resp['results'][0]['geometry']['location']:[];
        if(count($return) < 1){
            throw new Exception('System could not understand your Address. Try changing address to a known location and reload this page');
        }
        return $return;
    }
    function item_size($qty = 1){
        return [
          'weight' => 0.1*$qty,
          'height' => 5*$qty,
          'width' => 2*$qty,
          'length' => 5*$qty
        ];
    }
    function post_fields($order_data, $_order_id, $box_obj, $request_type_){
        $util = new Util();
        $post_fields = [];
        /** sendy postfields */
        $post_fields['command'] = 'request';
        $post_fields['request_token_id'] = $_order_id;
        $post_fields['data']['api_key'] = $util->SendyKey();
        $post_fields['data']['api_username'] = $util->SendyUser();
        $post_fields['data']['vendor_type'] = 1;
        $post_fields['data']['rider_phone'] = 0;
        /** from */
        $lat_long = $this->get_lat_long($util->warehouse());
        $post_fields['data']['from']['from_name'] = $util->warehouse();
        $post_fields['data']['from']['from_lat'] = $lat_long['lat'];
        $post_fields['data']['from']['from_long'] = $lat_long['lng'];;
        $post_fields['data']['from']['from_description'] = $util->warehouse().':- warehouse/pickup location';
        /** to */
        $_box_data = json_decode($box_obj->get_byidf('00', $order_data[0]))->data;
        $deliver_to = ucwords(strtolower($order_data[4][1]));
        $lat_long = $this->get_lat_long($deliver_to);
        $post_fields['data']['to']['to_name'] = $deliver_to;
        $post_fields['data']['to']['to_lat'] = $lat_long['lat'];
        $post_fields['data']['to']['to_long'] = $lat_long['lng'];;
        $post_fields['data']['to']['to_description'] = $deliver_to.':- client location, Recipient Name = ' . $order_data[4][0];
        /** delivery data */
        $p_d = $this->item_size($order_data[1]);
        $box_name = $_box_data->name;
        $post_fields['data']['delivery_details']['package_size']['weight'] = $p_d['weight'];
        $post_fields['data']['delivery_details']['package_size']['height'] = $p_d['height'];
        $post_fields['data']['delivery_details']['package_size']['width'] = $p_d['width'];
        $post_fields['data']['delivery_details']['package_size']['length'] = $p_d['length'];
        $post_fields['data']['delivery_details']['package_size']['item_name'] = $box_name;
        /** sender */
        $sender_info = $util->contact_data();
        $post_fields['data']['sender']['sender_name'] = $sender_info[0];
        $post_fields['data']['sender']['sender_phone'] = $sender_info[1];
        $post_fields['data']['sender']['sender_email'] = $sender_info[2];
        $post_fields['data']['sender']['sender_notes'] = 'call us for any queries';
         /** recipient */
         $post_fields['data']['recepient']['recepient_name'] = $order_data[4][0];
         $post_fields['data']['recepient']['recepient_phone'] = $order_data[4][6];
         $post_fields['data']['recepient']['recepient_email'] = 'delivery@happybox.ke';
         $post_fields['data']['recepient']['recepient_notes'] = 'receipient of items';
        /** delivery details */
        $sender_info = $util->contact_data();
        $post_fields['data']['delivery_details']['pick_up_date'] = date('Y-m-d h:i:s');
        //collect payment
        $post_fields['data']['delivery_details']['collect_payment']['status'] = false;
        $post_fields['data']['delivery_details']['collect_payment']['pay_method'] = 0;
        $post_fields['data']['delivery_details']['collect_payment']['amount'] = 0;
        //end payment
        $post_fields['data']['delivery_details']['note'] = 'n/a';
        $post_fields['data']['delivery_details']['note_status'] = false;
        $post_fields['data']['delivery_details']['request_type'] = $request_type_; //quote,delivery
        $post_fields['data']['delivery_details']['order_type'] = 'ondemand_delivery';
        $post_fields['data']['delivery_details']['ecommerce_order'] = false;
        $post_fields['data']['delivery_details']['express'] = false;
        $post_fields['data']['delivery_details']['skew'] = 1;
        // return $post_fields;
        return $this->request_shipping($post_fields);
    }
    function request_shipping($post_fields){
        $util = new Util();
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL,  $util->SendyUrl() . '##request');
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($post_fields));
        curl_setopt($curl, CURLOPT_HEADER, false);
        $res = curl_exec($curl);
        return $res;
    }

 }
 
?>