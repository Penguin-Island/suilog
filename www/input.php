<?php
session_start();
require(__DIR__ . '/check.php');
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="css/style.css">
	<title>おもいでを記録 | すいログ</title>
</head>

<body>
	<?php require __DIR__ . '/header.php'; ?>
	<?php
	$json = file_get_contents(__DIR__ . '/area/area.json');
	$arr = json_decode($json, true); ?>

	<div class="wave">
		<div class="back">
			<div class="container">
				<div class="spacer"></div>
				<h2>おもいでを記録</h2>
				<form action="input_do.php" method="post">
					<div class="all-form">
						<div class="form">
							<label for="name">水族館</label>
							<select name="name" id="name" class="name">
								<?php
								foreach ($arr as $data) {
								?>
									<optgroup label="<?= $data['prefecture'] ?>">
										<?php
										foreach ($data['aquariums'] as $detail) {
										?>
											<option value="<?= $detail['name'] ?>"><?= $detail['name'] ?></option>
										<?php
										}
										?>
									</optgroup>
								<?php
								}
								?>
							</select>
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

						<script src='/js/rating.js'>
						</script>

						<div class="form">
							<label for="memo">感想</label>
							<textarea required id="memo" name="memo" placeholder="例:友人と行きました。"></textarea>
						</div>
					</div>
					<div class="button">
						<input class="in-submit" type="submit" value="記録する">
					</div>
				</form>
			</div>
		</div>
	</div>

	<?php require __DIR__ . '/footer.php'; ?>
</body>

</html>