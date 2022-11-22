<?php

    require_once 'settings.php';

    try {
        global $pdo;
        $pdo = new PDO(
            "mysql:host={$_ENV['DB_HOST']};
            dbname={$_ENV['DB_NAME']};
            port={$_ENV['DB_PORT']}", 
            "{$_ENV['DB_USER']}", 
            "{$_ENV['DB_PASSWORD']}"
        );

        $dir = new DirectoryIterator($parent_dir . '/migrations');
        foreach ($dir as $file) {
            if (!$file->isDot()) {
                $sql = file_get_contents($file->getRealPath());
                $pdo->exec($sql);
            }
        }

    } catch(PDOException $ex) {
        $LOG->error("Невозможно установить соединение с бд: $ex");
    }
