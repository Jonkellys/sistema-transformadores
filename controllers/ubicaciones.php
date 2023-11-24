<?php

    class ubicaciones extends controllers {
        public function __construct() {
            parent::__construct();
        }
        
        public function ubicaciones($params) {

            $this->views->getView($this, "ubicaciones");
        }

        
    }

?>
