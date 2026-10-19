
<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../src/helpers/response.php';
require_once __DIR__ . '/../../src/helpers/validate.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(false, 'Método não permitido.', null, 405);
}

$dados = json_decode(file_get_contents('php://input'), true);

if (!is_array($dados)) {
    json_response(false, 'JSON inválido.', null, 400);
}

try {
    // Validar os dados
    $erros = validar_login($dados);

    if (!empty($erros)) {
        json_response(false, 'Dados inválidos.', ['erros' => $erros], 422);
    }

    // Buscar o usuário pelo e-mail
    $sql = 'SELECT id, nome, email, senha_hash
            FROM users
            WHERE email = :email';

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'email' => trim($dados['email'])
    ]);

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Conferir a senha
    if (
        !$usuario ||
        !password_verify($dados['senha'], $usuario['senha_hash'])
    ) {
        json_response(false, 'E-mail ou senha inválidos.', null, 401);
    }

    // Regenerar o identificador da sessão
    session_regenerate_id(true);

    // Guardar os dados do usuário na sessão
    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['usuario_nome'] = $usuario['nome'];

    // Retornar sucesso sem expor a senha
    json_response(
        true,
        'Login realizado com sucesso.',
        [
            'usuario' => [
                'id' => $usuario['id'],
                'nome' => $usuario['nome'],
                'email' => $usuario['email']
            ]
        ]
    );

} catch (PDOException $e) {
    error_log($e->getMessage());

    json_response(false, 'Erro interno ao realizar login.', null, 500);
}
