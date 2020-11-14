<?php 

// 設定ファイルと関数ファイルの読み込み
require_once('config.php');
require_once('functions.php');

//getmethodでid,good取得
$id = $_GET['id'];
$good = $_GET['good'];
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

$sql_good = 'UPDATE tweets SET good = :good WHERE id = :id';
$stmt_good = $dbh->prepare($sql_good);
$stmt_good->bindParam(':good', $good, PDO::PARAM_BOOL);
$stmt_good->bindParam(':id', $id, PDO::PARAM_INT);
$stmt_good->execute();
header('Location: index.php');


