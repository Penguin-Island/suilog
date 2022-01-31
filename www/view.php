<?php
session_start();
require(__DIR__ . '/check.php');
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/style.css">
  <title>おもいでをふりかえる | すいログ</title>
</head>

<body>
  <?php require __DIR__ . '/header.php'; ?>

  <div class="wave">
    <div class="container">
      <div class="spacer"></div>

      <h2>おもいでをふりかえる</h2>

      <?php
      $cnt = $db->prepare('SELECT COUNT(*) AS record_count FROM places WHERE userid=?');
      $cnt->bindValue(1, $_SESSION['id']);
      $cnt->execute();
      $cntresult = $cnt->fetch();
      ?>

      <div class="all-form">
        <?php
        $plc = $db->prepare('SELECT * FROM places WHERE userid=? ORDER BY id DESC');
        $plc->bindValue(1, $_SESSION['id']);
        $plc->execute();
        ?>

        <article>
          <?php while ($plcresult = $plc->fetch()) : ?>
            <h3><?= $plcresult['place'] ?></h3>
            <p><?= $plcresult['review'] ?></p>
            <p><?= $plcresult['created_at'] ?></p>
            <hr>
          <?php endwhile; ?>
        </article>
      </div>
    </div>
  </div>

  <?php require __DIR__ . '/footer.php'; ?>
</body>

</html>