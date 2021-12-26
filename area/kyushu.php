<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../css/style.css">
  <title>九州・沖縄エリアの水族館【すいログ】</title>
</head>

<body>
  <?php require __DIR__ . '/../header.php'; ?>
  <?php
  $json = file_get_contents(__DIR__ . '/area.json');
  $arr = json_decode($json, true); ?>

  <div class="wave">
    <div class="container">
      <?php
      foreach ($arr as $data) {
      ?>
        <h2><?= $data['prefecture'] ?></h2>
        <?php
        foreach ($data['aquariums'] as $detail) {
        ?>
          <div class="basho">
            <h3><?= $detail['name'] ?></h3>
            <p></p>
            <p>HP：<a href="<?= $detail['url'] ?>"> <?= $detail['url'] ?></a></p>
            <p>所在地：<?= $detail['address'] ?></p>
            <iframe src="<?= $detail['map'] ?>" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
          </div>
        <?php
        }
        ?>
      <?php
      }
      ?>
    </div>
  </div>

  <?php require __DIR__ . '/../footer.php'; ?>
</body>

</html>

<!-- <div class="basho">
        <h3></h3>
        <p></p>
        <p>HP：<a href=></a></p>
        <p>所在地：</p>
      </div> -->