<?php

    class transformador extends controllers {
        public function __construct() {
            parent::__construct();
        }
        
        public function transformador($params) {
            $this->views->getView($this, "transformador");
        }

    }

?>
