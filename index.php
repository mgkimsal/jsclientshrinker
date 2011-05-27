<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
    "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<!--
copyright michael kimsal 2010
http://michaelkimsal.com/
released into public domain
-->
<script type="text/javascript">var _sf_startpt=(new Date()).getTime()</script>

<title>Client side JavaScript file resize and upload</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<style>
body {
	font-size: 16px;
	font-family: Arial;
}
#loader {
	display:none;
}
#preview {
	display:none;
}
#base64 {
	display:none;
}
</style>
<script type="text/javascript">


function upload() {
	var photo = document.getElementById("photo");
	var file  = photo.files[0];

	var preview = document.getElementById("preview");
	preview.src = file.getAsDataURL();
	return _resize(preview);
}

function _resize(img, maxWidth, maxHeight) 
{
        var ratio = 1;

	var canvas = document.createElement("canvas");
	canvas.style.display="none";
	document.body.appendChild(canvas);

	var canvasCopy = document.createElement("canvas");
	canvasCopy.style.display="none";
	document.body.appendChild(canvasCopy);

	var ctx = canvas.getContext("2d");
	var copyContext = canvasCopy.getContext("2d");

        if(img.width > maxWidth)
                ratio = maxWidth / img.width;
        else if(img.height > maxHeight)
                ratio = maxHeight / img.height;

        canvasCopy.width = img.width;
        canvasCopy.height = img.height;
try {
        copyContext.drawImage(img, 0, 0);
} catch (e) { 
	document.getElementById('loader').style.display="none";
//	alert("There was a problem - please reupload your image");
	return false;
}

        canvas.width = img.width * ratio;
        canvas.height = img.height * ratio;
        // the line to change
        //ctx.drawImage(canvasCopy, 0, 0, canvasCopy.width, canvasCopy.height, 0, 0, canvas.width, canvas.height);
        // the method signature you are using is for slicing
        ctx.drawImage(canvasCopy, 0, 0, canvas.width, canvas.height);

    	var dataURL = canvas.toDataURL("image/png");

	document.body.removeChild(canvas);
	document.body.removeChild(canvasCopy);
    	return dataURL.replace(/^data:image\/(png|jpg);base64,/, "");


};

function resize() { 
	var photo = document.getElementById("photo");


	if(photo.files!=undefined){ 

		var loader = document.getElementById("loader");
		loader.style.display = "inline";

		var file  = photo.files[0];
		document.getElementById("orig").value = file.fileSize;
		var preview = document.getElementById("preview");
		var r = new FileReader();
		r.onload = (function(previewImage) { 
			return function(e) { 
				var maxx = document.getElementById('maxx').value;
				var maxy = document.getElementById('maxy').value;
				previewImage.src = e.target.result; 
				previewImage.onload = function() {
					var k = _resize(previewImage, maxx, maxy);
					if (k != false) { 
						document.getElementById('base64').value= k;
						document.getElementById('upload').submit();
					} else {
						alert('problem - please attempt to upload again');
					}
				}
			}; 
		})(preview);
		r.readAsDataURL(file);
	} else {
		alert("Seems your browser doesn't support resizing");
	}
	return false;
}

//document.getElementById('photo').addEventListener('change', handleFileSelect, false);


</script>
</head>
<body>

<h2>Shrink selected file client-side before uploading</h2>
   <input type="file" name="photo" id="photo">
	<p>Max width in pixels: <input type='text' name='maxx' id='maxx' value='200'/></p>
	<p>Max height in pixels: <input type='text' name='maxy' id='maxy' value='200'/></p>
   <input type="button" onClick="resize();" value="Shrink and upload">
<img src="loader.gif" id="loader" />
   <img src="" alt="Image preview" id="preview">
<form name="upload" id="upload" method='post' action='show.php'>
<textarea name="base64" id="base64" rows='10' cols='90'></textarea>
   <input type="hidden" id="orig" name="orig" value=""/>
</form>
<a href="shrinker.tgz">grab this code</a> or pull from <a href="http://github.com/mgkimsal/jsclientshrinker">github</a>
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
