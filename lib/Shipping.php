<?php 
/** 
 * @author - j.o
 * @license propriatery
 * @file - Shipping.php
 * @usage - Shipping objects
 */

 class Shipping
 {
    private $customer_id;
    private $address;
    private $city;
    private $province;
    private $postal_code;
    function __construct($customer_id=null,$address=null,$city=null,$province=null,$postal_code=null){
        $this->customer_id = $customer_id;
        $this->address = $address;
        $this->city = $city;
        $this->province = $province;
        $this->postal_code = $postal_code;
    }
    function create($token){
        $endpoint = 'users/shipping/user/' . $this->customer_id;
        $util = new Util();
        $this->validate();
        $body = [
            'customer_id' => $this->customer_id,
            'address' => $this->address,
            'city' => $this->city,
            'province' => $this->province,
            'postal_code' => $this->postal_code
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
    function update($token){
        $endpoint = 'users/shipping/user/' . $this->customer_id;
        $util = new Util();
        $this->validate();
        $body = [
            'customer_id' => $this->customer_id,
            'address' => $this->address,
            'city' => $this->city,
            'province' => $this->province,
            'postal_code' => $this->postal_code
        ];
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
    function get_one($token, $id){
        $endpoint = 'users/shipping/user/' . $id;
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
        if( empty($this->customer_id) ){
            throw new Exception('user field is empty');
        }
        if( empty($this->address) ){
            throw new Exception('address field is empty');
        }
        if( empty($this->city) ){
            throw new Exception('city field is empty');
        }
        if( empty($this->province) ){
            throw new Exception('province field is empty');
        }
        if( empty($this->postal_code) ){
            throw new Exception('postal code field is empty');
        }
        return true;
    }
 }
 
?>