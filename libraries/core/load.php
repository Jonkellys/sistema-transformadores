<?php

    $controllerFile = "controllers/" . $controller . ".php";

    if (file_exists($controllerFile)) {
        require_once($controllerFile);
        $controller = new $controller();

        if (method_exists($controller, $method)) {
            $controller->{$method}($params);

        } else {
            require_once("views/error/error.php");
        }

    } else {
        require_once("views/error/error.php");
    }
    
?>