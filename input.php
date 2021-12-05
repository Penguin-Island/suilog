<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="css/style.css">
	<title>思い出を記録する【すいログ】</title>
</head>

<body>
	<?php require __DIR__ . '/header.php'; ?>

	<div class="wave">
		<div class="container">
			<h2>思い出を記録する</h2>
			<form action="input_do.php" method="post">
				<div class="all-form">
					<div class="form">
						<label for="name">水族館</label>
						<input type="text" id="name" name="name" class="name" maxlength="255" placeholder="〇△水族館">
					</div>

					<div class="form">
						<label for="date">日付</label>
						<input type="date" id="date" name="date" class="date">
					</div>

					<div class="rating">
						<i class="fa fa-star active"></i>
						<i class="fa fa-star-o"></i>
						<i class="fa fa-star-o"></i>
						<i class="fa fa-star-o"></i>
						<i class="fa fa-star-o"></i>
					</div>

					<script src='suilog/js/rating.js'>
					</script>


					<div class="form">
						<label for="memo">感想</label>
						<textarea required id="memo" name="memo" placeholder="例:たのしかったでつ！"></textarea>
					</div>
				</div>
				<div class="button">
					<input class="in-submit" type="submit" value="記録する">
				</div>
			</form>
		</div>
	</div>

	<?php require __DIR__ . '/footer.php'; ?>
</body>

</html>