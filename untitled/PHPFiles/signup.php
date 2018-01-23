<?php
session_start();
//$_SESSIONが使えるようになる。リダイレクトされた時の入力フォーム保持
$host = 'localhost'; //DBのサーバーURL
$user = 'root';
$password = '';
$dbname = 'sns2';
$dsn = "mysql:host={$host},dbname={$dbname},charset=utf8";
$_SESSION=[];//セッション変数の初期化
$errorMessage = "";//エラーメッセージの初期化
//項目全入力
if (isset($_POST["signUpForm"])){   //ボタンが押されたとき
    if(empty($_POST["userid"])//全項目入力
        || empty($_POST["familyname"])
        || empty($_POST["firstname"])
        || empty($_POST["sex"])
        || empty($_POST["mail"])
        || empty($_POST["college"])
        || empty($_POST["default_group"])
        || empty($_POST["pass"])
        || empty($_POST["repass"])){
        $errorMessage="未入力の項目があります";
        }elseif ($_POST["pass"]==$_POST["repass"]){  //パスワード確認
            $_SESSION["userid"]=$_POST["userid"];
            $_SESSION["familyname"]=$_POST["familyname"];
            $_SESSION["firstname"]=$_POST["firstname"];
            $_SESSION["sex"]=$_POST["sex"];
            $_SESSION["mail"]=$_POST["mail"];
            $_SESSION["college_id"]=$_POST["college"];
            $_SESSION["group"]=$_POST["default_group"];
            $_SESSION["pass"]=$_POST["pass"];
            //リダイレクト処理
            //ファイルパスを運用環境のURLに変換
            $url="http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
            header("Location:". $url . "/signup_preview.php");
            exit();//遷移
        }else{
        $errorMessage="パスワードを確認してください";
    }
}
?>

<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>新規登録</title>
</head>
<body>
<h1>新規登録画面</h1>

<form id="signUpForm" name="signUpForm" action="signup.php" method="POST">
    <fieldset>
        <legend>登録情報</legend>
        <div><font color="#ff0000"><?php if (!empty($errorMessage)){
                    echo $errorMessage;
                }?></font></div>
        <p>
            <label for="userid">ユーザーID:</label>
            <input type="text" id="userid" name="userid" value="<?php
                if (isset($_POST["userid"])){
                    echo $_POST["userid"];
                }?>" placeholder="例：k015c9999">
        </p>

        <p>
            <label for="name">名前:</label>
            <input type="text" id="familyname" name="familyname" value="<?php
            if (isset($_POST["familyname"])){
                echo $_POST["familyname"];
            }?>" placeholder="姓">
            <input type="text" id="firstname" name="firstname" value="<?php
            if (isset($_POST["firstname"])){
                echo $_POST["firstname"];
            }?>" placeholder="名">
        </p>

        <p>
            <label for="sex">性別:</label>
            <input type="radio" id="sex" name="sex" value="男">男性
            <input type="radio" id="sex" name="sex" value="女">女性
        </p>

        <p>
            <label for="mail">メールアドレス:</label>
            <input type="text" id="mail" name="mail" value="<?php
            if (isset($_POST["mail"])){
                echo $_POST["mail"];
            }?>" placeholder="例：k015c9999@it-neec.jp">
        </p>

        <p>
            <label for="college">カレッジ:</label>
            <select name="college">
                <option value="noselect"></option>
                <option value="1">ITカレッジ</option>
            </select>
        </p>

        <p>
            <label for="default_group">クラス:</label>
            <select name="default_group">
                <option value="noselect"></option>
                <option value=>IS-09-01</option>
            </select>
        </p>

        <p>
            <label for="pass">パスワード設定:</label>
            <input type="password" id="pass" name="pass" value="" placeholder="パスワードを入力してください">
            <br>
            <label for="pass">パスワード確認:</label>
            <input type="password" id="repass" name="repass" value="" placeholder="パスワードを再入力してください">
        </p>
        <input type="submit" id="signUpForm" name="signUpForm" value="確認">

    </fieldset>
</form>

<form action="login.php">
    <input type="submit" id="back" name="back" value="戻る">
</form>

<form action="">
    <input type="submit" id="signUp" name="signUp" value="GO">
</form>
</body>
</html>

