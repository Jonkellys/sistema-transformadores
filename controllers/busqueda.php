<?php

    class busqueda extends controllers {
        public function __construct() {
            parent::__construct();
        }
        
        public function busqueda($params) {

            $this->views->getView($this, "busqueda");
        }

        
    }

?>
