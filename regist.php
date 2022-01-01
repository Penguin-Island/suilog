<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['n-username'], $_POST['n-password'])) {
        http_response_code(400);
        exit();
    }
    try {
        $db = new PDO('mysql:dbname=place;host=127.0.0.1;charset=utf8', 'root', 'yz2576zs');
        $stmt = $db->prepare('SELECT * FROM users WHERE username=?', array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->bindValue(1, $_POST['n-username']);
        $stmt->execute();
        $result = $stmt->fetch();
        if ($result === false) {
            $stmt = $db->prepare('INSERT INTO users (username, pass) VALUES (:username, :pass)');
            $stmt->bindValue(':username', $_POST['n-username']);
            $stmt->bindValue(':pass', password_hash($_POST['n-password'], PASSWORD_DEFAULT));
            $stmt->execute();
        } else {
            echo 'そのユーザーネームは使用できません';
            exit;
        }
    } catch (PDOException $e) {
        echo 'DB接続エラー: ' . $e->getMessage();
    }
    header('Location: index.php');
}
?>

<!DOCTYPE HTML>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <title>新規登録 【すいログ】</title>
</head>

<body>
    <div class="login-back">
        <div class="container">
            <div class="card">
                <h1>新規登録</h1>
                <form method="POST">
                    <label for="username">ユーザー名</label>
                    <input type="text" id="n-username" name="n-username">
                    <label>Password</label>
                    <input type="text" id="n-password" name="n-password" minlength="8">
                    <input class="log-submit" type="submit" value="登録">
                </form>
            </div>
        </div>
    </div>
</body>

</html>