<?php
    include "../db-bind2.php";
    header("Content-Type: application/json");
    $tgl = getWaktuNow();
    $returncode= 200;

    $id=""; if(isset($_POST["id"])){$id=$_POST["id"];}

    $sql = "select * from cv_adminwallet where "
        ."seq = ?"
    ;
    $table = db_bind($sql, [$id]);
    if($table){
        $sql = "delete from cv_adminwallet where "
            ."seq = ?"
        ;
        db_bind($sql, [$id]);
    } else {
        $returncode = 400;
    }

    $r = array(
        "returncode" => $returncode,
        "id" => $id
    );
    echo json_encode($r);
?>