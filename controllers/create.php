<?php

    class create extends controllers {
        public function __construct() {
            parent::__construct();
        }
        
        public function create($params) {
            $this->views->getView($this, "create");
        }

    }

?>