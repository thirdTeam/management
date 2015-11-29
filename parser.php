<?php
    class Parser {
        private static $ad_list = NULL;
        private static $ad_count = 0;

        private function __construct() {}

        private function __clone() {}

        public static function getAdCount(){
            return self::$ad_count;
        }

        public static function getAdList(){
            return self::$ad_list;
        }

        public static function parseResponse($raw_response){
            try {
                $response = new SimpleXMLElement($raw_response);
                self::$ad_count = intval($response->messages['count']);
                if(self::$ad_count > 0){
                    self::$ad_list = array();
                    foreach ($response->messages->msg as $msg) {
                        array_push(self::$ad_list, new ad(
                            (string)$msg->number,
                            (string)$msg->position,
                            (string)$msg->salary,
                            (string)$msg->region,
                            (string)$msg->updated,
                            (string)$msg->desc,
                            (string)$msg->sources->source->url
                        ));
                    }
                }
                return true;
            }catch (Exception $e) {
                echo $e;
                return false;
            }
        }
    }