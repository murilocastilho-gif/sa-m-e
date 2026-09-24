<?php
ob_start();
session_start();

// Localiza o ficheiro conexao.php
$caminhoConexao = file_exists('../conexao.php') ? '../conexao.php' : (file_exists('conexao.php') ? 'conexao.php' : null);

if ($caminhoConexao) {
    require_once $caminhoConexao;
} else {
    die("Erro: O ficheiro conexao.php não foi encontrado.");
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    if (!empty($email) && !empty($senha)) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
            $stmt->execute([':email' => $email]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario) {
                if ($usuario['status'] !== 'Ativo') {
                    $erro = "A sua conta está inativa. Contacte o administrador.";
                } else {
                    $senhaValida = ($senha === $usuario['senha']) || password_verify($senha, $usuario['senha']);

                    if ($senhaValida) {
                        $_SESSION['logado']         = true;
                        $_SESSION['usuario_id']     = $usuario['id_usuario'];
                        $_SESSION['usuario_nome']   = $usuario['nome'];
                        $_SESSION['usuario_perfil'] = $usuario['perfil'];

                        // Redireciona para a lista de utilizadores
                        if (file_exists('tela-lista-usuarios.php')) {
                            header("Location: tela-lista-usuarios.php");
                        } elseif (file_exists('tela-lista-usuario.php')) {
                            header("Location: tela-lista-usuario.php");
                        } else {
                            header("Location: tela-lista-usuarios.php");
                        }
                        exit;
                    } else {
                        $erro = "Senha incorreta!";
                    }
                }
            } else {
                $erro = "E-mail não registado no sistema!";
            }
        } catch (PDOException $e) {
            $erro = "Erro no banco de dados: " . $e->getMessage();
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
        <div class="alert alert-danger py-2 text-center" role="alert">
            <?= htmlspecialchars($erro); ?>
        </div>
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

        <div class="text-center mt-3">
            <small>Ainda não tem uma conta? <a href="tela-cadastro-user.php" class="text-decoration-none">Cadastrar-se</a></small>
        </div>
    </form>
</div>

</body>
</html>