<?php
$link = mysqli_connect('localhost','root','root');
if($link) {
    die('接続失敗です');
}
    $close_flag = mysqli_close($link);
   if($close_flag){
       die('接続完了');
}
$link->close();
?>