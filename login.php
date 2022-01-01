<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['username'], $_POST['password'])) {
        http_response_code(400);
        exit();
    }
    try {
        $db = new PDO('mysql:dbname=place;host=127.0.0.1;charset=utf8', 'root', 'yz2576zs');
        $stmt = $db->prepare('SELECT password FROM users WHERE username=?', array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->bindValue(1, $_POST['username']);
        $stmt->execute();
        $result = $stmt->fetch();
        if ($result === false) {
            echo 'ログイン失敗';
            exit;
        } else {
            password_verify($_POST['password'], $result['password']);
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
    <title>ログイン 【すいログ】</title>
</head>

<body>
    <div class="login-back">
        <div class="container">
            <div class="card">
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