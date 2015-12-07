<?php
    class CreateController{

        public function index(){
            global $auth;
            if($auth){
                $db = Db::getInstance();
                $resp = $db->query("SELECT `name`, surname, `email` FROM users WHERE id = '".$_SESSION["id"]."'");
                $resp = $resp->fetch(PDO::FETCH_ASSOC);

                if(empty($resp["name"]) || empty($resp["surname"]) || empty($resp["email"])){
                    $err_header = "Ooops!";
                    $err_text = "You must fill your name, surname and email in your profile to create ad";
                    require_once("views/pages/error.php");
                }else {
                    require_once("views/create/index.php");
                }
            }else{
                $err_header = "Ooops!";
                $err_text = "You must be logged in to create ad";
                require_once("views/pages/error.php");
            }
        }

        public function add(){
            global $auth;
            if($auth && isset($_POST["add"])){
                $profession = $this->clean($_POST["profession"]);
                $city = $this->clean($_POST["city"]);
                $salary = $this->clean($_POST["salary"]);
                $description = $this->clean($_POST["description"]);
                $valid_result = $this->validate($profession, $city, $salary, $description);
                if($valid_result === true){
                    $db = Db::getInstance();
                    $mysqldate = date("Y-m-d");
                    $sth = $db->prepare("INSERT INTO ads SET `user` = ?, profession = ?, city = ?, `date` = ?, updated = ?, " .
                        "description = ?, salary = ?");
                    $sth->execute(array($_SESSION["id"], $profession, $city, $mysqldate, $mysqldate, $description, $salary));
                    $id = $db->lastInsertId();
                    $url = "http://thirdteam.16mb.com/index.php?controller=pages&action=show&ad=$id";
                    $db->query("UPDATE ads SET url = '".$url."' WHERE id = '".$id."'");
                    echo "<script>window.location.replace(\"$url\");</script>";
                }else{
                    switch($valid_result){
                        case "profession":{
                            $err_text = "Profession can't be empty or contain tags";
                        }break;
                        case "city":{
                            $err_text = "City must be like 'Mykolaiv' or empty";
                        }break;
                        case "salary":{
                            $err_text = "Salary must be numeric or empty";
                        }break;
                        case "description":{
                            $err_text = "Description can't be empty or contain tags";
                        }break;
                    }
                    require_once("views/pages/warning.php");
                    require_once("views/create/index.php");
                }
            }else{
                echo "<script>window.location.replace(\"http://thirdteam.16mb.com/index.php\");</script>";
            }
        }

        private function validate($profession, $city, $salary, $description){
            if(!empty($profession)){
                if(!empty($description)) {
                    $tags = "/(\<[A-z 0-9\.\=\"\']*\>)|(\<[A-z 0-9\.\=\"\']*\/\>)|(\<\/[A-z 0-9\.\=\"\']*\>)|(\<\/[A-z 0-9\.\=\"\']*\/\>)/";
                    if (preg_match($tags, $profession)) {
                        return "profession";
                    }
                    if (preg_match($tags, $description)) {
                        return "description";
                    }
                    if (!empty($city)) {
                        if (!preg_match("/^[A-zА-яСсІіЇїЁёЪъЬьЙйРрЫыТт]+$/", $city)) {
                            return "city";
                        }
                    }
                    if (!empty($salary)) {
                        $salary = $this->get_numeric($salary);
                        if ($salary == 0) {
                            return "salary";
                        }
                    }
                }else{
                    return "description";
                }
            }else{
                return "profession";
            }
            return true;
        }

        private function get_numeric($val) {
            if (is_numeric($val)) {
                return $val + 0;
            }
            return 0;
        }

        private function clean($value){
            $value = trim($value);
            $value = stripslashes($value);
            $value = strip_tags($value);
            return $value;
        }
    }	