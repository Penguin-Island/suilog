<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="css/style.css">
	<title>すいログ -水族館をさがす・レビューする-</title>
</head>

<body>
	<?php
	require(__DIR__ . '/header.php');
	?>
	<div class="wave">
		<div class="container">
			<div class="spacer"></div>
			<div class="search">
				<div class="position">
					<h2 id="srch">さがす</h2>
					<ul class="column">
						<li><a href="area/hokkaido.php" class="area-button-b">北海道</a></li>
						<li><a href="area/tohoku.php" class="area-button-w">東北</a></li>
						<li><a href="area/chubu.php" class="area-button-b">中部</a></li>
						<li><a href="area/kanto.php" class="area-button-w">関東</a></li>
						<li><a href="area/kinki.php" class="area-button-b">近畿</a></li>
						<li><a href="area/chugoku.php" class="area-button-w">中国</a></li>
						<li><a href="area/shikoku.php" class="area-button-b">四国</a></li>
						<li><a href="area/kyushu.php" class="area-button-w">九州・沖縄</a></li>
					</ul>
				</div>
			</div>
			<div class="memory">
				<div class="position">
					<h2 id="review">おもいで</h2>
					<a href="input.php" class="st-button-b">記録する</a>
					<a href="view.php" class="st-button-w">ふりかえる</a>
				</div>
			</div>
		</div>
	</div>
	<?php require __DIR__ . '/footer.php'; ?>
</body>

</html>