<?php
session_start();
foreach ($_SESSION["loginuser"] as $row){
    echo "<table>";
    echo "<tbody>";
    echo "<tr>";    //$row['～']=取り出したテーブルの要素なので要確認
    echo "<td>", $row['id'],"</td>";
    echo "<td>", $row['familyname'],"</td>";
    echo "<td>", $row['firstname'],"</td>";
    echo "<td>", $row['sex'],"</td>";
    echo "<td>", $row['mail'],"</td>";
    echo "<td>", $row['college_id'],"</td>";
    echo "<td>", $row['group_id'],"</td>";
    echo "<td>", $row['prof'],"</td>";
    echo "<td>", $row['picture'],"</td>";
    echo "</tr>";
    echo "</tbody>";
    echo "</table>";
}
?>