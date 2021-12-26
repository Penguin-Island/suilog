<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="css/style.css">
	<title>すいログ -水族館をさがす・レビューする-</title>
</head>

<body>
	<?php require __DIR__ . '/header.php'; ?>
	<div class="wave">
		<div class="full">
			<div class="container">
				<div class="spacer"></div>
				<h2>さがす</h2>
				<h4>エリアからさがす</h4>
				<a href="area/hokkaido.php" class="area-button">北海道</a>
				<a href="area/tohoku.php" class="area-button">東北</a>
				<a href="area/chubu.php" class="area-button">中部</a>
				<a href="area/kanto.php" class="area-button">関東</a>
				<br>
				<a href="area/kinki.php" class="area-button">近畿</a>
				<a href="area/chugoku.php" class="area-button">中国・四国</a>
				<a href="area/kyushu.php" class="area-button">九州・沖縄</a>
				<!--</br>

				<h4>人気順からさがす</h4>
				<a href="input.php" class="st-button">人気順</a><br>-->

				<h2 id="review">おもいで</h2>
				<a href="input.php" class="st-button">記録する</a>
				<a href="view.php" class="st-button">ふりかえる</a>
			</div>
		</div>
	</div>
	<?php require __DIR__ . '/footer.php'; ?>
</body>

</html>