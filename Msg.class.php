<?php 
/*
 *	基于微信企业号的消息发送工具
 *	2017-04-30 19:59:50
 *	leafrainy （leafrainy.cc）
 */


Class Msg{

	public function __construct($config){
		
		$this->CorpID  = isset($config['CorpID'])?$config['CorpID']:'';
		$this->Secret  = isset($config['Secret'])?$config['Secret']:'';
		$this->debug   = isset($config['debug'])?$config['debug']:1;

	}


	//token读文件
	private function readToken(){

		$token_data=json_decode(trim(file_get_contents('access_token.json')),true);
		if(time()-$token_data['createtime']>3000){
	        $this->getToken();
			$token_data =json_decode(trim(file_get_contents('access_token.json')),true);
	    }
	    return $token_data['access_token'];
	}

	//token写文件
	private function writeToken($content){
		$fp = fopen("access_token.json", "w");
    	fwrite($fp,$content);
    	fclose($fp);
	}

	//token获取并写入文件
	private function getToken(){
		$get_token_url="https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=".$this->CorpID."&corpsecret=".$this->Secret;
    	$res=json_decode($this->httpGet($get_token_url));
    	$access_token = $res->access_token;
    	$createtime=time();
    	$content=json_encode(array("access_token"=>$access_token,"createtime"=>$createtime));
    	$this->writeToken($content);
	}

	//get请求
	private function httpGet($url){
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
	private function httpPost($url,$content){
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

	//写日志
	private function writeLog($status,$content){
		$fp = fopen("msg_log", "a");
		$log_info = "[".$status."][time:".date('Y-m-d H:i:s',time())."] 事件：".$content."\n\n";
    	fwrite($fp,$log_info);
    	fclose($fp);

	}

	//发送消息
	public function sendMsg($text,$touser,$agentid,$msgSafe=0){

		$access_token=$this->readToken();
		$send_url="https://qyapi.weixin.qq.com/cgi-bin/message/send?access_token=".$access_token;
		$content='{
			"touser": "'.$touser.'",
			"toparty": "",
			"totag": "",
			"msgtype": "text",
			"agentid": "'.$agentid.'",
			"text": {
				"content": "'.$text.'"
			},
			"safe":"'.$msgSafe.'"
			}';
		$msgRes = $this->httpPost($send_url,$content);

		//写日志
		if($this->debug){
			if(json_decode($msgRes,true)['errcode']){
				$this->writeLog("ERROR","发送信息【".$text."】给【".$touser."】失败");
			}else{
				$this->writeLog("SUCCESS","发送信息【".$text."给【".$touser."】成功");
			}
		}

	}


}



?>
