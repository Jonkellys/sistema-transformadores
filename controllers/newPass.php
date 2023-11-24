<?php

    class newPass extends controllers {
        public function __construct() {
            parent::__construct();
        }
        
        public function newPass($params) {

            $this->views->getView($this, "newPass");
        }

        
    }

?>
