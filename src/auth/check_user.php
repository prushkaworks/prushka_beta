<?php

    require_once (dirname(dirname(__FILE__)) . '/connector.php');

    function check_session($user_id=null) {
        global $pdo;
        session_start();
        if (is_null($user_id)) {
            if (!array_key_exists('user_id', $_SESSION)) {
                echo 'Ошибка авторизации';
                http_response_code(401);
                return false;
            }
            $u = $pdo->query("SELECT * FROM `User` WHERE id='{$_SESSION["user_id"]}' LIMIT 1;");
            if(!($u->fetch())) {
                echo 'Ошибка авторизации';
                http_response_code(401);
                return false;
            }
        } else {
            $_SESSION['user_id'] = $user_id;
        }
        return [true, $_SESSION['user_id']];
    }

    if (array_key_exists('email', $_GET)) {
        
        $users = $pdo->query('SELECT * FROM `User`');
        $users = $users->fetchAll();

        foreach ($users as $user) {
            $hashed_mail = hash('md5', $user['email']);
            if ($hashed_mail == $_GET['email']) {
                $pdo->exec("UPDATE `User` SET `check_email` = '1' WHERE `id` = '{$user["id"]}';");
                if (check_session($user['id'])) {
                    header('Location: /main');
                };
            }
        }

    }