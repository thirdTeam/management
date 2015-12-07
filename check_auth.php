<?php
    function check_auth(){
        if (isset($_SESSION["id"]) && isset($_SESSION["hash"])) {
            require_once("db.php");
            $db = Db::getInstance();
            $resp = $db->query("SELECT * FROM users WHERE id = '".intval($_SESSION["id"])."'");
            $user_data = $resp->fetch(PDO::FETCH_ASSOC);
            if (($user_data['id'] !== $_SESSION['id']) || ($user_data['hash'] !== $_SESSION["hash"])) {
                unset($_SESSION["id"]);
                unset($_SESSION["hash"]);
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }