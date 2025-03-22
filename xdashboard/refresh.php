<?php
    include "../db-bind.php";
    header("Content-Type: application/json");
    $returncode= 200; $html = "";

//    $page=""; if(isset($_POST["page"])){$page=$_POST["page"];}

    $sql = "select * from cv_statistic";
    $table = db_fetch($sql);
    if(count($table) == 0){
        $returncode = 400;
    } else {
        foreach($table as $row):
            $db_stat_name = $row["stat_name"];
            $db_stat_ival = $row["stat_ival"];
            $db_stat_dval = $row["stat_dval"];
            $db_stat_ival_old = $row["stat_ival_old"];
            $db_stat_dval_old = $row["stat_dval_old"];
            $delta_stat_ival = $db_stat_ival - $db_stat_ival_old;
            $delta_stat_dval = $db_stat_dval - $db_stat_dval_old;
            
            
            if($db_stat_ival == 0){
                $db_stat_val = $db_stat_dval;
                $delta_val = $delta_stat_dval;
            } else {
                $db_stat_val = $db_stat_ival;
                $delta_val = $delta_stat_ival;
            }
            
            if($delta_val > 0){
                $delta_val = "+".$delta_val;
            }
            
            $html .= "<div class='statistic-container' id='statistic-dashboard'>"
                    ."<h2>".$db_stat_name."</h2>"
                    ."<h3 id='stat-$db_stat_name'>$".$db_stat_val
                        ."<span class='stchange' id='stchange-$db_stat_name'>".$delta_val."</span>"
                    ."</h3>"
                ."</div>"
            ;
        endforeach;
    }

    $r = array(
        "returncode" => $returncode,
        "html" => $html
    );
    echo json_encode($r);
