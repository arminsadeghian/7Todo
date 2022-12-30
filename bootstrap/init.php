<?php

require __DIR__ . '/../vendor/autoload.php';

require __DIR__ . '/../helpers/helpers.php';

require __DIR__ . '/../vendor/larapack/dd/src/helper.php';

try {
    // Load env file
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
} catch (\Dotenv\Exception\InvalidPathException $e) {
    dd('Create .env file');
}

// Database configs
require __DIR__ . '/../configs/database.php';

try {
    // PDO database connection
    $pdo = new PDO("mysql:dbname={$database_config->database};host={$database_config->host}", $database_config->username, $database_config->password);
} catch (PDOException $e) {
    dd('Connection failed: ' . $e->getMessage());
}

require __DIR__ . '/../libs/lib-tasks.php';

require __DIR__ . '/../libs/lib-auth.php';

require __DIR__ . '/../configs/app.php';
