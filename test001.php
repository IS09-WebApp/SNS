<?php
//session_start();
$host = 'localhost'; //DBのサーバーURL
$user = 'root';//データベースユーザー
$password = "";//パスワード
$dbname = 'sns2';//接続DB
$dsn = "mysql:host={$host};dbname={$dbname};charset=utf8";
$errorMessage = "";//エラーメッセージの初期化
try{        //--------------↓DB接続処理↓---------------
    $pdo = new PDO($dsn, $user, $password);
//プリアドステートメントのエミュレーションを無効化する
    $pdo -> setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
    //例外がスローされる設定にする
    $pdo ->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    echo "データベース{$dbname}に接続しました","<br>";
            //--------------↑接続完了↑-----------------
            //--------------↓以下お好きに↓---------------
    $sql="INSERT test VALUES(1,'野獣洗米')";
//プリペアステートメントを作る
    $stm=$pdo->prepare($sql);
    $stm->execute();
    $sql="SELECT * FROM test";
//プリペアステートメントを作る
    $stm=$pdo->prepare($sql);
    $stm->execute();
    $result=$stm->fetchAll(PDO::FETCH_ASSOC);
    echo "<table>";
    echo "<thread><tr>";
    echo "<th>","ID","</th>";
    echo "<th>","名前","</th>";
    echo "</tr></thread>";

    echo "<tbody>";
    foreach ($result as $row){
        echo "<tr>";
        echo "<td>", $row['id'],"</td>";
        echo "<td>", $row['name'],"</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
}catch(Exception $e){
    echo '<span class="error">失敗</span>';
    echo $e -> $errorMessage();
    exit();
}

?>
