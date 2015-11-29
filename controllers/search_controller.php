<?php
    class SearchController {
        public function index(){
            require_once("views/search/index.php");
        }

        public function result(){
            $ads_on_page = 3;
            $max_pages = 30;
//            $content = '<request>
//                            <keywords only_position="1">
//                                <or>программист c#</or>
//                                <and>c++</and>
//                                <not>тестер</not>
//                            </keywords>
//                            <region>
//                                <city>Киев</city>
//                            </region>
//                            <salary required="1">
//                                <low>300</low>
//                                <high>2000</high>
//                            </salary>
//                            <date type="new">last7day</date>
//                            <page_no>1</page_no>
//                            <msg_count>10</msg_count>
//                            <src_count>3</src_count>
//                       </request>';
//            $ch = curl_init();
//            curl_setopt($ch, CURLOPT_URL,"http://ua.jooble.org/Export/XmlSearchResult.ashx");
//            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//            curl_setopt($ch, CURLOPT_POST, 1);
//            curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
//            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/plain'));
//            $result=curl_exec ($ch);
//            file_put_contents("response.xml", $result);
            if(isset($_POST["find"])) {
                $profession = $this->clean($_POST["profession"]);
                $city = $this->clean($_POST["city"]);
                $age = $this->clean($_POST["age"]);
                $salary = $this->clean($_POST["salary"]);
                if(true){//$this->validate($profession, $city, $age, $salary)) {
                    require_once("parser.php");
                    if (Parser::parseResponse(file_get_contents("response.xml"))) {
                        $ad_count = Parser::getAdCount();
                        if ($ad_count > 0) {
                            if ($ad_count <= $ads_on_page) {
                                $last_page = 1;
                            } else {
                                $last_page = intval($ad_count / $ads_on_page);
                                if ($ad_count % $ads_on_page != 0) {
                                    $last_page++;
                                }
                            }
                            $_SESSION["ad_list"] = Parser::getAdList();
                            $_SESSION["ad_count"] = $ad_count;
                            $_SESSION["last_page"] = $last_page;
                            $this->displayAds(1, $ads_on_page);
                        } else {
                            if (isset($_SESSION["ad_list"])) {
                                unset($_SESSION["ad_list"]);
                                unset($_SESSION["ad_count"]);
                                unset($_SESSION["last_page"]);
                            }
                            //нет объявлений
                        }
                    } else {
                        //не парсится
                    }
                }else{
                    echo "not valid";
                }
            }elseif(isset($_GET["page"]) && (intval($_GET["page"]) != 0) && (intval($_GET["page"]) <= $max_pages) && isset($_SESSION["ad_list"])){
                $page = intval($_GET["page"]);
                $this->displayAds($page, $ads_on_page);
            }else{
                //зашли на страницу без поиска или некорректный page
                require_once("views/search/index.php");
            }
        }

        public function createRequest(){

        }

        public function validate($profession, $city, $age, $salary){
            if(!empty($profession)){
                if(preg_match("/^([A-z]+)$/i",$city))
                    echo "matches";
            }else{
                echo "empty";
            }
            return true;
        }

        public function clean($value){
            $value = trim($value);
            $value = stripslashes($value);
            $value = strip_tags($value);
            return $value;
        }

        public function displayAds($page, $ads_on_page){
            if($page == $_SESSION["last_page"] && $_SESSION["ad_count"] % $ads_on_page != 0)
                $ads_to_show = $_SESSION["ad_count"] % $ads_on_page;
            else
                $ads_to_show = $ads_on_page;
            $start = ($page - 1) * $ads_on_page;
            require_once("views/search/result.php");
        }
    }