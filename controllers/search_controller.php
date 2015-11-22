<?php
    class SearchController {
        public function index(){
            require_once('views/search/index.php');
        }

        public function result(){
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
            require_once("parser.php");
            Parser::getAdList(file_get_contents("response.xml"));
        }
    }