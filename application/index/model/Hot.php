<?php

namespace app\index\model;

use think\Model;
use think\Request;

class Hot extends Model {
	public function getInfo() {
		$totalrows = 17;
		$perpages = 5;
		$request = Request::instance ();
		$params = $request->param ();
		$page = $params ['page'];
		// echo 'page =' . $page . '<br/>';
		$totalpages = ($totalrows % $perpages == 0) ? floor ( $totalrows / $perpages ) : floor ( $totalrows / $perpages ) + 1;
		// echo $totalpages;
		if ($page > $totalpages || $page < 0) {
			return;
		}
		if ($page == $totalpages) {
			$hot = db ( 'hot' )->limit ( ($page - 1) * $perpages, $totalrows - ($page - 1) * $perpages )->select ();
		} else {
			$hot = db ( 'hot' )->limit ( ($page - 1) * $perpages, $perpages )->select (); // 分页查询,每页5条数据
		}
		$pagination = db ( 'pagination' )->find ();
		$arr = array (
				'code' => 200,
				'msg' => 'success',
				'data' => $hot,
				'meta' => array (
						"pagination" => array (
								'total' => $pagination ['total'],
								"count" => $pagination ['count'],
								'per_page' => $pagination ['perpage'],
								'current_page' => $pagination ['currentpage'],
								'total_pages' => $pagination ['totalpages'],
								'links' => $pagination ['links'] 
						) 
				) 
		);
		$json_string = json_encode ( $arr );
		echo $json_string;
	}
}