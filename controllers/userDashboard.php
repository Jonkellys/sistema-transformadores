<?php

    class userDashboard extends controllers {
        public function __construct() {
            parent::__construct();
        }
        
        public function userDashboard($params) {
            $this->views->getView($this, "userDashboard");
        }

    }

?>