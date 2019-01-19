<meta name="viewport" content="width=device-width,initial-scale=1.0">
<?php
	require("config.php");
	if (!array_key_exists("pdfFile", $_FILES)) {
		Header("HTTP/2.0 400");
		echo '<h1>无效请求!</h1><br><a href="javascript:history.back();">返回</a>';
		exit;
	}
	if (array_key_exists("pdfFile", $_FILES) && $_FILES["pdfFile"]["error"] == 4) {
		Header("HTTP/2.0 400");
		echo '<h1>请上传文件!</h1>';
		echo '<p>错误代码: '.$_FILES["pdfFile"]["error"].'</p><br>';
		echo '<a href="javascript:history.back();">返回</a>';
		exit;
	}
	if (array_key_exists("pdfFile", $_FILES) && $_FILES["pdfFile"]["error"] != 0) {
		Header("HTTP/2.0 500");
		echo '<h1>出错了!</h1>';
		echo '<p>错误代码: '.$_FILES["pdfFile"]["error"].'</p><br>';
		echo '<a href="javascript:history.back();">返回</a>';
		exit;
	}
	if ($_FILES['pdfFile']['type'] != 'application/pdf') {
		Header("HTTP/2.0 400");
		echo '<h1>您上传的不是 PDF 文件.</h1><br><a href="javascript:history.back();">返回</a>';
		exit;
	}
	$fileName = rand().'.pdf';	
	move_uploaded_file($_FILES["pdfFile"]["tmp_name"], $tmpDir."\\".$fileName);
	$cmd = $binFile." ".$tmpDir."\\".$fileName;
	shell_exec("start /b cmd /c \"$cmd\"");
	echo '<h1>已通知打印机打印 '.$_FILES["pdfFile"]["name"].'。</h1><br><a href="javascript:history.back();">返回</a>';
?>