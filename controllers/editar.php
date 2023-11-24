<?php

    class editar extends controllers {
        public function __construct() {
            parent::__construct();
        }
        
        public function editar($params) {

            $this->views->getView($this, "editar");
        }

        
    }

?>
