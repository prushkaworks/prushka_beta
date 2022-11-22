<?php
    $parent_dir = dirname(dirname(__FILE__));

    require_once realpath($parent_dir . '/vendor/autoload.php');

    use Monolog\Logger;
    use Monolog\Handler\StreamHandler;

    $dotenv = Dotenv\Dotenv::createImmutable($parent_dir);
    $dotenv->load();

    $LOG = new Logger(__FILE__);
    $handler = new StreamHandler('php://stdout', Logger::INFO);
    $LOG->pushHandler($handler);