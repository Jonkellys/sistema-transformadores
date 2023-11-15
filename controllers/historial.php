<?php

    class historial extends controllers {
        public function __construct() {
            parent::__construct();
        }
        
        public function historial($params) {

            $this->views->getView($this, "historial");
        }

        
    }

?>
