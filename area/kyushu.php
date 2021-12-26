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
  <?php
  try {
    $db = new PDO('mysql:dbname=place;host=127.0.0.1;charset=utf8', 'root', 'yz2576zs');
  } catch (PDOException $e) {
    echo 'DB接続エラー: ' . $e->getMessage();
  }
  $stmt = $db->prepare('SELECT review FROM places WHERE place = ? ORDER BY id DESC', array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
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
            <h3><?= $detail['name'] ?></h3>
            <div class="basho">
              <div class="detail">
                <p>HP：<a href="<?= $detail['url'] ?>"> <?= $detail['url'] ?></a></p>
                <p>所在地：<?= $detail['address'] ?></p>
                <iframe src="<?= $detail['map'] ?>" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
              </div>
              <div class="detail-review">
                <h4>みんなのおもいで</h4>
                <?php $stmt->bindValue(1, $detail['name']);
                $stmt->execute();
                while ($result = $stmt->fetch()) { ?>
                  <div class="review-item">
                    <?= htmlspecialchars($result['review'], ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8"); ?>
                  </div>
                <?php
                }
                ?>
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