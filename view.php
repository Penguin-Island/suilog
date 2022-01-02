<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <?php require __DIR__ . '/header.php'; ?>

  <div class="wave">
    <div class="container">
      <h2>思い出をみる</h2>
      
      <?php
      require ( __DIR__ . '/dbconnect.php');
      $places = $db->query('SELECT COUNT(id) FROM places');
      ?>

      <article>
      <?php while ($place = $places->fetch()):?>
        <h4>みんなの思い出 <?= $place['COUNT(id)']?>件</h4>
        <?php endwhile; ?>
      </article>
      <div class="grad-wrap">
    <input id="trigger1" class="grad-trigger" type="checkbox">
    <label class="grad-btn" for="trigger1"></label>
    <div class="grad-item">

      <div class="all-form">
      <?php
      $places = $db->query('SELECT * FROM places ORDER BY id DESC');
      ?>

      <article>
      <?php while ($place = $places->fetch()):?>
        <p><?= $place['place']?></p>
        <p><?= $place['review']?></p>
        <p><?= $place['created_at']?></p>
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