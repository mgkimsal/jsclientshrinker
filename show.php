<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
    "http://www.w3.org/TR/html4/strict.dtd">
<html>
<!--
copyright michael kimsal 2010
http://michaelkimsal.com/
released into public domain
-->
<head>
<script type="text/javascript">var _sf_startpt=(new Date()).getTime()</script>
<title>Client side JavaScript file resize and upload</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<style>
body {
	font-size: 16px;
	font-family: Arial;
}
#preview {
	display:none;
}
#base64 {
	display:none;
}
</style>
</head>
<body>
<?php
$base64size = strlen($_POST['base64']);
$f = base64_decode($_POST['base64']);
$name = microtime(true).".png";
file_put_contents("./$name", $f);
#header("Content-type: image/png");
#header("Content-Disposition: attachment; filename=\"shrunk.png\"");
#echo $f;
#die();
?>
<h2>Shrunk file</h2>
<p>Original file was: <?=$_POST['orig'];?> bytes</p>
<p>Transmitted size was: <?=$base64size;?> bytes (due to base64)</p>
<p>New file is: <?=filesize("./$name");?> bytes</p>
<p><img src="<?=$name;?>"/></p>

<a href="shrinker.tgz">grab this code</a> 
</body>
<script type="text/javascript">
var _sf_async_config={uid:9726,domain:"michaelkimsal.com"};
(function(){
  function loadChartbeat() {
    window._sf_endpt=(new Date()).getTime();
    var e = document.createElement('script');
    e.setAttribute('language', 'javascript');
    e.setAttribute('type', 'text/javascript');
    e.setAttribute('src',
       (("https:" == document.location.protocol) ? "https://s3.amazonaws.com/" : "http://") +
       "static.chartbeat.com/js/chartbeat.js");
    document.body.appendChild(e);
  }
  var oldonload = window.onload;
  window.onload = (typeof window.onload != 'function') ?
     loadChartbeat : function() { oldonload(); loadChartbeat(); };
})();


</script>

</html>
