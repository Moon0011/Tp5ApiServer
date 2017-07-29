<?php

namespace app\index\model;

use think\Model;

class Upload extends Model {
	public function upload() {
		define ( 'HTTP_PUBLIC_PATH', 'http://192.168.0.106:8081/Tp5ApiServer/public/' );
		$fileName = $_FILES ["file"] ["name"];
		$fileType = $_FILES ["file"] ["type"];
		$fileSize = $_FILES ["file"] ["size"] / 1024;
		$fileError = $_FILES ["file"] ["error"];
		$fileTmpName = $_FILES ["file"] ["tmp_name"];
		// 文件格式正确且小于300KB
		if ((($fileType == "image/gif") || ($fileType == "image/jpg") || ($fileType == "image/png")) && ($fileSize < 300)) {
			if ($fileError > 0) {
				$arr = array (
						'code' => 200,
						'msg' => 'success',
						'data' => array (
								'info' => '图片替换失败 ',
								'path' => '',
								'filename' => '' 
						) 
				);
				$json_string = json_encode ( $arr );
				echo $json_string;
			} else {
				$filePath = ROOT_PATH . 'public' . DS . 'uploads/' . $_FILES ["file"] ["name"];
				if (file_exists ( $filePath )) {
					$arr = array (
							'code' => 200,
							'msg' => 'success',
							'data' => array (
									'info' => '图片重复上传了' 
							) 
					);
					$json_string = json_encode ( $arr );
					echo $json_string;
					return;
				} else {
					move_uploaded_file ( $fileTmpName, $filePath );
				}
				$arr = array (
						'code' => 200,
						'msg' => 'success',
						'data' => array (
								'info' => '替换头像成功',
								'path' => HTTP_PUBLIC_PATH . 'uploads/' . $_FILES ["file"] ["name"],
								'filename' => $fileName 
						) 
				);
				$json_string = json_encode ( $arr );
				echo $json_string;
			}
		} else {
			$arr = array (
					'code' => 200,
					'msg' => 'success',
					'data' => array (
							'info' => '文件格式错误或图片过大',
							'path' => '',
							'filename' => '' 
					) 
			);
			$json_string = json_encode ( $arr );
			echo $json_string;
		}
	}
}