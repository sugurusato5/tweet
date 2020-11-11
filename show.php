<?php 

//設定ファイルと関数ファイルを読み込み
require_once('config.php');
require_once('functions.php');

//idの受け取り
$id = $_GET['id'];

// データベース接続
$dbh = connectDb();

// SQLの準備
$sql = 'SELECT * FROM tweets WHERE id = :id';

//プリペアードステートメントの準備
$stmt = $dbh->prepare($sql);
// パラメータのバインド
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
//プリペアードステートメントの実行
$stmt->execute();


$tweet = $stmt->fetch(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ツイート詳細</title>
</head>
<body>
    <h1><?= h($tweet['contennt']) ?></h1>
    <a href="inde.php">戻る</a>
    <ul>
        <li>
            [#<?= h($tweet['id']) ?>]
            <?= h($tweet['conntent']) ?><br>
            投稿日時:<?= h($tweet['created_at']) ?>
            <a href="edit.php?id=<?= h($tweet['id']) ?>">[編集]</a>
            <a href="delete.php?id=<?= h($tweet['id']) ?>">[削除]</a>
            <hr>
        </li>
    </ul>
</body>
</html>