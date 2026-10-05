<?php

function json_response(
    bool $sucesso,
    string $mensagem,
    mixed $dados = null,
    int $codigo = 200
): void {
    // TODO 1: definir o status HTTP
    http_response_code($codigo);
    // TODO 2: enviar Content-Type de JSON com UTF-8

    $resposta = [
        'sucesso' => $sucesso,
        'mensagem' => $mensagem,
    ];

    // TODO 3: incluir dados somente quando não forem null
    if ($dados !== null) {
        $resposta['dados'] = $dados;
    }
    // TODO 4: codificar o array em JSON sem escapar acentos
    echo json_encode($resposta, JSON_UNESCAPED_UNICODE);
    // TODO 5: encerrar a execução
    exit();
}