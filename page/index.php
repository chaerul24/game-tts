<?php
session_start();
if(isset($_SESSION['user'])){
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Pilih Level</title>
	<script src="level/jquery-3.6.0.min.js"></script>
	<style>
		body {
			display: flex;
			justify-content: center;
			align-items: center;
			flex-direction: column;
			background-image: url('https://t3.ftcdn.net/jpg/03/23/88/08/360_F_323880864_TPsH5ropjEBo1ViILJmcFHJqsBzorxUB.jpg');
			background-size: 100%, 100%;
			background-repeat: no-repeat;
			color: white;
		}
		.container {
			width: 500px;
			position: relative;
			top: 10px;
			display: flex;
			flex-wrap: wrap;
			gap: 20px;
		}
		.block {
			border-radius: 10px;
			width: 100px;
			height: 100px;
			border: 1px solid transparent;
			color: white;
			background-color: rgb(90, 0, 60);
			cursor: pointer;
			display: flex;
			justify-content: center;
			align-items: center;
			text-align: center;
		}
		.block:hover {
			border: 1px solid white;
		}
		a {
			text-decoration: none;
		}
		#logout {
			width: 35px;
			height: 35px;
			padding: 10px;
			position: absolute;
			right: 20px;
			top: 20px;
			cursor: pointer;
		}
	</style>
</head>
<body>
	<h1>Pilih Level</h1>
	<img src="switch.png" alt="logout" id="logout">
	<div class="container">
			<div class="block" value="1">
				1 <br>
				Mainkan
			</div>
			<div class="block" value="2">
				2 <br>
				Mainkan
			</div>
			<div class="block" value="3">
				3 <br>
				Mainkan
			</div>
			<div class="block" value="4">
				4 <br>
				Mainkan
			</div>
			<div class="block" value="5">
				5 <br>
				Mainkan
			</div>
			<div class="block" value="6">
				6 <br>
				Mainkan
			</div>
			<div class="block" value="7">
				7 <br>
				Mainkan
			</div>
	</div>

	<script>
        $(document).ready(function() {
			function backsound() {
				var audio = new Audio();
				audio.src = "music/backsound.mp3"; // Gunakan '=' untuk assignment
				audio.loop = true;
				audio.autoplay = true;
				audio.play();
			}
			
			backsound();
			function click() {
                var audio = new Audio();
                audio.src = "music/click.mp3"; // Gunakan '=' untuk assignment
                audio.play(); // Hapus properti loop dan autoplay
            }
			

            // Menambahkan event click pada elemen dengan kelas .block
            $(".block").each(function() {
                $(this).on("click", function() {
                    click();
					var value = $(this).attr("value");
					if ($(this).parent('a').length == 0) {
						setTimeout(function(){
							window.location.href = 'level/' + value + '.html';
						}, 1000);
					}
                });
            });
			$('#logout').click(function(){
				window.location.href = 'logout.php';
			});
        });
    </script>
</body>
</html>
<?php
} else {
	header('Location: http://localhost');
}
?>