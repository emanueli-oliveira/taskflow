<?php

require_once __DIR__ . '/../../src/helpers/response.php';
require_once __DIR__ . '/../../config/database.php';

$metodo = $_SERVER['REQUEST_METHOD'];

if ($metodo !== 'GET') {
    // TODO: responder com erro e status 405 com a função json_response
    json_response(false, 'Método não permitido.', null, 405);
}


try {
    // TODO: preparar o $sql com o SELECT sem a coluna senha_hash
    $sql = 'SELECT id, nome, email FROM userss';
    $stmt = $pdo->prepare($sql);

    // TODO: executar a instrução
	$stmt->execute();
    // TODO: recuperar todas as linhas
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC); 

    // TODO: responder com os usuários utilizando a função json_response 
    json_response(true, 'Usuários recuperados com sucesso.', $usuarios, 200);
} catch (PDOException $e) {
    // TODO: responder com erro e status 500 com a função json_response
    json_response(false, 'Usuários não encotrados', null, 500);
}

