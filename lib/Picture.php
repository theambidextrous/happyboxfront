<?php 
/** 
 * @author - j.o
 * @license propriatery
 * @file - Picture.php
 * @usage - Picture objects
 */

 class Picture
 {
    private $related_item;
    private $path_name;
    private $type;
    function __construct($related_item=null, $path_name=null,$type=null){
        $this->related_item = $related_item;
        $this->path_name = $path_name;
        $this->type = $type;
    }
    function create($token){
        $endpoint = 'services/pictures/picture/' . $this->related_item . '/type/' . $this->type;
        $util = new Util();
        $this->validate();
        $tmpfile = $_FILES[$this->path_name]['tmp_name'];
        $filename = basename($_FILES[$this->path_name]['name']);
        $mime_type = image_type_to_mime_type(exif_imagetype($tmpfile));
        $cfile = new CURLFile($tmpfile, $mime_type, $filename);
        $body = [
            'path_name' => $cfile
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
    function update($token, $data){
        $m_id = $data[0];
        $endpoint = 'services/pictures/picture/' . $m_id;
        $util = new Util();
        $tmpfile = $_FILES[$data[1]]['tmp_name'];
        $filename = basename($_FILES[$data[1]]['name']);
        $mime_type = image_type_to_mime_type(exif_imagetype($tmpfile));
        $cfile = new CURLFile($tmpfile, $mime_type, $filename);
        $body = [
            'path_name' => $cfile
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
    function get($token){
        $endpoint = 'services/pictures/pictures';
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
        $endpoint = 'services/pictures/picture/' . $id;
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
    function get_byitem($token, $idf){
        $endpoint = 'services/pictures/picture/byitem/' . $idf;
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
    function get_byitem_one($token, $idf){
        $endpoint = 'services/pictures/picture/byitem/single/' . $idf;
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
    function get_byitem_one_type($token, $idf, $type){
        $endpoint = 'services/pictures/picture/byitem/one/'.$idf.'/type/' . $type;
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
        $util = new Util();
        // $bnd = $util->createCode(100);
        $headers[] = 'Content-Type: multipart/form-data';
        $headers[] = 'Authorization: Bearer ' . $token;
        return $headers;
    }
    function validate(){
        if( empty($this->related_item) ){
            throw new Exception('Gallery Item field is empty');
        }
        if( empty($this->type) ){
            throw new Exception('Gallery type field is empty');
        }
        if( empty($this->path_name) ){
            throw new Exception('Gallery field is empty');
        }
        return true;
    }
 }
 
?>