<?php

require_once __DIR__ . '/../../src/helpers/response.php';
require_once __DIR__ . '/../../src/helpers/auth.php';
require_once __DIR__ . '/../../config/database.php';

verificar_autenticacao();

$metodo = $_SERVER['REQUEST_METHOD'];

if ($metodo !== 'GET') {
    // TODO: responder com erro e status 405 com a função json_response
    json_response(false, 'Método não permitido.', null, 405);
}


try {
    $sql = 'SELECT id, nome, email FROM users';
    $stmt = $pdo->prepare($sql);

    $stmt->execute();
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    json_response(true, 'Usuários recuperados com sucesso.', $usuarios);
} catch (PDOException $e) {
    error_log($e->getMessage());
    json_response(false, 'Erro interno ao buscar usuários.', null, 500);
}
