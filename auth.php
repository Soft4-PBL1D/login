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
		$num = shell_exec("puzzle-diff -c -t -p 10 /opt/upload/authimg /opt/upload/reg/$file");
		file_put_contents('au', "$num\n", FILE_APPEND);
		if ($num < 0.5) {
			echo "You are $file";
			session_start();
			$_SESSION['userid'] = $file;
			break;
		} else {
			echo "continue";
		}
	}
?>
