
<?php

class Project
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function criar(
        string $nome,
        ?string $descricao,
        int $userId
    ): array {
        $sql = 'INSERT INTO projects (nome, descricao, user_id)
                VALUES (:nome, :descricao, :user_id)
                RETURNING id, nome, descricao, user_id';

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'nome' => $nome,
            'descricao' => $descricao,
            'user_id' => $userId
        ]);

        $projeto = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($projeto === false) {
            throw new RuntimeException(
                'Não foi possível obter o projeto criado.'
            );
        }

        return $projeto;
    }

    public function listar(int $userId): array
    {
        $sql = 'SELECT id, nome, descricao, user_id
                FROM projects
                WHERE user_id = :user_id
                ORDER BY id DESC';

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'user_id' => $userId
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
