<?php

namespace app\index\model;

use think\Model;
use think\Request;
use app\index\sdk\CCPRestSDK;

class Register extends Model {
	public function register() {
		$request = Request::instance (); // 实例化请求
		$user = $request->param (); // 获取请求信息
		$username = Db ( 'user' )->column ( 'username' );
		if (in_array ( $user ['username'], $username )) {
			$arr = array (
					'code' => 200,
					'msg' => 'success',
					'data' => array (
							'info' => '用户名已注册过!',
							'isOk' => 0 
					) 
			);
			$json_string = json_encode ( $arr );
			echo $json_string;
			return;
		}
		$data = [ 
				'username' => $user ['username'],
				'pwd' => $user ['password'],
				'head_img' => 'http://192.168.0.106:8081/tp5apiserver/public/static/img/head002.jpg' 
		];
		// $data = [
		// 'username' => 'Tom',
		// 'pwd' => 00212,
		// 'head_img' => ''
		// ];
		$result = db ( 'user' )->insert ( $data );
		if ($result == 1) {
			$arr = array (
					'code' => 200,
					'msg' => 'success',
					'data' => array (
							'info' => '注册成功!',
							'isOk' => 1 
					) 
			);
		} else {
			$arr = array (
					'code' => 200,
					'msg' => 'success',
					'data' => array (
							'info' => '注册失败！',
							'isOk' => 0 
					) 
			);
		}
		$json_string = json_encode ( $arr );
		echo $json_string;
	}
	public function register2() {
		$to = "18371458939";
		$datas = array (
				'6532',
				'5' 
		);
		$tempId = "1";
		$serverIP = 'app.cloopen.com';
		// 初始化REST SDK
		// 主帐号,对应开官网发者主账号下的 ACCOUNT SID
		$accountSid = '8aaf07085d7cf73f015d8985a614059a';
		// 主帐号令牌,对应官网开发者主账号下的 AUTH TOKEN
		$accountToken = 'b31c5bacab4c43d6b67c4ab4d1f57b12';
		// 应用Id，在官网应用列表中点击应用，对应应用详情中的APP ID
		// 在开发调试的时候，可以使用官网自动为您分配的测试Demo的APP ID
		$appId = '8a216da85d7dbf78015d8987138e051b';
		// 请求地址
		// 沙盒环境（用于应用开发调试）：sandboxapp.cloopen.com
		// 生产环境（用户应用上线使用）：app.cloopen.com
		$serverIP = 'app.cloopen.com';
		// 请求端口，生产环境和沙盒环境一致
		$serverPort = '8883';
		// REST版本号，在官网文档REST介绍中获得。
		$softVersion = '2013-12-26';
		$rest = new CCPRestSDK ( $serverIP, $serverPort, $softVersion );
		$rest->setAccount ( $accountSid, $accountToken );
		$rest->setAppId ( $appId );
		
		// 发送模板短信
		echo "Sending TemplateSMS to $to <br/>";
		$result = $rest->sendTemplateSMS ( $to, $datas, $tempId );
		if ($result == NULL) {
			echo "result error!";
			break;
		}
		if ($result->statusCode != 0) {
			echo "error code :" . $result->statusCode . "<br>";
			echo "error msg :" . $result->statusMsg . "<br>";
			// TODO 添加错误处理逻辑
		} else {
			echo "Sendind TemplateSMS success!<br/>";
			// 获取返回信息
			$smsmessage = $result->TemplateSMS;
			echo "dateCreated:" . $smsmessage->dateCreated . "<br/>";
			echo "smsMessageSid:" . $smsmessage->smsMessageSid . "<br/>";
			// TODO 添加成功处理逻辑
		}
	}
}