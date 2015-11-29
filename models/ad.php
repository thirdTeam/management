<?php
    class ad{
        public $number;
        public $position;
        public $salary;
        public $region;
        public $lastupdated;
        public $description;
        public $url;

        public function __construct($number, $position, $salary, $region, $lastupdated, $description, $url)
        {
            $this->number = $number;
            $this->position = $position;
            $this->salary = $salary;
            $this->region = $region;
            $this->lastupdated = $lastupdated;
            $this->description = $description;
            $this->url = $url;
        }

        public function  __toString()
        {
            return $this->number."<br>".$this->position."<br>";
        }

    }
