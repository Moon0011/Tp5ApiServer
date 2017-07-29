<?php

namespace app\index\controller;

use think\Controller;
use app\index\model\Hot;
use app\index\model\Login;
use app\index\model\Register;
use app\index\model\Upload;
use app\index\model\SMSVerification;

class Hqclient extends Controller {
	public function hot() {
		$hot = new Hot ();
		$hot->getInfo ();
	}
	public function login() {
		$login = new Login ();
		$login->login ();
	}
	public function register() {//普通账号注册
		$register = new Register ();
		$register->register ();
	}
	public function registerSms() {//短信注册账号
		$register = new Register ();
		$register->register2 ();
	}
	public function upload() {
		$upload = new Upload ();
		$upload->upload ();
	}
}