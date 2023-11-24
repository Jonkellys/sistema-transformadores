<?php

    class recover extends controllers {
        public function __construct() {
            parent::__construct();
        }
        
        public function recover($params) {

            $this->views->getView($this, "recover");
        }

        
    }

?>
