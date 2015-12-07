<?php
    require_once("db.php");
    $db = Db::getInstance();
    $result = $db->query("SELECT id FROM ads WHERE upd = 1");
    $result = $result->fetchAll(PDO::FETCH_ASSOC);
    $mysqldate = date("Y-m-d");
    foreach($result as $row){
        $db->query("UPDATE ads SET updated = '".$mysqldate."' WHERE id = '".$row["id"]."'");
    }
