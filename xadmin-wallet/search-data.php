<?php
include "../db-bind.php";
header("Content-Type: application/json");
$tgl = getWaktuNow();
$returncode = 200;

$inpsearch = ""; if (isset($_POST["inpsearch"])) {
    $inpsearch = $_POST["inpsearch"];
}
$html = "";


$sql = "select coin, address, balance, user, seq from cv_adminwallet where "
."address like '%".$inpsearch."%'";
$table = db_fetch($sql);
if (count($table) == 0) {
    $returncode = 400;
} else {
    $rownum = 0;
    foreach ($table as $row):
        $rownum++;
        $db_coin = $row["coin"];
        $db_address = $row["address"];
        $db_balance = $row["balance"];
        $db_user = $row["user"];
        $db_seq = $row["seq"];
        $html .= "<tr>"
            ."<td>".$rownum."</td>"
            ."<td>"
            ."<strong>".$db_coin."</strong><br>"
            ."<input type='text' value='$db_address' readonly/>"
        ;
        if ($db_user != "") {
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
                    ."<div class='dropdown-menus'>"
                    ."<a href='#' class='dropdown-item'>Edit</a>"
                    ."</div>"
                        ."<div class='dropdown-menus'>"
                        ."<a href='#' class='dropdown-item'>Delete</a>"
                        ."</div>"
                    ."</div>"
                ."</div>"
                ."</td>"
        ."</tr>"
        ;
    endforeach;
}

$r = array(
    "returncode" => $returncode,
    "html" => $html,
    "sql" => $sql
);
echo json_encode($r);
?>