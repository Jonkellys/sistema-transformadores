<?php

    class delete extends controllers {
        public function __construct() {
            parent::__construct();
        }
        
        public function delete($params) {
            $this->views->getView($this, "delete");
        }

    }

?>
