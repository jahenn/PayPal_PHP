<?php

$sas = new PayPal;
$sas->get_token();

/**
* 
*/
class PayPal
{
	private $LOCAL_URL;
	private $PP_END_POINT;
	private $PP_USER_ID;
	private $PP_PWD;
	private $PP_SIGN;
	function __construct()
	{
		$this->LOCAL_URL ="http://localhost/PayPal_PHP";
		$this->PP_END_POINT = "https://api-3t.sandbox.paypal.com/nvps";
		$this->PP_USER_ID = "jb-us-seller_api1.paypal.com";
		$this->PP_PWD = "WX4WTU3S8MY44S7F";
		$this->PP_SIGN = "AFcWxV21C7fd0v3bYYYRCpSSRl31A7yDhhsPUU2XhtMoZXsWHFxu-RWy";
	}
	function get_token(){
		$params = array(
				"USER"=>$this->PP_USER_ID,
				"PWD"=>$this->PP_PWD,
				"SIGNATURE"=>$this->PP_SIGN,
				"METHOD"=>"SetExpressCheckout",
				"VERSION"=>"86",
				"L_BILLINGTYPE0"=>"RecurringPayments",
				"L_BILLINGAGREEMENTDESCRIPTION0"=>"SpotPrices MemberShip",
				"cancelUrl"=>$this->LOCAL_URL."/cancelUrl.php",
				"returnUrl"=>$this->LOCAL_URL."/returnUrl.php"
			);
		$url_params = $this->get_url_params($params);
		$response = $this->execute_curl($url_params,$this->PP_END_POINT);
		parse_str($response, $response);
		return $response;
	}
	function execute_curl($params, $url){
		$sesion = curl_init($url);
		curl_setopt ($sesion, CURLOPT_POST, 1); 
		curl_setopt($sesion, CURLOPT_VERBOSE, 1);
		curl_setopt($sesion, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($sesion, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt ($sesion, CURLOPT_POSTFIELDS, $params); 
		curl_setopt($sesion, CURLOPT_HEADER, 0); 
		curl_setopt($sesion, CURLOPT_RETURNTRANSFER, 1);
		$respuesta = curl_exec($sesion); 
		curl_close($sesion); 
		return $respuesta;
	}
	function get_url_params($params){
		$urlParams = "";
		foreach ($params as $key => $value) {
			$urlParams .= $key."=".urlencode($value)."&";
		}
		$urlParams = rtrim($urlParams,"&");
		return $urlParams;
	}
	
}
?>
