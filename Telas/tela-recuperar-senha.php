<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/conexao.php';

if (!isset($conexao) || !($conexao instanceof mysqli)) {
    if (isset($conn) && $conn instanceof mysqli) {
        $conexao = $conn;
    } elseif (isset($mysqli) && $mysqli instanceof mysqli) {
        $conexao = $mysqli;
    } else {
        $conexao = @new mysqli('localhost', 'root', '', 'ferrorama');
    }
}

$etapa = 1;
$erro = '';
$sucesso = '';
$emailValidado = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';

    // ETAPA 1: Verificar se o e-mail existe
    if ($acao === 'verificar_email') {
        $email = trim($_POST['email'] ?? '');

        if (empty($email)) {
            $erro = "Por favor, informe o seu e-mail.";
        } else {
            $stmt = $conexao->prepare("SELECT id_usuario, email FROM usuarios WHERE email = ? LIMIT 1");
            if ($stmt) {
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $res = $stmt->get_result();

                if ($res && $res->num_rows === 1) {
                    $user = $res->fetch_assoc();
                    $emailValidado = $user['email'];
                    $etapa = 2;
                } else {
                    $erro = "E-mail não encontrado.";
                }
                $stmt->close();
            }
        }
    }

    // ETAPA 2: Redefinir a senha com criptografia
    if ($acao === 'redefinir_senha') {
        $email = trim($_POST['email'] ?? '');
        $nova_senha = trim($_POST['nova_senha'] ?? '');
        $confirmar_senha = trim($_POST['confirmar_senha'] ?? '');

        if (empty($nova_senha) || empty($confirmar_senha)) {
            $erro = "Preencha a nova senha e a confirmação.";
            $emailValidado = $email;
            $etapa = 2;
        } elseif ($nova_senha !== $confirmar_senha) {
            $erro = "As senhas não coincidem.";
            $emailValidado = $email;
            $etapa = 2;
        } else {
            // Gera o hash criptografado da nova senha
            $senhaHash = password_hash($nova_senha, PASSWORD_DEFAULT);

            $stmt = $conexao->prepare("UPDATE usuarios SET senha = ? WHERE email = ?");
            if ($stmt) {
                $stmt->bind_param("ss", $senhaHash, $email);
                $stmt->execute();
                $stmt->close();

                $sucesso = "Senha redefinida com sucesso!";
                $etapa = 3;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha - Ferrorama</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center min-vh-100 py-5">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-5 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-3">
                <div class="card-body">
                    <h3 class="text-primary fw-bold text-center mb-4">Recuperar Senha</h3>

                    <?php if (!empty($erro)): ?>
                        <div class="alert alert-danger py-2 mb-3 rounded-3 small text-center" role="alert">
                            <?php echo htmlspecialchars($erro); ?>
                        </div>
                    <?php endif; ?>

                    <!-- PASSO 1: INFORMAR O E-MAIL -->
                    <?php if ($etapa === 1): ?>
                        <form action="tela-recuperar-senha.php" method="POST">
                            <input type="hidden" name="acao" value="verificar_email">

                            <div class="mb-3">
                                <label for="email" class="form-label text-secondary small fw-semibold">E-mail</label>
                                <input type="email" id="email" name="email" class="form-control form-control-lg bg-light fs-6" required placeholder="muriloguima20@gmail.com">
                            </div>

                            <button type="submit" class="btn btn-primary w-100 fw-semibold py-2 mb-3">Continuar</button>

                            <div class="text-center">
                                <a href="tela-login.php" class="text-decoration-none small text-primary">Voltar ao Login</a>
                            </div>
                        </form>
                    <?php endif; ?>

                    <!-- PASSO 2: INFORMAR A NOVA SENHA -->
                    <?php if ($etapa === 2): ?>
                        <form action="tela-recuperar-senha.php" method="POST">
                            <input type="hidden" name="acao" value="redefinir_senha">
                            <input type="hidden" name="email" value="<?php echo htmlspecialchars($emailValidado); ?>">

                            <div class="mb-3">
                                <label for="nova_senha" class="form-label text-secondary small fw-semibold">Nova Senha</label>
                                <input type="password" id="nova_senha" name="nova_senha" class="form-control form-control-lg bg-light fs-6" required placeholder="••••">
                            </div>

                            <div class="mb-4">
                                <label for="confirmar_senha" class="form-label text-secondary small fw-semibold">Confirmar Senha</label>
                                <input type="password" id="confirmar_senha" name="confirmar_senha" class="form-control form-control-lg bg-light fs-6" required placeholder="••••">
                            </div>

                            <button type="submit" class="btn btn-primary w-100 fw-semibold py-2 mb-3">Redefinir Senha</button>

                            <div class="text-center">
                                <a href="tela-login.php" class="text-decoration-none small text-secondary">Cancelar</a>
                            </div>
                        </form>
                    <?php endif; ?>

                    <!-- PASSO 3: SUCESSO -->
                    <?php if ($etapa === 3): ?>
                        <div class="text-center py-2">
                            <div class="alert alert-success py-2 mb-3 small rounded-3">
                                <?php echo htmlspecialchars($sucesso); ?>
                            </div>
                            <a href="tela-login.php" class="btn btn-primary w-100 fw-semibold py-2">Ir para o Login</a>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>