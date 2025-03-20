<?php
    include "db-bind.php";

    $returncode = 200;
    $nextweek = getWaktuNowAdd("+7 days");
    $username=""; if(isset($_POST["username"])){$username=$_POST["username"];}
    $password=""; if(isset($_POST["password"])){$password=$_POST["password"];}
    header("Content-Type: application/json");
    
    $sql = "select * from cv_chatid where "
        ."name='$username' and chatid=$password"
    ;
    $table = db_bind($sql);
    if($table == "empty"){
        $returncode = 400;
    }

    $r = array(
        "returncode" => $returncode,
        "nextweek" => $nextweek,
        "sql" => $sql
    );
    echo json_encode($r);
?>