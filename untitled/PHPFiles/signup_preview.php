<?php
session_start();
$host = 'localhost'; //DBのサーバーURL
$user = 'root';
$password = '';
$dbname = 'sns2';
$dsn = "mysql:host={$host},dbname={$dbname},charset=utf8";
$errorMessage = "";//エラーメッセージの初期化
//DB接続処理
try {
    $pdo = new PDO($dsn, $user, $password);
    //プリアドステートメントのエミュレーションを無効化する
    $pdo -> setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
    //例外がスローされる設定にする
    $pdo ->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    //プレースホルダを使ったSQL文(「:」はプレースホルダー)
    $sql="INSERT user_detail VALUES(':userid',':familyname',':firstname',':sex',':mail',':college',':group','','')";
    //プリペアドステートメントを作る
    $stm=$pdo->prepare($sql);
    //プレースホルダーに値をバインドする
    $stm -> bindValue(':userid',"{$_SESSION["userid"]}",PDO::PARAM_STR);
    $stm -> bindValue(':familyname',"{$_SESSION["familyname"]}",PDO::PARAM_STR);
    $stm -> bindValue(':firstname',"{$_SESSION["firstname"]}",PDO::PARAM_STR);
    $stm -> bindValue(':sex',"{$_SESSION["sex"]}",PDO::PARAM_STR);
    $stm -> bindValue(':mail',"{$_SESSION["mail"]}",PDO::PARAM_STR);
    $stm -> bindValue(':college',"{$_SESSION["college"]}",PDO::PARAM_INT);
    $stm -> bindValue(':group',"{$_SESSION["default_group"]}",PDO::PARAM_STR);
    $stm -> bindValue(':pass',"{$_SESSION["pass"]}",PDO::PARAM_STR);
    if ($stm -> execute()){
        //追加後のレコードを確認する
        $sql="SELECT * FROM user_detail";
        //プリペアステートメントを作る
        $stm=$pdo->prepare($sql);
        $stm -> execute();
        //レコードを取り出す
        $result=$stm->fetchAll(PDO::FETCH_ASSOC);
        echo "<table>";
        echo "<thread><tr>";
        echo "<th>","ID","</th>";
        echo "<th>","名前","</th>";
        echo "<th>","性別","</th>";
        echo "<th>","メール","</th>";
        echo "<th>","パスワード","</th>";
        echo "</tr></thread>";
        echo "<tbody>";
        foreach ($result as $row){
            echo "<tr>";
            echo "<td>", $row['id'],"</td>";
            echo "<td>", $row['name'],"</td>";
            echo "<td>", $row['sex'],"</td>";
            echo "<td>", $row['mail'],"</td>";
            echo "<td>", $row['pass'],"</td>";
            echo "</tr>";
            }
            echo "</tbody>";
        echo "</table>";
        }
}catch(PDOException $e) {
     $errorMessage = 'データベースエラー';
     $e->getMessage();//　でエラー内容を参照可能(デッバク時のみ表示)
    echo $e->getMessage();
    //include('Login.php');
}
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>登録確認</title>
</head>
<body>
<h1>新規登録確認</h1>
<form id="signUpPreview" name="signUpPreview" action="signup_preview.php">
    <fieldset>
        <legend>以下の内容で登録します</legend>
        <p>
            <label>ユーザID：<?php echo $_SESSION["userid"]?></label>
        </p>
        <p>
            <label>姓：<?php echo $_SESSION["familyname"]?></label>
        </p>
        <p>
            <label>名：<?php echo $_SESSION["firstname"]?></label>
        </p>
        <p>
            <label>性別：<?php echo $_SESSION["sex"]?></label>
        </p>
        <p>
            <label>メールアドレス：<?php echo $_SESSION["mail"]?></label>
        </p>
        <p>
            <label>カレッジ：<?php echo $_SESSION["college"]?></label>
        </p>
        <p>
            <label>クラス：<?php echo $_SESSION["default_group"]?></label>
        </p>
        <p>
            <label>パスワード：非表示</label>
        </p>
        <input type="submit" id="signUpForm" name="GO" value="登録">
    </fieldset>
</form>
<form action="signup.php">
    <input type="submit" id="signUpForm" name="back" value="戻る">
</form>
</body>
</html>