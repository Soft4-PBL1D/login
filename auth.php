<?php
	$data = $_POST['acceptImage'];
	$uploaddir = '/opt/upload/';
	$fileName = 'authimg';
	$uploadfile = $uploaddir . $fileName;
	file_put_contents($uploadfile, base64_decode($data));
	sleep(1);
	$authSig = puzzle_fill_cvec_from_file($uploadfile);
	$imgList = scandir('/opt/upload/reg/');
	foreach($imgList as $file) {
		if ($file == '..' || $file == '.') {
			continue;
		}
		$regSig = puzzle_fill_cvec_from_file("/opt/upload/reg/$file");
		$num = puzzle_vector_normalized_distance($authSig, $regSig);
		if ($num < 0.5) {
			echo "You are $file";
			break;
		} else {
			echo "continue";
		}
	}
?>
