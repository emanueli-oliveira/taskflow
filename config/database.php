<?php

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
	 	PDO::ATTR_EMULATE_PREPARES
]);

} catch (PDOException $e) {
    // TODO 4: devolver erro genérico com status 500
    http_response_code(500);
    exit('Erro interno no servidor.');
}