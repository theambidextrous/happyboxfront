<?php 
/** 
 * @author - j.o
 * @license propriatery
 * @file - MPesa.php
 * @usage - MPesa objects
 */
class MPesaC2b {
	private $consumer_key;
	private $consumer_secret;
	private $shortcode;
	private $msisdn;
	private $amount;
    private $billrefnumber;
    private $constants;//[env, confrimation, validdation]

	function __construct($consumer_key, $consumer_secret, $shortcode, $msisdn, $amount, $billrefnumber, $constants){
		$this->consumer_key = $consumer_key;
		$this->consumer_secret = $consumer_secret;
		$this->shortcode = $shortcode;
		$this->msisdn = $msisdn;
		$this->amount = $amount;
        $this->billrefnumber = $billrefnumber;
        $this->constants = $constants;
	}
	function CreateToken(){
		$url = 'https://'.$this->constants[0].'.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
		$curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic '.base64_encode($this->consumer_key.':'.$this->consumer_secret)));
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        $res = curl_exec($curl);
        if ( array_key_exists('access_token', json_decode($res, true)) ){
        	return json_decode($res)->access_token;
        }else{
        	return null;
        }
	}
	function RegisterUrl(){
	  $url = 'https://'.$this->constants[0].'.safaricom.co.ke/mpesa/c2b/v1/registerurl';
      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL, $url);
      curl_setopt($curl, CURLOPT_HTTPHEADER, array(
          'Content-Type:application/json',
          'Authorization:Bearer ' . $this->CreateToken())
          ); 
      $c_data = [
        'ShortCode'=>$this->shortcode,
        'ResponseType'=>'Completed',
        'ConfirmationURL'=>$this->constants[1],
        'ValidationURL'=>$this->constants[2]
      ];
      
      $data_string = json_encode($c_data);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
    //   print($data_string);
      $curl_response = curl_exec($curl);
      return $curl_response;
	}
	function Simulate(){
		$url = 'https://'.$this->constants[0].'.safaricom.co.ke/mpesa/c2b/v1/simulate';
		$curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$this->CreateToken()));
        $curl_post_data = array(
            'ShortCode' => $this->shortcode,
            'CommandID' => 'CustomerPayBillOnline',
            'Amount' => $this->amount,
            'Msisdn' => $this->msisdn,
            'BillRefNumber' => $this->billrefnumber
        );
        $data_string = json_encode($curl_post_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($curl, CURLOPT_HEADER, false);
        $res = curl_exec($curl);
        return $res;
	}
}
class MPesaExpress{
	private $ConsumerKey;
	private $ConsumerSecret;
	private $ShortCode;
    private $PassKey;
    private $Constants;//[env]
	private $TransType;
	private $Amount;
	private $CustomerPhone;
	private $CallBackUrl;
	private $AccountReference;
	private $TransDesc;
    private $Remark;

	function __construct($ConsumerKey, $ConsumerSecret, $ShortCode, $PassKey, $Constants, $TransType = null, $Amount = null, $CustomerPhone = null, $CallBackUrl = null, $AccountReference = null, $TransDesc = null, $Remark = null){
		$this->ConsumerKey = $ConsumerKey;
		$this->ConsumerSecret = $ConsumerSecret;
		$this->ShortCode = $ShortCode;
        $this->PassKey = $PassKey;
        $this->Constants = $Constants;
		$this->TransType = $TransType;
		$this->Amount = $Amount;
		$this->CustomerPhone = $CustomerPhone;
		$this->CallBackUrl = $CallBackUrl;
		$this->AccountReference = $AccountReference;
		$this->TransDesc = $TransDesc;
		$this->Remark = $Remark;
	}
	function CreatePassword(){
		$timestamp = date("Ymdhis");
        return base64_encode($this->ShortCode.$this->PassKey.$timestamp);
	}
	function CreateToken(){
        $url = 'https://'.$this->Constants[0].'.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic ' . base64_encode($this->ConsumerKey.':'.$this->ConsumerSecret))); 
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $curl_response = curl_exec($curl);
        // print_r($curl_response);
        return json_decode($curl_response)->access_token;
	}
	function TriggerStkPush(){
        $url = 'https://'.$this->Constants[0].'.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        	'Content-Type:application/json',
        	'Authorization:Bearer '.$this->CreateToken()
        ));
        $curl_post_data = array(
            'BusinessShortCode' => $this->ShortCode,
            'Password' => $this->CreatePassword(),
            'Timestamp' => date("Ymdhis"),
            'TransactionType' => $this->TransType,
            'Amount' => $this->Amount,
            'PartyA' => $this->CustomerPhone,
            'PartyB' => $this->ShortCode,
            'PhoneNumber' => $this->CustomerPhone,
            'CallBackURL' => $this->CallBackUrl,
            'AccountReference' => $this->AccountReference,
            'TransactionDesc' => $this->TransDesc,
            'Remark'=> $this->Remark
        );
        $data_string = json_encode($curl_post_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($curl, CURLOPT_HEADER, false);
        $res = curl_exec($curl);
        // print_r($res);
        return $res;
    }
    function QueryStkStatus($CheckoutRequestID){       
        $url = 'https://'.$this->Constants[0].'.safaricom.co.ke/mpesa/stkpushquery/v1/query';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        	'Content-Type:application/json',
        	'Authorization:Bearer '.$this->CreateToken()
        ));
        $curl_post_data = array(
            'BusinessShortCode' => $this->ShortCode,
            'Password' => $this->CreatePassword(),
            'Timestamp' => $date("Ymdhis"),
            'CheckoutRequestID' => $CheckoutRequestID
        );
        $data_string = json_encode($curl_post_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($curl, CURLOPT_HEADER, false);
        $res = curl_exec($curl);
        return $res;
    }
}