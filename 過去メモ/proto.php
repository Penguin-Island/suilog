<?php
	if(isset($_POST["place"])){
	$place=$_POST["place"];
	echo $place;
	}
?>

<h3>行ったことのある水族館</h3>
		<form action="submit.php" method="post">
			<label for="place">水族館:</label>
			<input type="text" id="place" name="place" maxlength="255" value="">
			<input type="submit" value="送信">
		</form>	


//input.html 2021.08.22
<!DOCTYPE HTML>
<html>
    <head>
    </head>
    <body>
    	<h3>行ったことのある水族館</h3>

		<form action="input_do.php" method="post">
			<label for="pla">水族館:</label>
			<input type="text" id="memo" name="memo" maxlength="255" value="">
			<input type="submit" value="送信">
		</form>	
    </body>
</html>