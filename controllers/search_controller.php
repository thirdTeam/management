<?php
    class SearchController {

        private $ads_on_page = 3;

        public function index(){
            require_once("views/search/index.php");
            $this->createQuery("программист","николаев",2000);
        }

        public function signup(){
            global $auth;
            if($auth){
                $db = Db::getInstance();
                $resp = $db->query("SELECT `email` FROM users WHERE id = '".$_SESSION["id"]."'");
                $resp = $resp->fetch(PDO::FETCH_ASSOC);
                if(empty($resp["email"])){
                    $err_header = "Ooops!";
                    $err_text = "You must fill your email to subscribe";
                    require_once("views/pages/error.php");
                }else {
                    $db = Db::getInstance();
                    $mysqldate = date("Y-m-d");
                    $sth = $db->prepare("INSERT INTO mailing SET `user` = ?, profession = ?, city = ?, salary = ?");
                    $sth->execute(array($_SESSION["id"], $_SESSION["profession"], $_SESSION["city"], $_SESSION["salary"]));
                    $text = "You are successfully subscribed";
                    require_once("views/pages/success.php");
                    $this->displayAds(1, $this->ads_on_page);
                }
            }else{
                $err_header = "Ooops!";
                $err_text = "You must be logged in to subscribe";
                require_once("views/pages/error.php");
            }
        }

        public function result(){
            $max_pages = 30;
            $max_ads = 30;
            if(isset($_POST["find"])) {
                $profession = $this->clean($_POST["profession"]);
                $city = $this->clean($_POST["city"]);
                $salary = $this->clean($_POST["salary"]);
                $valid_result = $this->validate($profession, $city, $salary);
                if($valid_result === true){
                    $_SESSION["profession"] = $profession;
                    $_SESSION["city"] = $city;
                    $_SESSION["salary"] = $salary;
                    require_once("parser.php");
                    $request = $this->createRequest($profession, $city, $salary, $max_ads);
                    $response = $this->getResponse($request);
                    if (Parser::parseResponse($response)){
                        $ad_count = Parser::getAdCount();
                        $query = $this->createQuery($profession, $city, $salary);
                        $our_ads = $this->getAdsListFormDB($query);
                        if($our_ads !== false){
                            if($ad_count > 0)
                                $our_ads = array_merge($our_ads, Parser::getAdList());
                            $ad_count += count($our_ads);
                            $_SESSION["ad_list"] = $our_ads;
                        }else{
                            $_SESSION["ad_list"] = Parser::getAdList();
                        }
                        if ($ad_count > 0) {
                            if ($ad_count <= $this->ads_on_page) {
                                $last_page = 1;
                            } else {
                                $last_page = intval($ad_count / $this->ads_on_page);
                                if ($ad_count % $this->ads_on_page != 0) {
                                    $last_page++;
                                }
                            }
                            $_SESSION["ad_count"] = $ad_count;
                            $_SESSION["last_page"] = $last_page;
                            $this->displayAds(1, $this->ads_on_page);
                        } else {
                            if (isset($_SESSION["ad_list"])) {
                                unset($_SESSION["ad_list"]);
                                unset($_SESSION["ad_count"]);
                                unset($_SESSION["last_page"]);
                            }
                            $err_header = "Ooops!";
                            $err_text = "No results for your request";
                            require_once("views/pages/error.php");
                        }
                    } else {
                        $err_header = "Ooops!";
                        $err_text = "Retry your request later";
                        require_once("views/pages/error.php");
                    }
                }else{
                    switch($valid_result){
                        case "profession":{
                            $err_header = "Incorrect profession";
                            $err_text = "Profession can't be empty";
                        }break;
                        case "city":{
                            $err_header = "Incorrect city";
                            $err_text = "City must be like 'Mykolaiv' or empty";
                        }break;
                        case "salary":{
                            $err_header = "Incorrect salary";
                            $err_text = "Salary must be numeric or empty";
                        }break;

                    }
                    require_once("views/pages/error.php");
                }
            }elseif(isset($_GET["page"]) && (intval($_GET["page"]) != 0) && ((intval($_GET["page"]) > 0) && (intval($_GET["page"]) <= $max_pages)) && isset($_SESSION["ad_list"])){
                $page = intval($_GET["page"]);
                $this->displayAds($page, $this->ads_on_page);
            }else{
                require_once("views/search/index.php");
            }
        }

        private function getResponse($request){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,"http://ua.jooble.org/Export/XmlSearchResult.ashx");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/plain'));
            $response = curl_exec($ch);
            return $response;
        }

        private function createRequest($profession, $city, $salary, $max_ads){
            $request = "<request>
                    <preferred_encoding>utf-8</preferred_encoding>
                    <keywords only_position='1'>
                        <or>$profession</or>
                    </keywords>
                    <region>
                        <city>$city</city>
                    </region>
                    <salary required='1'>
                        <low>$salary</low>
                    </salary>
                    <date type='actual'>last7day</date>
                    <page_no>1</page_no>
                    <msg_count>$max_ads</msg_count>
                    <src_count>1</src_count>
               </request>";
            return $request;
        }

        private function validate($profession, $city, $salary){
            if(!empty($profession)){
                if(preg_match("/(\<[A-z 0-9\.\=\"\']*\>)|(\<[A-z 0-9\.\=\"\']*\/\>)|(\<\/[A-z 0-9\.\=\"\']*\>)|(\<\/[A-z 0-9\.\=\"\']*\/\>)/", $profession)){
                    echo "tag";
                    return "profession";
                }
                if(!empty($city)) {
                    if (!preg_match("/^[A-zА-яСсІіЇїЁёЪъЬьЙйРрЫыТт]+$/", $city)) {
                        echo "doesn't match city";
                        return "city";
                    }
                }
                if(!empty($salary)) {
                    $salary = $this->get_numeric($salary);
                    if($salary == 0){
                        return "salary";
                    }
                }
            }else{
                return "profession";
            }
            return true;
        }

        function get_numeric($val) {
            if (is_numeric($val)) {
                return $val + 0;
            }
            return 0;
        }

        private function getAdsListFormDB($query){
            require_once("db.php");
            $db = Db::getInstance();
            $resp = $db->query($query);
            if($resp->rowCount() != 0) {
                $resp = $resp->fetchAll(PDO::FETCH_ASSOC);
                $ad_list = array();
                foreach ($resp as $row) {
                    array_push($ad_list, new ad(
                        //(string)$msg->number,
                        (string)$row["profession"],
                        (string)$row["salary"],
                        (string)$row["city"],
                        (string)$this->getLastUpdate($row["updated"])." &#1076;&#1085;&#1077;&#1081; &#1085;&#1072;&#1079;&#1072;&#1076;",
                        (string)$row["description"],
                        (string)$row["url"]
                    ));
                }
                return $ad_list;
            }else
                return false;
        }

        private function getLastUpdate($date){
            $value = intval((strtotime(date("Y-m-d")) - strtotime($date))/(60*60*24));
            return (($value < 0)? 0 : $value);
        }

        private function createQuery($profession, $city, $salary){
            $query = "SELECT * FROM ads WHERE (profession COLLATE UTF8_GENERAL_CI LIKE '%".$profession."%')";
            if(!empty($city)){
                $query .= " AND (city COLLATE UTF8_GENERAL_CI LIKE '%".$city."%')";
            }
            if(!empty($salary))
                $query .= " AND (salary >= '".$salary."')";
            return $query." ORDER BY `updated` DESC";
        }

        private function clean($value){
            $value = trim($value);
            $value = stripslashes($value);
            $value = strip_tags($value);
            return $value;
        }

        private function displayAds($page, $ads_on_page){
            if($page == $_SESSION["last_page"] && $_SESSION["ad_count"] % $ads_on_page != 0)
                $ads_to_show = $_SESSION["ad_count"] % $ads_on_page;
            else
                $ads_to_show = $ads_on_page;
            $start = ($page - 1) * $ads_on_page;
            require_once("views/search/result.php");
        }
    }	