<?php
session_start();
require '../dbconnect.php';

// 不正遷移制御
// sign.phpから来ていない場合、signup.phpに強制遷移させる
if (!isset($_SESSION['51_LearnSNS'])) {
    header('Location: signup.php');
    exit();
}

// echo '<pre>';
// var_dump($_SESSION);
// echo '</pre>';

$name = $_SESSION['51_LearnSNS']['name'];
$email = $_SESSION['51_LearnSNS']['email'];
$password = $_SESSION['51_LearnSNS']['password'];
$img_name = $_SESSION['51_LearnSNS']['img_name'];

if (!empty($_POST)) {
    $sql = 'INSERT INTO `users` (`name`, `email`, `password`, `img_name`, `created`) VALUES(?, ?, ?, ?, NOW())';
    $data = [$name, $email, password_hash($password, PASSWORD_DEFAULT), $img_name];
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    // セッション情報の破棄
    unset($_SESSION['51_LearnSNS']);
    // 作成完了ページへ遷移
    header('Location: thanks.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>Learn SNS</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../assets/font-awesome/css/font-awesome.css">
</head>
<body style="margin-top: 60px">
    <div class="container">
        <div class="row">
            <div class="col-xs-8 col-xs-offset-2 thumbnail">
                <h2 class="text-center content_header">アカウント情報確認</h2>
                <div class="row">
                    <div class="col-xs-4">
                        <img src="../user_profile_img/<?php echo $img_name; ?>" class="img-responsive img-thumbnail">
                    </div>
                    <div class="col-xs-8">
                        <div>
                            <span>ユーザー名</span>
                            <p class="lead"><?php echo htmlspecialchars($name); ?></p>
                        </div>
                        <div>
                            <span>メールアドレス</span>
                            <p class="lead"><?php echo htmlspecialchars($email); ?></p>
                        </div>
                        <div>
                            <span>パスワード</span>
                            <p class="lead">●●●●●●●●</p>
                        </div>
                        <form method="POST" action="check.php">

                            <!-- ?action=rewrite ?キー = 値
                                signup.phpに戻るで遷移したことがわかるようにパラメータを付与している -->
                            <a href="signup.php?action=rewrite" class="btn btn-default">&laquo;&nbsp;戻る</a> | 
                            <!-- 
                                if(!empty($_POST))
                             -->
                            <input type="hidden" name="action" value="submit">
                            <input type="submit" class="btn btn-primary" value="ユーザー登録">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/js/jquery-3.1.1.js"></script>
    <script src="../assets/js/jquery-migrate-1.4.1.js"></script>
    <script src="../assets/js/bootstrap.js"></script>
</body>
</html>