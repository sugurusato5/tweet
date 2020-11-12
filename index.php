<?php 

//設定ファイルと関数ファイルを読み込み
require_once('config.php');
require_once('functions.php');

// データベース接続
$dbh = connectDb();
// SQLの準備
$sql = 'SELECT * FROM tweets ORDER BY created_at DESC';
//プリペアードステートメントの準備
$stmt = $dbh->prepare($sql);
//プリペアードステートメントの実行
$stmt->execute();
// $tweetsに連想配列の形式で記事データを格納する
$tweets = $stmt->fetchAll(PDO::FETCH_ASSOC);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conntent = $_POST['conntent'];
    $errors = [];

    // バリデーション
    if ($conntent == '') {
        $errors['conntent'] = 'ツイート内容を入力してください。';
    }

    //バリデーション突破後の処理
    if(!$errors) {
        //データの追加
        $dbh = connectDb();
        $sql = 'INSERT INTO tweets (conntent) VALUES (:conntent)';
        $stmt = $dbh->prepare($sql);
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
    <title>新規tweet</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Tweet</h1>
    <?php if($errors) : ?>
        <ul class="error-list">
            <?php foreach($errors as $error) : ?>
                <li >
                    <?= h($error) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <form action="" method="post">
        <div>
            <label for="conntent">ツイート内容</label><br>
            <textarea name="conntent" id="" cols="30" rows="4" placeholder="いまどうしてる？"></textarea>
        </div>
        <br>
        <div>
            <input type="submit" value="投稿する">
        </div>
    </form>
    <h1>Tweet一覧</h1>
    <?php  if($tweets) : ?>
        <ul class="line-none list-none">
        <?php foreach($tweets as $tweet) : ?>
            <li>
                <a class="list-none" href="show.php?id=<?= h($tweet['id']) ?>"><?= h($tweet['conntent']) ?></a>
                <br>
                投稿日時:<?= h($tweet['created_at']) ?>
                <?php if($tweet['good'] == '0') : ?>
                    <a class="good-link" href="good.php?id=<?= h($tweet['id']) ?>">☆</a>
                <?php else : ?>
                    <a class="bad-link" href="good.php?id=<?= h($tweet['id']) ?>">★</a>
                <?php endif; ?>
                <hr>
            </li>
        <?php endforeach; ?>
        </ul>
    <?php else : ?>
        <p>投稿されたtweetはありません</p>
    <?php endif; ?>
</body>
</html>