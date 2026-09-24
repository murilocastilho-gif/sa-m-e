<?php
require_once 'conexao.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: tela-lista-usuarios.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = :id OR id_usuario = :id");
$stmt->execute([':id' => $id]);
$u = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$u) {
    die("Utilizador não encontrado.");
}

$idVal     = $u['id'] ?? $u['id_usuario'] ?? '';
$nomeVal   = $u['nome'] ?? '';
$cpfVal    = $u['cpf'] ?? '';
$emailVal  = $u['email'] ?? '';
$perfilVal = $u['perfil'] ?? $u['perfil_acesso'] ?? 'Usuario';
$statusVal = $u['status'] ?? 'Ativo';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

<h2>Editar Usuário</h2>

<form action="processa-edicao-user.php" method="POST">
    <input type="hidden" name="id" value="<?= htmlspecialchars($idVal); ?>">

    <div class="mb-3">
        <label class="form-label">Nome Completo</label>
        <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($nomeVal); ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">CPF</label>
        <input type="text" name="cpf" class="form-control" value="<?= htmlspecialchars($cpfVal); ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">E-mail</label>
        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($emailVal); ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Perfil de Acesso</label>
        <select name="perfil" class="form-select">
            <option value="Administrador" <?= $perfilVal === 'Administrador' ? 'selected' : ''; ?>>Administrador</option>
            <option value="Usuario" <?= $perfilVal === 'Usuario' ? 'selected' : ''; ?>>Usuário</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
            <option value="Ativo" <?= $statusVal === 'Ativo' ? 'selected' : ''; ?>>Ativo</option>
            <option value="Inativo" <?= $statusVal === 'Inativo' ? 'selected' : ''; ?>>Inativo</option>
        </select>
    </div>

    <button type="submit" class="btn btn-success">Salvar Alterações</button>
    <a href="tela-lista-usuarios.php" class="btn btn-secondary">Cancelar</a>
</form>

</body>
</html>