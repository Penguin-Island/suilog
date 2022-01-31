<?php
session_start();
require(__DIR__ . '/check.php');
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="css/style.css">
  <title>おもいでをふりかえる | すいログ</title>
</head>

<body>
  <?php require __DIR__ . '/header.php'; ?>

  <div class="wave">
    <div class="container">
      <div class="spacer"></div>

      <h2>思い出をみる</h2>

      <?php
      $cnt = $db->prepare('SELECT COUNT(*) AS record_count FROM places WHERE userid=?');
      $cnt->bindValue(1, $_SESSION['id']);
      $cnt->execute();
      $cntresult = $cnt->fetch();
      ?>
      
      <article>
        <h4>思い出 <?= $cntresult['record_count'] ?>つ</h4>
      </article>

      <div class="grad-wrap">
        <input id="trigger1" class="grad-trigger" type="checkbox">
        <label class="grad-btn" for="trigger1"></label>
        <div class="grad-item">
          <div class="all-form">
            <?php
            $plc = $db->prepare('SELECT * FROM places WHERE userid=? ORDER BY id DESC');
            $plc->bindValue(1, $_SESSION['id']);
            $plc->execute();
            ?>

            <article>
              <?php while ($plcresult = $plc->fetch()) : ?>
                <p><?= $plcresult['place'] ?></p>
                <p><?= $plcresult['review'] ?></p>
                <p><?= $plcresult['created_at'] ?></p>
                <hr>
              <?php endwhile; ?>
            </article>
          </div>
        </div>
      </div>

    </div>
  </div>

  <?php require __DIR__ . '/footer.php'; ?>
</body>

</html>