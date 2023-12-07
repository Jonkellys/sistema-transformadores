<?php

    class configuraciones extends controllers {
        public function __construct() {
            parent::__construct();
        }
        
        public function configuraciones($params) {
            $this->views->getView($this, "configuraciones");
        }

    }

?>
