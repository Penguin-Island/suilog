<?php
require(__DIR__ . '/dbconnect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['n-username']) || empty($_POST['n-password'])) {
        http_response_code(400);
        echo '登録失敗';
        exit;
    }
    $stmt = $db->prepare('SELECT * FROM users WHERE username=?', array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $stmt->bindValue(1, $_POST['n-username']);
    $stmt->execute();
    $result = $stmt->fetch();
    if ($result === false) {
        if (preg_match('/^(?=.*[A-Z])(?=.*?\d)[a-zA-Z0-9]{8,100}$/', $_POST['n-password'])) {
            $stmt = $db->prepare('INSERT INTO users (username, pass) VALUES (:username, :pass)');
            $stmt->bindValue(':username', $_POST['n-username']);
            $stmt->bindValue(':pass', password_hash($_POST['n-password'], PASSWORD_DEFAULT));
            $stmt->execute();
            header('Location: index.php');
        } else {
            echo 'パスワードは8文字以上100字以下、大文字アルファべットを少なくとも1つ、半角英数字の両方が含まれているもののみ使用できます。';
            exit;
        }
    } else {
        echo 'そのユーザーネームは使用できません';
        exit;
    }
}
?>

<!DOCTYPE HTML>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/member.css">
    <title>新規登録 | すいログ</title>
</head>

<body>
    <?php
    require(__DIR__ . '/header.php');
    ?>
    <div class="container">
        <div class="spacer"></div>
        <h1>新規登録（無料）</h1>
        <form method="POST">
            <div>
                <label for="username">ユーザー名</label>
                <input type="text" id="n-username" name="n-username">
            </div>
            <div>
                <label>パスワード</label>
                <input type="password" id="n-password" name="n-password" minlength="8">
                <input class="log-submit" type="submit" value="登録">
            </div>
        </form>
    </div>
</body>

</html>