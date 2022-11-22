<?php
    require_once(dirname(dirname(__FILE__)) . '/index.php');
    list($em, $id) = check_session();

    $pdo->exec(
        "INSERT INTO `Workspace`(`id`, `name`, `date_created`) VALUES ('{$_POST["id"]}', '{$_POST["name"]}', '{$_POST["date"]}');"
    );

    $pdo->exec(
        "INSERT INTO `UserPrivilege` VALUES ('1', '$id', '{$_POST["id"]}');"
    );

    header('Location: /main');