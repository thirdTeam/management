<?php
    class SigninController{
        public function index(){
            require_once("views/signin/index.php");
        }

        public function register(){
            if(isset($_POST["register"])){
                $login = $_POST["login"];
                $password = $_POST["password"];
                $password_c = $_POST["password_c"];
                $valid_result = $this->validate($login, $password);
                if($valid_result === true){
                    if(strcmp($password, $password_c) == 0){
                        require_once("db.php");
                        $db = Db::getInstance();
                        $resp = $db->query("SELECT * FROM users WHERE login = '".$login."'");
                        if($resp->rowCount() == 0){
                            $password = md5($password);
                            $db->query("INSERT INTO users SET login = '".$login."', password = '".$password."'");
                            echo "<script>window.location.replace(\"http://thirdteam.16mb.com/index.php?controller=signin&action=login\");</script>";
                        }else{
                            $err_text = "User with such login is already exist";
                            require_once("views/pages/warning.php");
                        }
                    }else{
                        $err_text = "Passwords must be equals";
                        require_once("views/pages/warning.php");
                    }
                }else{
                    switch($valid_result){
                        case "login":{
                            $err_text = "Login must consist of 4-16 latin letter with/without digits";
                        }break;
                        case "password":{
                            $err_text = "Pasword must consist of 8-16 latin letter and/or digits";
                        }
                    }
                    require_once("views/pages/warning.php");
                }
            }
            require_once("views/signin/register.php");
        }

        public function login(){
            if(isset($_POST["signin"])){
                $login = $_POST["login"];
                $password = $_POST["password"];
                $valid_result = $this->validate($login, $password);
                if($valid_result === true){
                    require_once("db.php");
                    $db = Db::getInstance();
                    $resp = $db->query("SELECT * FROM users WHERE login = '".$login."' AND password = '".md5($password)."'");
                    if($resp->rowCount() != 0){
                        $hash = md5($this->generateCode(10));
                        $_SESSION["id"] = $resp->fetch(PDO::FETCH_ASSOC)['id'];
                        $_SESSION["hash"] = $hash;
                        $db->query("UPDATE users SET hash = '".$hash."' WHERE id = '".$_SESSION["id"]."'");
                        echo "<script>window.location.replace(\"http://thirdteam.16mb.com/index.php\");</script>";
                    }else{
                        $err_text = "No user with such login and password";
                        require_once("views/pages/warning.php");
                    }
                }else{
                    switch($valid_result){
                        case "login":{
                            $err_text = "Login must consist of 4-16 latin letter with/without digits";
                        }break;
                        case "password":{
                            $err_text = "Pasword must consist of 8-16 latin letter and/or digits";
                        }
                    }
                    require_once("views/pages/warning.php");
                }
            }
            require_once("views/signin/login.php");
        }

        private function generateCode($length=6) {
            $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
            $code = "";
            $clen = strlen($chars) - 1;
            while (strlen($code) < $length) {
                $code .= $chars[mt_rand(0,$clen)];
            }
            return $code;

        }

        private function validate($login, $password){
            if(!preg_match("/^[A-z]{1}[A-z0-9]{3,15}$/", $login))
                return "login";
            if(!preg_match("/^[A-z0-9]{8,16}$/", $password))
                return "password";
            return true;
        }
    }