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
    <title>tweet</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <h1><?= h($tweet['conntent']) ?></h1>
    <a href="index.php">戻る</a>
    <ul class="list-none">
        <li>
            [#<?= h($tweet['id']) ?>]
            <?= h($tweet['conntent']) ?><br>
            投稿日時:<?= h($tweet['created_at']) ?>
            <?php if($tweet['good'] == '0') : ?>
                <a class="good-link" href="good.php?id=<?= h($tweet['id']) ?>">☆</a>
            <?php else : ?>
                <a class="bad-link" href="good.php?id=<?= h($tweet['id']) ?>">★</a>
            <?php endif; ?>
            <a href="edit.php?id=<?= h($tweet['id']) ?>">[編集]</a>
            <a href="delete.php?id=<?= h($tweet['id']) ?>">[削除]</a>
            <hr>
        </li>
    </ul>
</body>
</html>