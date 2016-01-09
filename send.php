<?php
/*
    author：leafrainy
    time：2016-01-09 16:03:07
    version：0.2.1
*/
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE );


//配置微信

define('CorpID', 'XXXXXX');
define('Secret', 'XXXXXX');


if($_GET['msg']){


    $text=urldecode(htmlspecialchars(trim($_GET['msg'])));
    $touser=urldecode(htmlspecialchars(trim($_GET['to'])));
    if($touser){
        send_text($text,$touser);
    }else{
        send_text($text,"yywt");
    }

    exit;

}else{

    echo "error";

}



//获取token 并写入文件

function get_token(){

    $get_token_url="https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=".CorpID."&corpsecret=".Secret;

    $res=json_decode(http_get($get_token_url));

    $access_token = $res->access_token;

    $createtime=time();

    $content=json_encode(array("access_token"=>$access_token,"createtime"=>$createtime));

    w_token($content);



}



//get请求

function http_get($url){

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

    curl_setopt($ch, CURLOPT_TIMEOUT, 50);

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    $output = curl_exec($ch);

    curl_close($ch);



    return $output;

}

//post请求

function http_post($url,$content){



    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

    curl_setopt($ch, CURLOPT_TIMEOUT, 50);

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    curl_setopt($ch, CURLOPT_POST, 1); 

    curl_setopt($ch, CURLOPT_POSTFIELDS, $content);


    $output = curl_exec($ch);

    curl_close($ch);

    return $output;

}



//写token

function w_token($content){

    $fp = fopen("access_token.json", "w");

    fwrite($fp,$content);

    fclose($fp);

}

//读token

function r_token(){

    return trim(file_get_contents('access_token.json'));

}



//获取token

function use_token(){

    $token_data=json_decode(r_token(),true);



    if(time()-$token_data['createtime']>3000){

        get_token();

        $token_data=json_decode(r_token(),true);

    }



    return $token_data['access_token'];



}



function send_text($text,$touser){

     $access_token=use_token();

     $send_url="https://qyapi.weixin.qq.com/cgi-bin/message/send?access_token=".$access_token;

     $content='{

                   "touser": "'.$touser.'",

                   "toparty": "",

                   "totag": "",

                   "msgtype": "text",

                   "agentid": 2,

                   "text": {

                       "content": "'.$text.'"

                   },

                   "safe":"1"

                }';



   echo http_post($send_url,$content);


}


?>