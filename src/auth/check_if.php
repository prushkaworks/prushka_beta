<?php
    require_once (dirname(dirname(__FILE__)) . '/connector.php');

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;


    $mail = new PHPMailer(true);
    if (array_key_exists('name', $_POST)) {

        $pass = hash('sha256', $_POST['password']);
        
        $pdo->exec(
            "INSERT INTO `User`(`name`,`email`,`password`)
            VALUES ('{$_POST['name']}','{$_POST['email']}','{$pass}');"
        );

        $user = $pdo->query(
            "SELECT * FROM `User` WHERE `email` = \"{$_POST['email']}\""
        );
        $user = $user->fetch();

        $email = hash('md5', $_POST['email']);
        $url = "http://$_SERVER[HTTP_HOST]/auth/check_user.php?email=$email";

        try {

            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->Host       = $_ENV['SMTP_HOST'];
            $mail->SMTPAuth   = true;
            $mail->Username   = $_ENV['SMTP_USER'];
            $mail->Password   = $_ENV['SMTP_PASSWORD'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = $_ENV['SMTP_PORT'];
            $mail->CharSet    = 'UTF-8';
    
            $mail->setFrom($_ENV['SMTP_SENT_FROM'], 'TestMailer');
            $mail->addAddress($_POST['email']); 
        
            $mail->isHTML(true);                                  
            $mail->Subject = 'Подтверждение email';
            $mail->Body    = "Для подтверждения адреса электронной почты,<br/>
                             перейдите по этой ссылке: <a href='$url'>$url</a>";
            $mail->AltBody    = "Для подтверждения адреса электронной почты,<br/>
            перейдите по этой ссылке: <a href='$url'>$url</a>";
        
            $mail->send();
            echo 'Вам на почту отправлено письмо для подтверждения.<br/>
                 Дальнейшие действия на сайте возможны только после него.';
        } catch (Exception $e) {
            $LOG->error("Something went wrong: $e");
        }
    } else {

        $pass = hash('sha256', $_POST['password']);
        $email = hash('md5', $_POST['email']);

        $user = $pdo->query(
            "SELECT * FROM `User` WHERE `email` = \"{$_POST['email']}\" AND `password` = \"$pass\""
        );
        $user = $user->fetch();
        if ($user) {
            if (!$user['check_email']) {
                echo 'Вы не подтвердили адрес электронной почты.<br/>
                      Просим Вас ответить на высланное письмо';
            } else {
                header("Location: check_user.php?email=$email");
            }
        } else {
            echo 'Неверные логин или пароль';
        }
    }

