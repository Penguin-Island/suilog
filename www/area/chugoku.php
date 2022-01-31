<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/style.css">
    <title>中国エリアの水族館【すいログ】</title>
</head>

<body>
  <?php require __DIR__ . '/../header.php'; ?>
  <?php
  $json = file_get_contents(__DIR__ . '/json/chug.json');
  $arr = json_decode($json, true); ?>
  <?php
  require(__DIR__ . '/../dbconnect.php');
  $stmt = $db->prepare('SELECT * FROM places WHERE place = ? ORDER BY id DESC', array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
  ?>

  <div class="wave">
    <div class="back">
      <div class="container">
        <div class="spacer"></div>
        <?php
        foreach ($arr as $data) {
        ?>
          <h2><?= $data['prefecture'] ?></h2>
          <?php
          foreach ($data['aquariums'] as $detail) {
          ?>
            <h3><a href="<?= $detail['url'] ?>" target="_blank" rel="noopener noreferrer"><?= $detail['name'] ?></a></h3>
            <div class="basho">
              <div class="detail">
                <iframe src="<?= $detail['map'] ?>" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                <p><?= $detail['address'] ?></p>
              </div>
            </div>
          <?php
          }
          ?>
        <?php
        }
        ?>
      </div>
    </div>
  </div>
  <?php require __DIR__ . '/../footer.php'; ?>
</body>

</html>