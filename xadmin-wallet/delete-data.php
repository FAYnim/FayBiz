<?php
    include "../db-bind.php";
    header("Content-Type: application/json");
    $tgl = getWaktuNow();
    $returncode= 200;

    $id=""; if(isset($_POST["id"])){$id=$_POST["id"];}

    $sql = "select * from cv_adminwallet where "
        ."seq=$id"
    ;
    $table = db_bind($sql);
    if($table == "empty"){
        $returncode = 400;
    } else {
        $sql = "delete from cv_adminwallet where "
            ."seq=$id"
        ;
        db_query($sql);
    }

    $r = array(
        "returncode" => $returncode,
        "id" => $id
    );
    echo json_encode($r);
?>