<?php 
/** 
 * @author - j.o
 * @license propriatery
 * @file - Inventory.php
 * @usage - Inventory objects
 */

 class Inventory
 {
    private $box;
    private $box_type;
    function __construct($box=null,$box_type=null){
        $this->box = $box;
        $this->box_type = $box_type;
    }
    function create($token){
        $endpoint = 'services/inventories/inventory';
        $util = new Util();
        $this->validate();
        $body = [
            'box_internal_id' => $this->box,
            'box_type' => $this->box_type
        ];
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
    function get($token){
        $endpoint = 'services/inventories/inventory';
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
    function get_one($token, $id){
        $endpoint = 'services/inventories/inventory/' . $id;
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
    function get_by_vstatus($token, $status){
        $endpoint = 'services/inventories/inventory/vstatus/' . $status;
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
    function validate(){
        if( empty($this->box) ){
            throw new Exception('Box field is empty');
        }
        return true;
    }
 }
 
?>