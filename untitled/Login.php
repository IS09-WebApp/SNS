<?php
require  'password.php';
session_start();
$db['host'] = "localhost"; //DBのサーバーURL
$db['user'] = "root";
$db['pass'] = "";
$db['dbname'] = "db1";
   // $link = mysqli_connect('localhost','root','');
    $erroMessage = "";//エラーメッセージの初期化

    if(isset($_POST["login"])){         //ログインボタンが押された場合
        if (empty($_POST["id"])){       //emptyは値が空の時
            $erroMessage = 'ユーザーIDが未入力です。';
        }else if(empty($_POST["password"])){
            $erroMessage = 'パスワードが未入力です。';
        }

        if (!empty($_POST["id"]) && !empty($_POST["password"])) {
            $id = $_POST["id"];//入力したユーザーIDを格納
            //ユーザーIDとパスワードが入力されていたら認証する
            $dsn = sprintf('mysql; host=%s; dbname=%s; charset=utf8',$db['host'],$db ['dbname']);

            try { //ここからエラー処理
                $pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
                $stmt = $pdo->prepare('SELECT * FROM student WHERE id = ?');
                $stmt->execute(array($id));
                $password = $_POST["password"];

                if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    if ($password_verify($password, $row['password'])) {
                        session_regenerate_id(true);

                        //入力したIDのユーザー名を取得
                        $id = $row['id'];
                        $sql = "SELECT * FROM student WHERE id = $id";//入力したIDからユーザー名を取得
                        $stmt = $pdo->query($sql);
                        foreach ($stmt as $row) {
                            $row['name'];
                        }
                        $_SESSION["NAME"] = $row['name'];
                        header("Location: Main.php");
                        exit();
                    } else {
                        //処理失敗
                        $erroMessage = 'ユーザIDあるいはパスワードに誤りがあります。';
                    }
                } else {
                    //認証成功なら、セッションIDを新規に発行する
                    //該当データなし
                    $erroMessage = 'ユーザIDあるいはパスワードに誤りがあります。';
                }
                } catch(PDOException $e) {
                $erroMessage = 'データベースエラー';
                //$erromessage = $sql
                // $e->getMessage()　でエラー内容を参照可能(デッバク時のみ表示)
                // echo $e->getMessage();
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
<form id="loginForm" name="loginForm" action="" method="POST">
    <fieldset>
        <legend>ログインフォーム</legend>
        <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
        <label for="userid">ユーザーID</label><input type="text" id="userid" name="userid" placeholder="ユーザーIDを入力" value="<?php if (!empty($_POST["userid"])) {echo htmlspecialchars($_POST["userid"], ENT_QUOTES);} ?>">
        <br>
        <label for="password">パスワード</label><input type="password" id="password" name="password" value="" placeholder="パスワードを入力">
        <br>
        <input type="submit" id="login" name="login" value="ログイン">
    </fieldset>
</form>
<br>
<form action="SignUp.php">
    <fieldset>
        <legend>新規登録フォーム</legend>
        <input type="submit" value="新規登録">
    </fieldset>
</form>
</body>
</html>