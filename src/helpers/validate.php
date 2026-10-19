<?php

function validar_cadastro(array $dados): array
{
    $erros = [];

    $nome = trim((string) ($dados['nome'] ?? ''));
    if ($nome === '') {
        $erros['nome'] = 'O nome é obrigatório.';
    }

    $email = trim((string) ($dados['email'] ?? ''));
    if ($email === '' || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $erros['email'] = 'Informe um e-mail válido.';
    }

    $senha = (string) ($dados['senha'] ?? '');
    if ($senha === '') {
        $erros['senha'] = 'A senha é obrigatória.';
    }

    return $erros;
}

function validar_login(array $dados): array
{
    $erros = [];

    $email = trim((string) ($dados['email'] ?? ''));
    if ($email === '' || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $erros['email'] = 'Informe um e-mail válido.';
    }

    $senha = (string) ($dados['senha'] ?? '');
    if ($senha === '') {
        $erros['senha'] = 'A senha é obrigatória.';
    }

    return $erros;
}
