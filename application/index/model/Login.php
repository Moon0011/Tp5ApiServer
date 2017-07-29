<?php

namespace app\index\model;

use think\Model;
use think\Request;
use think\Db;

class Login extends Model {
	public function login() {
		$request = Request::instance (); // 实例化请求
		$user = $request->param (); // 获取请求信息
		$thirdLoginInfo = $user ['thirdloginInfo'];
		if (! empty ( $thirdLoginInfo )) {
			$arr = json_decode ( $thirdLoginInfo, true );
			Db::name ( 'thirduser' )->insert ( $arr );
			$arr = array (
					'code' => 200,
					'msg' => 'success',
					'data' => array (
							'info' => '登录成功！',
							'isLogin' => 1,
							'loginType' => 1 
					) 
			);
		} else {
			$result = Db::name ( 'user' )->where ( 'username', $user ['username'] )->find ();
			// $adminpwd = md5 ( $user['password'] );
			$adminpwd = $user ['password'];
			$resultpwd = $result ['pwd'];
			// echo '$adminpwd = '.$adminpwd.' ,$resultpwd = '.$resultpwd;
			if ($result ['pwd'] == $adminpwd) { // 与数据库比较，请求数据是否一致
				$arr = array (
						'code' => 200,
						'msg' => 'success',
						'data' => array (
								'info' => '登录成功!',
								'isLogin' => 1,
								'account' => $result ['username'],
								'headimg' => $result ['head_img'],
								'id' => $result ['id'],
								'pwd' => $result ['pwd'],
								'loginType' => 0 
						) 
				);
			} else {
				$arr = array (
						'code' => 200,
						'msg' => 'success',
						'data' => array (
								'info' => '登录失败！',
								'isLogin' => 0 
						) 
				);
			}
		}
		$json_string = json_encode ( $arr );
		echo $json_string;
	}
}