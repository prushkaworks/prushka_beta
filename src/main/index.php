<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная страница</title>
</head>
<body>
    <h2>Главная страница сайта канбан-доски</h2><br/>
    <?php
        require_once(dirname(dirname(__FILE__)) . '/auth/check_user.php');
        list($em, $id) = check_session();
        
        $username = $pdo->query("SELECT `name` FROM `User` WHERE `id`='$id';");
        $username = $username->fetch(); $username = $username['name'];

        if (!is_null($id)) {
            echo "Добро пожаловать, $username<br/><br/>";
        }

        $works = $pdo->query(
            "SELECT `Workspace`.`name` FROM `UserPrivilege` JOIN `Workspace` ON `UserPrivilege`.`workspace_id`=`Workspace`.`id` WHERE `user_id`='$id';"
        );

        $works = $works->fetchAll();
        if ($works) {
            foreach ($works as $work) {
                echo "Рабочее пространство: '{$work["name"]}'<br/>";
            }
        } else {
            echo "У Вас пока нет рабочих пространств.<br/><br/>";
        }
        $url = "http://$_SERVER[HTTP_HOST]/main/workspace/create.php";
        echo "<a href=$url>Создать новое</a>";
    ?>
</body>
</html>