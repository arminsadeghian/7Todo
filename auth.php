<?php

include __DIR__ . '/bootstrap/init.php';

if (isPostRequest()) {
    $action = $_GET['action'];
    $params = $_POST;
    if ($action == 'register') {
        if (isUserExists($params['email'])) {
            message("Error: user exist with this email");
        } else {
            $result = register($params);
            if (!$result) {
                message("Error: an error in registration!");
            }
        }

    } else if ($action == 'login') {
        $result = login($params['email'], $params['password']);
        if (!$result) {
            message("Error: email or password is incorrect!");
        } else {
            redirect();
        }
    }
}

include "tpl/tpl-auth.php";
