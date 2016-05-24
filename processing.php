<?php
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>LILIQ Develop - Waiting..</title>
<link rel="stylesheet" type="text/css" href="screen.css">
</head>

<body>
	<video id="camera" width="400" height="300" autoplay style='visible:false;position:absolute; top:-1000px; left:-1000px'></video>
	<canvas id="image" width="400" height="300" style='visible:false;position:absolute; top:-1000px; left:-1000px'></canvas>
	<canvas id="overlay" width="400" height="300" style='visible:false;position:absolute; top:-1000px; left:-1000px'></canvas>
	<canvas id="face" width="400" height="300" style='visible:false;position:absolute; top:500px; left:500px'></canvas>
  <div id="screen_blue">
    <div id="screen_box">


      <div id="screen_captcha">

        <div id="bigtext_box">


          <p id="clock_txt">
<br /><br /><br /><br /><br /><br /><br />
            <DIV id="myIDdate" class="bigclock_txt" style="font-size:100px;">お待ちください</DIV>
	<canvas id="face" width="400" height="300"></canvas>

          </p>




          <br /><br /><br /><br /><br />
          <img src="img/logo.png" id="LILIQ2">

        </div>
          <br clear="all">


      </div>


    </div>
  </div>



</body>
	<script src="clmtrackr-dev/clmtrackr.js"></script>
	<script src="clmtrackr-dev/models/model_pca_20_svm.js"></script>	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script>

		var localMediaStream = null;
		var video = document.getElementById('camera');
		$(document).ready(function () {
			var hasGetUserMedia = function() {
				return (navigator.getUserMedia || navigator.webkitGetUserMedia ||
					navigator.mozGetUserMedia || navigator.msGetUserMedia);
			};
		
			var onFailSoHard = function(e) {
				console.log('エラー!', e);
			};
		
			if(!hasGetUserMedia()) {
				alert("未対応ブラウザです。");
			} else {
				window.URL = window.URL || window.webkitURL;
				navigator.getUserMedia  = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia;
				navigator.getUserMedia({video: true}, function(stream) {
					video.src = window.URL.createObjectURL(stream);
					localMediaStream = stream;
				}, onFailSoHard);
			}
		});
		setInterval('auth()', 1000);
		$('#reg').click(function() {
			var canvas = document.getElementById('face');
			var blob = getbase64(canvas.toDataURL());
			sendImage64(blob, 'reg.php');
		});

		$('#auth').click(function() {
			auth();
		});

		function auth() {
			var canvas = document.getElementById('face');
			var blob = getbase64(canvas.toDataURL());
			sendImage64(blob, 'auth.php');
		}

		var sendImage64 = function(base64, php) {
			var formData = new FormData();
			formData.append('acceptImage', base64);
			$.ajax({
				type: 'POST',
				url: php,
				data: formData,
				contentType: false,
				processData: false,
			}).then(function(data) {
				if (data < 0.3) {
					window.location.href = '0.php';
				}
			});
		};
		
		var getbase64 = function(base64){
			var base64Data = base64.split(',')[1];
			return base64Data;
		}


		//$('#bt').click(function() {
		$(document).ready(function () {
			if (true || localMediaStream) {
				console.log('start');
				var canvas = document.getElementById('overlay');
				var ctx = canvas.getContext('2d');
				var img = document.getElementById('img');

				//videoの縦幅横幅を取得
			//	var w = video.offsetWidth;
			//	var h = video.offsetHeight;

				//同じサイズをcanvasに指定
			///	canvas.setAttribute("width", w);
			//	canvas.setAttribute("height", h);

				ctx.drawImage(video, 0, 0, 400, 300);
				
				var videoInput = document.getElementById('camera');
				var tracker = new clm.tracker();
				tracker.init(pModel);
				var positions = tracker.getCurrentPosition();
				tracker.start(videoInput);
				var canvasInput = document.getElementById('overlay');
				var cc = canvasInput.getContext('2d');
				var canvasInput2 = document.getElementById('face');
				var cf = canvasInput2.getContext('2d');

				function drawLoop() {
					requestAnimationFrame(drawLoop); 	
					cc.clearRect(0, 0, canvasInput.width, canvasInput.height); 
					cc.drawImage(video, 0, 0, 400, 300);
					cc.strokeStyle = 'rgb(0, 255, 0)';
					//tracker.draw(canvasInput);		
					var positions = tracker.getCurrentPosition();
					var xMin = 9999;
					var xMax = 0;
					var yMin = 9999;
					var yMax = 0;
					if (positions != false) { 
						for (i = 0; i < 71; i++) {
							if (positions[i][0] < xMin) {
								xMin = positions[i][0];
							}
							if (positions[i][0] > xMax) {
								xMax = positions[i][0];
							}
							if (positions[i][1] < yMin) {
								yMin = positions[i][1];
							}
							if (positions[i][1] > yMax) {
								yMax = positions[i][1];
							}
						}
					}
					cc.strokeRect(xMin, yMin, xMax - xMin, yMax - yMin);
					cf.clearRect(0, 0, canvasInput.width, canvasInput.height); 
					cf.drawImage(canvasInput, xMin, yMin, xMax - xMin, yMax - yMin, 0, 0, xMax - xMin, yMax - yMin);
				}
				drawLoop();
			}			
		});
</script>
</html>


<?php
?>
