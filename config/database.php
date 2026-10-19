<?php

require_once __DIR__ . '/../src/helpers/response.php';

define('DB_HOST', 'localhost');
define('DB_PORT', '5432');
define('DB_NAME', 'taskflow_ee');
define('DB_USER', 'postgres');
define('DB_PASS', 'postgre');

try {
    // TODO 1: montar o DSN do PostgreSQL
    $dsn = 'pgsql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME;

    // TODO 2: criar $pdo com DSN usuário senha e opções 
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);

} catch (PDOException $e) {
    error_log($e->getMessage());
    json_response(false, 'Erro interno no servidor.', null, 500);
}