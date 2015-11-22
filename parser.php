<?php
    class Parser {
        private static $ad_list = NULL;

        private function __construct() {}

        private function __clone() {}

        public static function getAdList($raw_response){
            require_once("/models/ad.php");
            $response = new SimpleXMLElement($raw_response);
            $counter = 0;
            foreach($response->messages->msg as $msg){
                self::$ad_list[$counter] = new ad(
                    $msg->number,
                    $msg->position,
                    $msg->salary,
                    $msg->region,
                    $msg->updated,
                    $msg->desc,
                    $msg->sources->source->url
                );
                $counter++;
            }
            return self::$ad_list;
        }
    }