<?php
    require_once("db.php");
    require_once("parser.php");
    require_once("models/ad.php");
    $db = Db::getInstance();
    $result = $db->query("SELECT users.email, mailing.profession, mailing.salary, mailing.city FROM mailing INNER JOIN users ON mailing.user = users.id");
    $result = $result->fetchAll(PDO::FETCH_ASSOC);
    foreach($result as $row){
        $request = createRequest($row["profession"],$row["city"],$row["salary"], 7);
        $response = getResponse($request);
        Parser::parseResponse($response);
        $ad_count = Parser::getAdCount();
        if($ad_count > 0){
            $msg = "Ads for you:\n";
            foreach (Parser::getAdList() as $ad) {
                $msg .= $ad->position."\n";
                $msg .= $ad->region."\n";
                $msg .= $ad->salary."\n";
                $msg .= $ad->description."\n";
                $msg .= $ad->lastupdated."\n";
                $msg .= $ad->url."\n";
            }
            $msg = wordwrap($msg,70);
            mail($row["email"],"Ads form Third Team",$msg);
            sleep(1);
        }

    }

    function createRequest($profession, $city, $salary, $max_ads){
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

    function getResponse($request){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"http://ua.jooble.org/Export/XmlSearchResult.ashx");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/plain'));
        $response = curl_exec($ch);
        return $response;
    }