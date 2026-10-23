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

$mensagemErro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome   = trim($_POST['nome'] ?? '');
    $cpf    = trim($_POST['cpf'] ?? '');
    $email  = trim($_POST['email'] ?? '');
    $senha  = trim($_POST['senha'] ?? '');

    $perfil = 'Usuario';
    $status = 'Ativo';

    $cpfApenasNumeros = preg_replace('/[^0-9]/', '', $cpf);

    if (empty($nome) || empty($email) || empty($senha)) {
        $mensagemErro = "Por favor, preencha todos os campos obrigatórios (*).";
    } elseif (!empty($cpf) && strlen($cpfApenasNumeros) !== 11) {
        $mensagemErro = "O CPF deve conter exatamente 11 números.";
    } else {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $stmt = $conexao->prepare("INSERT INTO usuarios (nome, cpf, email, senha, perfil, status) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("ssssss", $nome, $cpf, $email, $senhaHash, $perfil, $status);

            try {
                if ($stmt->execute()) {
                    $_SESSION['mensagem_sucesso'] = "Usuário cadastrado com sucesso! Faça login para aceder.";
                    header('Location: tela-login.php');
                    exit();
                } else {
                    $mensagemErro = "Erro ao cadastrar usuário.";
                }
            } catch (mysqli_sql_exception $e) {
                if ($e->getCode() === 1062) {
                    $mensagemErro = "Este E-mail ou CPF já está cadastrado no sistema.";
                } else {
                    $mensagemErro = "Erro na base de dados: " . $e->getMessage();
                }
            }
            $stmt->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário - Ferrorama</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center min-vh-100 py-5">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-primary text-white p-3">
                    <h4 class="fw-bold mb-0">Cadastro de Usuário</h4>
                </div>

                <div class="card-body p-4">
                    <?php if (!empty($mensagemErro)): ?>
                        <div class="alert alert-danger py-2 mb-3 rounded-3 small text-center" role="alert">
                            <?php echo htmlspecialchars($mensagemErro); ?>
                        </div>
                    <?php endif; ?>

                    <form action="" method="POST" autocomplete="off">
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="nome" class="form-label fw-semibold small">Nome Completo *</label>
                                <input type="text" id="nome" name="nome" class="form-control" required placeholder="Digite o nome" autocomplete="off">
                            </div>

                            <div class="col-md-6">
                                <label for="cpf" class="form-label fw-semibold small">CPF</label>
                                <input type="text" id="cpf" name="cpf" class="form-control" maxlength="14" placeholder="000.000.000-00" oninput="mascaraCPF(this)" autocomplete="off">
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold small">E-mail *</label>
                                <input type="email" id="email" name="email" class="form-control" required placeholder="seu_email@exemplo.com" autocomplete="off">
                            </div>

                            <div class="col-md-6">
                                <label for="senha" class="form-label fw-semibold small">Senha *</label>
                                <input type="password" id="senha" name="senha" class="form-control" required placeholder="••••••••" autocomplete="new-password">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="tela-login.php" class="btn btn-secondary px-4 fw-semibold">Cancelar</a>
                            <button type="submit" class="btn btn-success px-4 fw-semibold">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function mascaraCPF(input) {
    let v = input.value.replace(/\D/g, "");
    if (v.length > 11) {
        v = v.slice(0, 11);
    }
    v = v.replace(/(\d{3})(\d)/, "$1.$2");
    v = v.replace(/(\d{3})(\d)/, "$1.$2");
    v = v.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
    input.value = v;
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>