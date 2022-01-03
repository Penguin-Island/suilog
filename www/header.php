<?php
if( !empty($_GET['btn_logout']) ) {
	unset($_SESSION['id']);
    header('Location: login.php');
	exit;
}
?>

<header>
    <h1 class="title"><a href="/suilog/" class="title-a">すいログ</a></h1>
    <nav class="nav">
        <ul class="menu-group">
            <li class="menu-item"><a href="www/" class="menu-item-a">Top</a></li>
            <li class="menu-item"><a href="www/#srch" class="menu-item-a">さがす</a></li>
            <li class="menu-item"><a href="www/#review" class="menu-item-a">おもいで</a></li>
        </ul>
    </nav>

    <form action="" method="get">
        <input class="head-search" type="text" name="search" value="">
        <button class="head-submit"><i class="bi bi-search"></i></button>
    </form>

    <ul class="login-group">
        <li class="login-item"><a href="login.php" class="login-item-a">ログイン</a></li>
        <li class="login-item"><a href="regist.php" class="login-item-a">新規登録</a></li>
        <li class="login-item"><form method="get" action="">
    <input type="submit" name="btn_logout" value="ログアウト">
</form></li>
    </ul>
</header>