<?php 

// 設定ファイルと関数ファイルの読み込み
require_once('config.php');
require_once('functions.php');

//getmethodでid取得
$id = $_GET['id'];
// データベース接続
$dbh = connectDb();
$sql = 'SELECT * FROM tweets WHERE id = :id';
//プリペアードステートメントの準備
$stmt = $dbh->prepare($sql);
// パラメータのバインド
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
//プリペアードステートメントの実行
$stmt->execute();
$tweet = $stmt->fetch(PDO::FETCH_ASSOC);

if ($tweet['good'] == '0') {
        $dbh = connectDb();
        $sql = 'UPDATE tweets SET `good` = 1 WHERE id = :id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        header('Location: index.php');
        exit;
} else {
        $dbh = connectDb();
        $sql = 'UPDATE tweets SET `good` = 0 WHERE id = :id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        header('Location: index.php');
        exit;
}

