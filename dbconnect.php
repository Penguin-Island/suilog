<?php
require ( __DIR__ . '/config.php');
try{
    $db = new PDO($datasource, $user, $password);
} catch (PDOException $e) {
    echo 'DB接続エラー: ' . $e->getMessage();
}
?>