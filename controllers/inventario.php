<?php

    class inventario extends controllers {
        public function __construct() {
            parent::__construct();
        }
        
        public function inventario($params) {

            $this->views->getView($this, "inventario");
        }

    }

?>
