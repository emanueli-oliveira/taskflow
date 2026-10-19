
<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../src/helpers/response.php';
require_once __DIR__ . '/../../src/helpers/validate.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(false, 'Método não permitido.', null, 405);
}

$dados = json_decode(file_get_contents('php://input'), true);

if (!is_array($dados)) {
    json_response(false, 'JSON inválido.', null, 400);
}

try {
    // Validar os dados recebidos
    $erros = validar_cadastro($dados);

    if (!empty($erros)) {
        json_response(false, 'Dados inválidos.', ['erros' => $erros], 422);
    }

    // Verificar se o e-mail já está cadastrado
    $sql = 'SELECT id FROM users WHERE email = :email';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $dados['email']]);

    if ($stmt->fetch()) {
        json_response(false, 'Este e-mail já está cadastrado.', null, 409);
    }

    // Gerar o hash da senha
    $senhaHash = password_hash(
        $dados['senha'],
        PASSWORD_DEFAULT
    );

    // Inserir o usuário no banco de dados
    $sql = 'INSERT INTO users (nome, email, senha_hash)
            VALUES (:nome, :email, :senha_hash)
            RETURNING id, nome, email';

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'nome' => trim($dados['nome']),
        'email' => $dados['email'],
        'senha_hash' => $senhaHash
    ]);

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    json_response(
        true,
        'Usuário cadastrado com sucesso.',
        ['usuario' => $usuario],
        201
    );

} catch (PDOException $e) {
    // Não revelar detalhes internos do banco
    error_log($e->getMessage());

    json_response(false, 'Erro interno ao cadastrar usuário.', null, 500);
}
