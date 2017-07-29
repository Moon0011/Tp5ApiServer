<?php

namespace app\index\controller;

use think\Controller;

class Index extends Controller {
	public function index() {
		header('Access-Control-Allow-Origin: *');
		header('Content-Type: application/json; charset=UTF-8');
		$arr = array (
				'sites' =>array(
						array(
								'Name'=>'Tome','Age'=>23,'Country'=>'武汉'
						),
						array(
								'Name'=>'Lucy','Age'=>34,'Country'=>'深圳'
						),
						array(
								'Name'=>'Tome','Age'=>53,'Country'=>'长沙'
						)
				)
		);
		$json_string = json_encode ( $arr );
		echo $json_string;
	}
}
