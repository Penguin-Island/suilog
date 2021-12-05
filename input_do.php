<?php
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

    try {
        $db = new PDO('mysql:dbname=place;host=127.0.0.1;charset=utf8', 'root', 'yz2576zs');

        $db->exec('INSERT INTO places SET place="' . $_POST['name'] . '", review="' . $_POST['memo'] . '", created_at=NOW()');
    } catch (PDOException $e) {
        echo 'DB接続エラー: ' . $e->getMessage();
    }

    ?>
    </pre>
</body>

</html>