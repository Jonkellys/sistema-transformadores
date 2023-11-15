<?php

    class home extends controllers {
        public function __construct() {
            parent::__construct();
        }

        public function home($params) {

            $data['tag_page'] = "home";
            $data['page_title'] = "Menú | Horarios";
            $data['page_name'] = "home";
            $this->views->getView($this, "home", $data);
        }
    }

?>