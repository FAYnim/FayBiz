<?php
    include "../db-bind.php";
    header("Content-Type: application/json");
    $tgl = getWaktuNow();
    $returncode= 200;

    $inpcoin=""; if(isset($_POST["inpcoin"])){$inpcoin=$_POST["inpcoin"];}
    $inpaddr=""; if(isset($_POST["inpaddr"])){$inpaddr=$_POST["inpaddr"];}
    $id=""; if(isset($_POST["id"])){$id=$_POST["id"];}

    if($id == ""){
        // New Data
        
        // Check if Data Already Exist
        $sql = "select * from cv_adminwallet where "
            ."address='$inpaddr'"
        ;
        $table = db_bind($sql);
        if($table == "empty"){
            $sql = "insert into cv_adminwallet("
                ."coin, address, dins, dupd"
                .") values ("
                ."'$inpcoin', '$inpaddr', "
                ."'$tgl', '$tgl'"
                .")"
            ;
            db_query($sql);
        } else {
            $returncode = 100;
        }
        
        // Get Seq
        $sql = "select seq from cv_adminwallet order by seq desc limit 0,1";
        $table = db_bind($sql);
        if($table == "empty"){
            $id = 1;
        } else {
            $id = $table["seq"] + 1;
        }
    } else {
        // Edit Data
        if(is_numeric($id)){
            $sql = "select * from cv_adminwallet where "
                ."seq=$id"
            ;
            $table = db_bind($sql);
            if($table == "empty"){
                $returncode = 101;
            } else {
                $sql = "update cv_adminwallet set "
                    ."coin='$inpcoin', address='$inpaddr' where "
                    ."seq=$id"
                ;
                db_query($sql);
            }
        } else {
            $returncode = 400;
        }
    }

    $r = array(
        "returncode" => $returncode,
        "id" => $id
    );
    echo json_encode($r);
?>