<?php

    class ayuda extends controllers {
        public function __construct() {
            parent::__construct();
        }
        
        public function ayuda($params) {
            $this->views->getView($this, "ayuda");
        }

    }

?>
