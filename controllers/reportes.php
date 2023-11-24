<?php

    class reportes extends controllers {
        public function __construct() {
            parent::__construct();
        }
        
        public function reportes($params) {

            $this->views->getView($this, "reportes");
        }

        
    }

?>
