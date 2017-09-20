<?php
require  'password.php';
session_start();
$db['host'] = "localhost"; //DBのサーバーURL
$db['user'] = "root";
$db['pass'] = "";
$db['dbname'] = "db1";
    $errorMessage = "";//エラーメッセージの初期化


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
    <link href='./css/login.css' rel='stylesheet' type='text/css'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/png" href="./img/icon.png">
    <link href="./css/login.css" rel="stylesheet" type="text/css">
</head>
<body background="#">
<link href="./css/login.css" rel="stylesheet" type="text/css">
<div class="container">
    <div class="row login_box">
        <div class="col-md-12 col-xs-12" align="center">
<!--時間表示            <div class="line"><h3>12 : 30 AM</h3></div> -->
            <div class="outter"><img src="./toonf.jpg" class="image-circle"/></div>   
            <h1>ようこそ</h1>
            <span>なんか</span>
        </div>
        
        <div class="col-md-12 col-xs-12 login_control">
            <from action="#"><!--ログイン後のリンク先指定-->
                <div class="control">
                    <div class="label">Email Address</div>
                    <input type="text" placeholder="ゆい" class="form-control" value=""/>
                </div>
                
                <div class="control">
                     <div class="label">Password</div>
                    <input type="password" placeholder="かおり" class="form-control" value=""/>
                </div>
                <div align="center">
                     <button class="btn btn-orange">LOGIN</button>
                </div>
            </from>
            <p style="text-align:right"> 
                <a href="#" STYLE="text-decoration:blink"> <font color="black" >パスワードを忘れた場合</font></a>
            </style>        
        </div>
    </div>
</div>
</body>
</html>
