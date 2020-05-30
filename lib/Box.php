<?php 
/** 
 * @author - j.o
 * @license propriatery
 * @file - Box.php
 * @usage - Box objects
 */

 class Box
 {
    private $name;
    private $price;
    private $description;
    private $topics;
    function __construct($name=null,$price=null,$description=null,$topics=null){
        $this->name = $name;
        $this->price = $price;
        $this->description = $description;
        $this->topics = $topics;
    }
    function create($token){
        $endpoint = 'services/happyboxes/happybox';
        $util = new Util();
        $this->validate();
        $body = [
            'name' => $this->name,
            'price' => $this->price,
            'description' => $this->description,
            'topics' => $this->topics
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
    function update($token, $id){
        $endpoint = 'services/happyboxes/happybox/' . $id;
        $util = new Util();
        $this->validate();
        $body = [
            'name' => $this->name,
            'price' => $this->price,
            'description' => $this->description,
            'topics' => $this->topics
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
    function get($token){
        $endpoint = 'services/happyboxes/happyboxes';
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
        $endpoint = 'services/happyboxes/happybox/' . $id;
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
    function get_byidf($token, $idf){
        $endpoint = 'services/happyboxes/happybox/byidf/' . $idf;
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
        if( empty($this->name) ){
            throw new Exception('Box name field is empty');
        }
        if( empty($this->description) ){
            throw new Exception('Box description field is empty');
        }
        if( empty($this->price) || $this->price < 10 ){
            throw new Exception('Box price field is empty');
        }
        if( empty($this->topics) ){
            throw new Exception('Box topics field is empty');
        }
        return true;
    }
 }
 
?>