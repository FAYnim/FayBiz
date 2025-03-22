<?php
    include "../db-bind.php";
    header("Content-Type: application/json");
    $tgl = getWaktuNow();
    $returncode= 200;

    $inpcoin=""; if(isset($_POST["inpcoin"])){$inpcoin=$_POST["inpcoin"];}
    $inpaddr=""; if(isset($_POST["inpaddr"])){$inpaddr=$_POST["inpaddr"];}
    $id=""; if(isset($_POST["id"])){$id=$_POST["id"];}
    $db_coin = $db_addr = "";


    if($id == ""){
        // New Data
    } else {
        // Edit Data
        $sql = "select * from cv_adminwallet where "
            ."seq=$id"
        ;
        $table = db_bind($sql);
        if($table == "empty"){
            $returncode = 100;
        } else {
            $returncode = 201;
            $db_coin = $table["coin"];
            $db_addr = $table["address"];
        }
    }

    $r = array(
        "returncode" => $returncode,
        "id" => $id,
        "coin" => $db_coin,
        "address" => $db_addr
    );
    echo json_encode($r);
?>