<?php
session_start();
require(__DIR__ . '/dbconnect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['username']) || empty($_POST['password'])) {
        http_response_code(400);
        echo 'ログイン失敗';
        exit;
    }
    $stmt = $db->prepare('SELECT pass FROM users WHERE username=?', array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $stmt->bindValue(1, $_POST['username']);
    $stmt->execute();
    $result = $stmt->fetch();
    if ($result === false) {
        echo 'ログイン失敗';
        exit;
    } else {
        if (password_verify($_POST['password'], $result['pass'])) {
            $_SESSION['id'] = $result['id'];
            $_SESSION['time'] = time();
            header('Location: index.php');
        } else {
            echo 'ログイン失敗';
            exit;
        }
    }
}
?>

<!DOCTYPE HTML>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <title>ログイン 【すいログ】</title>
</head>

<body>
    <div class="login-back">
        <div class="container">
            <div class="card">
                <h1>ログイン</h1>
                <form method="POST">
                    <label for="username">ユーザー名</label>
                    <input type="text" id="username" name="username">
                    <label>Password</label>
                    <input type="text" id="password" name="password" minlength="8">
                    <input class="log-submit" type="submit" value="ログイン">
                </form>
            </div>
        </div>
    </div>
</body>

</html>