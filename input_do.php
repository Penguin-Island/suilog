<?php
require ( __DIR__ . '/dbconnect.php');
//input.php からのフォームを受け取る

//POSTの中身を確認する
if (!isset($_POST['name'], $_POST['memo'])) {
    http_response_code(400);
    exit();
}
//var_dump($_POST);
header('Location: input.php');
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
</head>

<body>
    <pre>
    <?php
        $db->exec('INSERT INTO places SET place="' . $_POST['name'] . '", review="' . $_POST['memo'] . '", created_at=NOW()');
    ?>
    </pre>
</body>

</html>