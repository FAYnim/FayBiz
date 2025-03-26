<?php
    include "../db-bind2.php";
    header("Content-Type: application/json");
    $returncode= 200;

    $page=""; if(isset($_POST["page"])){$page=$_POST["page"];}

    if($page != ""){
        $limit = ($page - 1) * 10;
        
        $sql = "select * from cv_adminwallet "
            ."limit $limit,10"
        ;
        $table = db_fetch($sql);
        $html = "";
        if(!$table){
            $returncode = 100;
        } else {
            $rownum = 0;
            foreach($table as $row):
                $rownum++;
                $db_address = $row["address"];
                $db_balance = $row["balance"];
                $db_coin = $row["coin"];
                $db_fuse = $row["fuse"];
                $db_user = $row["user"];
                $db_dupd = $row["dupd"];
                $db_seq = $row["seq"];
                
                $html .= "<tr>"
                        ."<td>".$rownum."</td>"
                        ."<td>"
                            ."<strong>".$db_coin."</strong><br>"
                            ."<input type='text' value='$db_address' readonly/>"
                ;
                if($db_fuse == 1){
                    $html .= "<br><input type='text' value='$db_user' readonly />";
                }
                $html .= "</td>"
                        ."<td>"
                        .$db_balance
                        ."</td>"
                        ."<td class='action-td'>"
                            ."<div class='action-container'>"
                                ."<button class='btn-action'>Action</button>"
                                ."<div class='dropdown-menu'>"
                                    ."<div class='dropdown-menus edit-data' data-id='$db_seq'>"
                                        ."<a href='#' class='dropdown-item'>Edit</a>"
                                    ."</div>"
                                    ."<div class='dropdown-menus delete-data' data-id='$db_seq'>"
                                        ."<a href='#' class='dropdown-item'>Delete</a>"
                                    ."</div>"
                                ."</div>"
                            ."</div>"
                            ."<!--select class='action-dropdown'>"
                                ."<option value=''>Action</option>"
                                ."<option value='edit'>Edit</option>"
                                ."<option value='delete'>Delete</option>"
                            ."</select-->"
                        ."</td>"
                    ."</tr>"
                ;
            endforeach;
        }
    }

    $r = array(
        "returncode" => $returncode,
        "html" => $html,
        "table" => $table
    );
    echo json_encode($r);
?>