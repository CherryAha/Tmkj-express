﻿<?php
//电商ID
define('EBusinessID', env('KDN_BUS_ID'));
//电商加密私钥，快递鸟提供，注意保管，不要泄漏
define('AppKey', env('KDN_BUS_KEY'));
//请求url
//defined('ReqURL') or define('ReqURL', 'http://api.kdniao.com/Ebusiness/EbusinessOrderHandle.aspx');
define('ReqURL', 'http://api.kdniao.com/api/dist');

 
//调用查询物流轨迹
//---------------------------------------------

//$logisticResult=getOrderTracesByJson();
//echo logisticResult;

//---------------------------------------------

/**
 * Json方式 查询订单物流轨迹
 * @param $ShipperCode
 * @param $LogisticCode
 * @return url响应返回的html
 */
function getOrderTracesByJson($ShipperCode,$LogisticCode){

	$requestData= "{'OrderCode':'','ShipperCode':'". $ShipperCode ."','LogisticCode':'".$LogisticCode."'}";

	$datas = array(
        'EBusinessID' => EBusinessID,
        'RequestType' => '1002',
        'RequestData' => urlencode($requestData) ,
        'DataType' => '2',
    );
	$datas['DataSign'] = urlencode(base64_encode(md5($requestData.AppKey)));
	$result=sendPost(ReqURL, $datas);
	//根据公司业务处理返回的信息......
	return $result;
}
 
/**
 *  post提交数据 
 * @param  string $url 请求Url
 * @param  array $datas 提交的数据 
 * @return url响应返回的html
 */
function sendPost($url, $datas) {
    $temps = array();	
    foreach ($datas as $key => $value) {
        $temps[] = sprintf('%s=%s', $key, $value);		
    }	
    $post_data = implode('&', $temps);
    $url_info = parse_url($url);
	if(empty($url_info['port']))
	{
		$url_info['port']=80;	
	}
    $httpheader = "POST " . $url_info['path'] . " HTTP/1.0\r\n";
    $httpheader.= "Host:" . $url_info['host'] . "\r\n";
    $httpheader.= "Content-Type:application/x-www-form-urlencoded\r\n";
    $httpheader.= "Content-Length:" . strlen($post_data) . "\r\n";
    $httpheader.= "Connection:close\r\n\r\n";
    $httpheader.= $post_data;
    $fd = fsockopen($url_info['host'], $url_info['port']);
    fwrite($fd, $httpheader);
    $gets = "";
	$headerFlag = true;
	while (!feof($fd)) {
		if (($header = @fgets($fd)) && ($header == "\r\n" || $header == "\n")) {
			break;
		}
	}
    while (!feof($fd)) {
		$gets.= fread($fd, 128);
    }
    fclose($fd);  
    
    return $gets;
}
 
?>