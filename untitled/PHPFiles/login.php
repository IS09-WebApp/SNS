<?php
session_start();
//require  'password.php';
$host = 'localhost'; //DBのサーバーURL
$user = 'root';//データベースユーザー
$password = "";//パスワード
$dbname = 'sns3';//接続DB
$dsn = "mysql:host={$host};dbname={$dbname};charset=utf8";
//エラーメッセージの初期化
$errorMessage = "";
if(isset($_POST["loginForm"])){
    if (empty($_POST["userid"]) || empty($_POST["pass"])) {       //emptyは値が空の時
        $errorMessage = "未入力の項目があります";
    }else{//ユーザーIDとパスワードが入力されていたら認証する
            //include_once 'login.php';//'Login.php'へ遷移
            try { //ログイン処理
                $pdo = new PDO($dsn, $user, $password);
                //プリアドステートメントのエミュレーションを無効化する
                $pdo -> setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
                //例外がスローされる設定にする
                $pdo ->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                $sql="SELECT * FROM user_login WHERE id=:userid AND pass=:pass";
                //プリペアドステートメントを作る
                $stm=$pdo->prepare($sql);
                //プレースホルダーに値をバインドする
                $stm -> bindValue(':userid',"{$_POST["userid"]}",PDO::PARAM_STR);
                $stm -> bindValue(':pass',"{$_POST["pass"]}",PDO::PARAM_STR);
                if ($stm->execute()){
                    //レコードを取り出す
                    $result=$stm->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $row) {
                        if (isset($row)) {
                            echo "成功";
                            $sql="SELECT * FROM user_detail WHERE id=:userid";
                            //プリペアドステートメントを作る
                            $stm=$pdo->prepare($sql);
                            //プレースホルダーに値をバインドする
                            $stm -> bindValue(':userid',"{$_POST["userid"]}",PDO::PARAM_STR);
                            $stm->execute();
                            //ユーザ情報を取得
                            $result=$stm->fetchAll(PDO::FETCH_ASSOC);
                            $_SESSION["loginuser"]=$result;
                            //リダイレクト処理
                            //ファイルパスを運用環境のURLに変換
                            $url = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
                            header("Location:" . $url . "/mypage.php");//「signup.php」へ遷移
                            exit();
                        }
                    }
                }

                $errorMessage = "ユーザIDもしくはパスワードが違います";
            }catch(PDOException $e) {
                //$erromessage = $sql
                // $e->getMessage()　でエラー内容を参照可能(デバッグ時のみ表示)
                echo $e->getMessage();
            }
    }
}
?>
<!doctype html>
<html>
    <head>
            <meta charset="UTF-8">
        <title>ログイン</title>>
    </head>
<body>
<h1>ログイン画面</h1>
<form id="loginForm" name="loginForm" action="login.php" method="POST">
    <fieldset>
        <legend>ログインフォーム</legend>
        <div><font color="#ff0000"><?php if (!empty($errorMessage)) {echo htmlspecialchars($errorMessage, ENT_QUOTES);} ?></font></div>
        <label for="userid">ユーザーID:</label><input type="text" id="userid" name="userid" placeholder="ユーザーIDを入力" value="<?php if (!empty($_POST["userid"])) {echo htmlspecialchars($_POST["userid"], ENT_QUOTES);} ?>">
        <br>
        <label for="password">パスワード:</label><input type="password" id="pass" name="pass" value="" placeholder="パスワードを入力">
        <br>
        <input type="submit" id="loginForm" name="loginForm" value="ログイン">

    </fieldset>
</form>
<br>
<form action="signup.php">
    <fieldset>
        <legend>新規登録フォーム</legend>
        <input type="submit" value="新規登録">
    </fieldset>
</form>
</body>
</html>