<?php
    class PagesController {
        public function home() {
            require_once('views/pages/home.php');
        }

        public function error() {
            require_once('views/pages/error.php');
        }

        public function show(){
            if(isset($_GET["ad"])){
                $ad_id = $this->get_numeric($_GET["ad"]);
                if($ad_id !== 0){
                    require_once("db.php");
                    $db = Db::getInstance();
                    $ad = $db->query("SELECT ads.profession, ads.city, ads.description, ads.salary, ads.updated, users.name, users.surname, users.company, users.email".
                                    " FROM ads INNER JOIN users ON ads.user = users.id WHERE ads.id = '".$ad_id."' LIMIT 1");
                    if($ad->rowCount() != 0){
                        $ad = $ad->fetch(PDO::FETCH_ASSOC);
                        require_once("views/ads/full_ad.php");
                    }else{
                        $err_header = "Ooops!";
                        $err_text = "No such ad";
                        require_once("views/pages/error.php");
                    }
                }else{
                    //полохой id
                    echo "<script>window.location.replace(\"http://thirdteam.16mb.com/index.php\");</script>";
                }
            }else{
                echo "<script>window.location.replace(\"http://thirdteam.16mb.com/index.php\");</script>";
            }
        }

        private function getLastUpdate($date){
            return intval((strtotime(date("Y-m-d")) - strtotime($date))/(60*60*24));
        }

        function get_numeric($val) {
            if (is_numeric($val)) {
                return $val + 0;
            }
            return 0;
        }
    }
