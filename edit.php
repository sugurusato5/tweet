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



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $conntent = $_POST['conntent'];
    $created_at = $_POST['created_at'];
    $errors = [];

    if ($conntent == $tweet['conntent']) {
        $errors['conntent'] = '内容が変更されていません';
    }

    if ($conntent == '') {
        $errors['conntent'] = '入力されていません';
    }

    if (!$errors) {
        $dbh = connectDb();
        $sql = 'UPDATE tweets SET conntent = :conntent, created_at = CURRENT_TIMESTAMP WHERE id = :id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':conntent', $conntent, PDO::PARAM_STR);
        $stmt->execute();
        header('Location: index.php');
        exit;
    }
}


?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>編集</title>
</head>
<body>
    <h1>tweetの編集</h1>
    <?php if($errors) : ?>
        <ul class="error-list">
            <?php foreach($errors as $error) : ?>
            <li>
                <?= h($error) ?>
            </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <form action="" method="post">
        <div>
            <label for="conntent">本文</label><br>
            <textarea name="conntent" id="" cols="30" rows="5" placeholder="いまどうしてる？"><?= h($tweet['conntent']) ?></textarea>
        </div>
        <div>
            <input type="submit" value="編集する">
        </div>
    </form>
</body>
</html>