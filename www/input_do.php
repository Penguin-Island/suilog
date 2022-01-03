<?php
session_start();
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
	$stmt = $db->prepare('INSERT INTO places (userid, place, date, review, created_at) VALUES (:userid, :place, :date, :review, NOW())');
    $stmt->bindValue(':userid', $_SESSION['id']);
    $stmt->bindValue(':place', $_POST['name']);
    $stmt->bindValue(':date', $_POST['date']);
    $stmt->bindValue(':review', $_POST['memo']);
    $stmt->execute();
    ?>
    </pre>
</body>

</html>