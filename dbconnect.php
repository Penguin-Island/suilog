<?php
try{
    $db = new PDO('mysql:dbname=place;host=127.0.0.1;charset=utf8', 'root', 'yz2576zs');
} catch (PDOException $e) {
    echo 'DB接続エラー: ' . $e->getMessage();
}
?>