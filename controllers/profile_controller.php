<?php
    class ProfileController{
        public function logout(){
            session_unset();
            session_destroy();
            echo "<script>window.location.replace(\"http://thirdteam.16mb.com/index.php\");</script>";
        }

        public function index(){
            global $auth;
            if($auth){
                $db = Db::getInstance();
                $user_data = $db->query("SELECT * FROM users WHERE id = '".$_SESSION["id"]."' LIMIT 1");
                $user_data = $user_data->fetch(PDO::FETCH_ASSOC);
                $adlist = $db->query("SELECT id, profession, updated, upd, url FROM ads WHERE `user` = '".$_SESSION["id"]."'");
                $_SESSION["user_ads_count"] = $adlist->rowCount();
                $adlist = $adlist->fetchAll(PDO::FETCH_ASSOC);
                $sublist = $db->query("SELECT id, profession, city, salary FROM mailing WHERE `user` = '".$_SESSION["id"]."'");
                $_SESSION["user_sub_count"] = $sublist->rowCount();
                $sublist = $sublist->fetchAll(PDO::FETCH_ASSOC);
                require_once("views/profile/index.php");
            }
        }

        public function changeInfo(){
            global $auth;
            if($auth && isset($_POST["change_info"])){
                $name = $_POST["name"];
                $surname = $_POST["surname"];
                $email = $_POST["email"];
                $company = $this->clean($_POST["company"]);
                $valid_result = $this->validate($name, $surname, $email, $company);
                if($valid_result === true){
                    $db = Db::getInstance();
                    $sth = $db->prepare("UPDATE users SET `name` = ?, surname = ?, `email` = ?, company = ? WHERE id = ?");
                    $sth->execute(array($name, $surname, $email, $company, $_SESSION["id"]));
                }else{
                    switch($valid_result){
                        case "name":{
                            $err_text = "Name must consist of latin/cyrillic characters";
                        }break;
                        case "surname":{
                            $err_text = "Surname must consist of latin/cyrillic characters";
                        }break;
                        case "email":{
                            $err_text = "Email must be like 'example@domain.com'";
                        }break;
                        case "company":{
                            $err_text = "Company contains wrong words";
                        }break;
                    }
                    require_once("views/pages/warning.php");
                }
                $this->index();
            }else{
                echo "<script>window.location.replace(\"http://thirdteam.16mb.com/index.php\");</script>";
            }
        }

        public function changeAds(){
            global $auth;
            if($auth && isset($_POST["change_ads"])){
                $db = Db::getInstance();
                for($i = 0; $i < $_SESSION["user_ads_count"]; $i++){
                    if(isset($_POST["del_".$i])){
                        $sth = $db->prepare("DELETE FROM ads WHERE id = ? AND user = ?");
                        $sth->execute(array($_SESSION["ad_".$i], $_SESSION["id"]));
                        continue;
                    }
                    if(isset($_POST["upd_".$i])){
                        $sth = $db->prepare("UPDATE ads SET upd = 1 WHERE id = ? AND user = ?");
                        $sth->execute(array($_SESSION["ad_".$i], $_SESSION["id"]));
                    }else{
                        $sth = $db->prepare("UPDATE ads SET upd = 0 WHERE id = ? AND user = ?");
                        $sth->execute(array($_SESSION["ad_".$i], $_SESSION["id"]));
                    }
                }
                $this->index();
            }else{
                echo "<script>window.location.replace(\"http://thirdteam.16mb.com/index.php\");</script>";
            }
        }

        public function changeSub(){
            global $auth;
            if($auth && isset($_POST["change_sub"])){
                $db = Db::getInstance();
                for($i = 0; $i < $_SESSION["user_sub_count"]; $i++){
                    if(isset($_POST["unsub_".$i])){
                        $sth = $db->prepare("DELETE FROM mailing WHERE id = ? AND user = ?");
                        $sth->execute(array($_SESSION["sub_".$i], $_SESSION["id"]));
                    }
                }
                $this->index();
            }else{
                echo "<script>window.location.replace(\"http://thirdteam.16mb.com/index.php\");</script>";
            }
        }

        private function clean($value){
            $value = trim($value);
            $value = stripslashes($value);
            $value = strip_tags($value);
            return $value;
        }

        private function validate($name, $surname, $email, $company){
            $pattern_name = "/^[A-zА-яСсІіЇїЁёЪъЬьЙйРрЫыТт]+$/";
            if(!preg_match($pattern_name, $name))
                return "name";
            if(!preg_match($pattern_name, $surname))
                return "surname";
            if(!filter_var($email, FILTER_VALIDATE_EMAIL))
                return "email";
            $tags = "/(\<[A-z 0-9\.\=\"\']*\>)|(\<[A-z 0-9\.\=\"\']*\/\>)|(\<\/[A-z 0-9\.\=\"\']*\>)|(\<\/[A-z 0-9\.\=\"\']*\/\>)/";
            if(preg_match($tags, $company))
                return "company";
            return true;
        }
    }	