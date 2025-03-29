<?php
    include "db-bind2.php";

    $returncode = 200;
    $nextweek = getWaktuNowAdd("+7 days");
    $username=""; if(isset($_POST["username"])){$username=$_POST["username"];}
    $password=""; if(isset($_POST["password"])){$password=$_POST["password"];}
    header("Content-Type: application/json");
    
    /*$sql = "select * from cv_chatid where "
        ."name='$username' and chatid=$password"
    ;*/
    $sql = "select * from cv_chatid where "
        ."name = ? and chatid = ?"
    ;
    $param = [$username, $password];
    $table = db_bind($sql, $param);
    if(!$table){
        $returncode = 404;
    }

    $r = array(
        "returncode" => $returncode,
        "nextweek" => $nextweek,
        "sql" => $sql,
        "table" => $table
    );
    echo json_encode($r);
?>