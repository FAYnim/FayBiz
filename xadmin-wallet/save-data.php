<?php
    include "../db-bind2.php";
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
            ."address = ?"
        ;
        $table = db_bind($sql, [$inpaddr]);
        
        if($table){ // Kalau kosong jalankan ini
            $returncode = 100;
        } else {
            $sql = "insert into cv_adminwallet("
                ."coin, address, dins, dupd"
                .") values ("
                ."'$inpcoin', '$inpaddr', "
                ."'$tgl', '$tgl'"
                .")"
            ;
            db_bind($sql);
        }
        //$table ? ($returncode = 100) /*Jika table empty*/ : db_bind($sql)/*jika table tidak empty*/;

        
        /*if($table === null){
            $returncode = 100;
        } else {
            $sql = "insert into cv_adminwallet("
                ."coin, address, dins, dupd"
                .") values ("
                ."'$inpcoin', '$inpaddr', "
                ."'$tgl', '$tgl'"
                .")"
            ;
            db_bind($sql);
        }*/
        
        // Get Seq
        $sql = "select seq from cv_adminwallet order by seq desc";
        $table = db_bind($sql);
        
        if($table){
            $id = $table["seq"] + 1;
        } else {
            $id = 1;
        }
        
        //$table ? ($id = 1) : ($id = $table["seq"] + 1);
        
        /*if($table){
            $id = 1;
        } else {
            $id = $table["seq"] + 1;
        }*/
    } else {
        // Edit Data
        if(is_numeric($id)){
            $sql = "select * from cv_adminwallet where "
                ."seq = ?"
            ;
            $table = db_bind($sql, [$id]);
            
            if($table){
                $sql = "update cv_adminwallet set "
                    ."coin='$inpcoin', address='$inpaddr' where "
                    ."seq = ?"
                ;
                db_bind($sql, [$id]);
            } else {
                $returncode = 101;
            }
            
            //$table ? db_bind($sql, [$id]) : ($returncode = 101);
            
            /*if($table){
                $returncode = 101;
            } else {
                $sql = "update cv_adminwallet set "
                    ."coin='$inpcoin', address='$inpaddr' where "
                    ."seq=$id"
                ;
                db_bind($sql);
            }*/
        } else {
            $returncode = 400;
        }
    }

    $r = array(
        "returncode" => $returncode,
        "id" => $id,
        "table" => $table
    );
    echo json_encode($r);
?>