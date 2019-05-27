<?php
	require("config.php");
	require("functions.php");
	if (!isset($_POST['mode'])) {
		echo '<meta name="viewport" content="width=device-width,initial-scale=1.0">';
		Header("HTTP/2.0 400");
		echo '<h1>无效请求!</h1><br><a href="javascript:history.back();">返回</a>';
		exit;
	}
	switch ($_POST['mode']) {
		case 'print':
			echo '<meta name="viewport" content="width=device-width,initial-scale=1.0">';
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
			$cmd = $printerBinFile." ".$tmpDir."\\".$fileName;
			shell_exec("start /b cmd /c \"$cmd\"");
			echo '<h1>已通知打印机打印 '.$_FILES["pdfFile"]["name"].'。</h1><br><a href="javascript:history.back();">返回</a>';
			break;
		case 'scan':
			$formats = ["JPG", "BMP","PNG","GIF","JPG","TIF"];
			$colors = ["RGB", "RGB","GRAY","BW"];
			$format = isset( $formats[intval($_POST['format'])] ) ? $formats[intval($_POST['format'])] : $formats[0];
			$color = isset( $colors[intval($_POST['color'])] ) ? $colors[intval($_POST['color'])] : $colors[0];
			$dpi = intval($_POST['dpi']) >= 0 && intval($_POST['dpi']) <= $scannerMaxDPI ? intval($_POST['dpi']) : $scannerMaxDPI;
			$width = intval($_POST['width']) < 0 ? 0 : intval($_POST['width']);
			$height = intval($_POST['height']) < 0 ? 0 : intval($_POST['height']);
			$fileName = "document-".time().".".$format;
			$cmd = $scannerBinFile." /w $width /h $height /dpi $dpi /color $color /format $format /output ".$tmpDir."\\".$fileName;
			shell_exec($cmd);
			if (! file_exists($tmpDir."\\".$fileName)) {
				echo '<meta name="viewport" content="width=device-width,initial-scale=1.0">';
				Header("HTTP/2.0 500");
				echo '<h1>找不到文件，可能是参数设置错误!</h1><br><a href="javascript: window.close();">关闭</a>';
				exit;
			}
			$file = fopen($tmpDir."\\".$fileName, "r");
			$size = filesize($tmpDir."\\".$fileName);
			Header("Content-Type: ".getMIME($format));
			Header("Content-Length: ".$size);
			Header("Content-Disposition: inline; filename=".$fileName);
			echo fread($file, $size);
			fclose($file);
			break;
		default:
			echo '<meta name="viewport" content="width=device-width,initial-scale=1.0">';
			Header("HTTP/2.0 400");
			echo '<h1>无效请求!</h1><br><a href="javascript:history.back();">返回</a>';
			exit;
			break;
	}
?>