
<?php

require_once __DIR__ . '/../../src/helpers/response.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(false, 'Método não permitido.', null, 405);
}

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Limpar os dados da sessão
$_SESSION = [];

// Excluir o cookie da sessão, se estiver em uso
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();

    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params['path'],
        $params['domain'],
        $params['secure'],
        $params['httponly']
    );
}

// Destruir a sessão
session_destroy();

// Responder que o logout foi concluído
json_response(true, 'Logout realizado com sucesso.');
