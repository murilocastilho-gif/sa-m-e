<?php
session_start();
require_once 'conexao.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    if (!empty($email) && !empty($senha)) {
        try {
            // Procura o utilizador ativo pelo e-mail
            $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email AND status = 'Ativo'");
            $stmt->execute([':email' => $email]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario && ($senha === $usuario['senha'] || password_verify($senha, $usuario['senha']))) {
                $_SESSION['usuario_id']     = $usuario['id_usuario'];
                $_SESSION['usuario_nome']   = $usuario['nome'];
                $_SESSION['usuario_perfil'] = $usuario['perfil'];

                // Redireciona para a lista de utilizadores
                header("Location: tela-lista-usuarios.php");
                exit;
            } else {
                $erro = "E-mail ou senha incorretos (ou utilizador inativo).";
            }
        } catch (PDOException $e) {
            $erro = "Erro na base de dados: " . $e->getMessage();
        }
    } else {
        $erro = "Preencha todos os campos!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Ferrorama</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">

<div class="card shadow p-4" style="width: 100%; max-width: 400px;">
    <h2 class="text-center text-primary mb-4">Ferrorama</h2>

    <?php if (!empty($erro)): ?>
        <div class="alert alert-danger py-2"><?= htmlspecialchars($erro); ?></div>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Digite seu e-mail" required value="<?= htmlspecialchars($_POST['email'] ?? ''); ?>">
        </div>

        <div class="mb-3">
            <label for="senha" class="form-label">Senha</label>
            <input type="password" name="senha" id="senha" class="form-control" placeholder="Digite sua senha" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Entrar</button>
    </form>
</div>

</body>
</html>