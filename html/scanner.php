<?php
  require("functions.php");
  require("config.php");
?>
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>在线扫描</title>
  <style type="text/css"> body { font-family: serif; }</style>
</head>
<body>
  <h1>在线扫描</h1>
  <h3>对您的文件进行扫描。</h3>
  <h4>您也可以使用打印机功能，请移步<a href="./">打印</a>。</h4>
  <form action="./exec.php" method="POST" target="_blank">
    <input type="hidden" name="mode" value="scan" />
    <div style="margin: 10px 10px 10px 10px; border: 1px solid #acacac; width: 300px">
      格式: <select name="format">
        <option value="1">BMP</option>
        <option value="2">PNG</option>
        <option value="3">GIF</option>
        <option value="4" selected>JPG</option>
        <option value="5">TIFF</option>
      </select><br>
      色彩: <select name="color">
        <option value="1" selected>真彩色</option>
        <option value="2">灰度</option>
        <option value="3">黑白</option>
      </select><br>
      DPI: <input type="number" name="dpi" value="<?php echo $scannerMaxDPI; ?>"></input><br>
      手动指定宽高 (建议使用默认尺寸): <br>
      宽度: <input type="number" name="width" value="<?php echo $defaultScanWidth; ?>"></input><br>
      高度: <input type="number" name="height" value="<?php echo $defaultScanHeight; ?>"></input>
    </div>
    <br>
    <input type="submit" value="提交">
    <b>(请注意，点击提交后可能会有数秒的响应延迟，请不要刷新以避免重复扫描。)</b>
  </form>
  <?php echo $additionalInfoScanner; ?>
  <br>
  <br>
  <div style="position: fixed; bottom: 0;">
    <b>Code with ❤️ by <a href="https://qwq.ren/">Victor_Huang</a></b>
  </div>
</body>
</html>