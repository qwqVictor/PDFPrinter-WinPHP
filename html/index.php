<?php
  require("functions.php");
  require("config.php");
?>

<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>PDF 文件打印</title>
  <style type="text/css"> body { font-family: serif; }</style>
</head>
<body>
  <h1>PDF 文件打印</h1>
  <h3>上传你的 PDF 来调用打印机开始打印。</h3>
  <h4>目前仅支持 A4 纸打印，如果有更多定制需求，请使用 Internet 打印协议。</h4>
  <form action="./upload.php" enctype="multipart/form-data" method="POST">
    <div style="margin: 10px 10px 10px 10px; border: 1px solid #acacac; width: 300px">
      <input type="file" id="pdfFile" name="pdfFile">
    </div>
    <br>
    <input type="submit" value="提交">
    <b>(请注意，点击提交后可能会有数秒的响应延迟，请不要刷新以避免重复打印。)</b>
  </form>
  <h3>若要通过 Internet 打印协议来打印，请将打印机地址设置如下:</h3>
  <pre>http://<?php echo $hostname; ?>/printers/<?php echo $printer_name; ?>/.printer</pre>
  <i>对于非 Windows 操作系统，请考虑将 http 替换为 https 来使用 IPP over HTTPS 协议。</i>
  <br>
  <?php echo $additionalInfo; ?>
  <br>
  <br>
  <div style="position: fixed; bottom: 0;">
    <b>Code with ❤️ by <a href="https://qwq.ren/">Victor_Huang</a></b>
  </div>
</body>
</html>
