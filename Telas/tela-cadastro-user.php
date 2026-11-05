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
                    $_SESSION['mensagem_sucesso'] = "Usuário cadastrado com sucesso! Faça login para acessar.";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light d-flex align-items-center justify-content-center min-vh-100 py-5">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-primary text-white p-3 d-flex align-items-center justify-content-between">
                    <h4 class="fw-bold mb-0 fs-5"><i class="fa-solid fa-user-plus me-2"></i>Cadastro de Usuário</h4>
                    <span class="badge bg-light text-primary">Ferrorama</span>
                </div>

                <div class="card-body p-4">
                    <?php if (!empty($mensagemErro)): ?>
                        <div class="alert alert-danger py-2 mb-3 rounded-3 small text-center" role="alert">
                            <?php echo htmlspecialchars($mensagemErro); ?>
                        </div>
                    <?php endif; ?>

                    <form action="" method="POST" autocomplete="off">
                        <!-- DADOS PESSOAIS -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="nome" class="form-label fw-semibold small">Nome Completo *</label>
                                <input type="text" id="nome" name="nome" class="form-control" required placeholder="Digite o nome completo">
                            </div>

                            <div class="col-md-6">
                                <label for="cpf" class="form-label fw-semibold small">CPF</label>
                                <input type="text" id="cpf" name="cpf" class="form-control" maxlength="14" placeholder="000.000.000-00" oninput="mascaraCPF(this)">
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold small">E-mail *</label>
                                <input type="email" id="email" name="email" class="form-control" required placeholder="seu_email@exemplo.com">
                            </div>

                            <div class="col-md-6">
                                <label for="senha" class="form-label fw-semibold small">Senha *</label>
                                <input type="password" id="senha" name="senha" class="form-control" required placeholder="••••••••" autocomplete="new-password">
                            </div>
                        </div>

                        <!-- ENDEREÇO & API VIACEP (ETAPA 10) -->
                        <hr class="text-muted my-4">
                        <h6 class="fw-bold text-secondary mb-3"><i class="fa-solid fa-location-dot me-2"></i>Endereço Operacional (Busca Automática por CEP)</h6>

                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label for="cep" class="form-label fw-semibold small">CEP</label>
                                <input type="text" id="cep" name="cep" class="form-control" placeholder="00000-000" maxlength="9" onblur="buscarCEP()">
                                <small id="cep-erro" class="text-danger fw-semibold" style="font-size: 0.75rem;"></small>
                            </div>

                            <div class="col-md-8">
                                <label for="logradouro" class="form-label fw-semibold small">Logradouro / Rua</label>
                                <input type="text" id="logradouro" name="logradouro" class="form-control" placeholder="Preenchido automaticamente via CEP">
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-5">
                                <label for="bairro" class="form-label fw-semibold small">Bairro</label>
                                <input type="text" id="bairro" name="bairro" class="form-control" placeholder="Bairro">
                            </div>

                            <div class="col-md-5">
                                <label for="cidade" class="form-label fw-semibold small">Cidade</label>
                                <input type="text" id="cidade" name="cidade" class="form-control" placeholder="Cidade">
                            </div>

                            <div class="col-md-2">
                                <label for="estado" class="form-label fw-semibold small">UF</label>
                                <input type="text" id="estado" name="estado" class="form-control text-center" placeholder="SC" maxlength="2">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 pt-2">
                            <a href="tela-lista-usuarios.php" class="btn btn-secondary px-4 fw-semibold">Cancelar</a>
                            <button type="submit" class="btn btn-success px-4 fw-semibold"><i class="fa-solid fa-floppy-disk me-1"></i>Salvar</button>
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

<!-- INTEGRAÇÃO COM API VIACEP E BOOTSTRAP -->
<script src="../JavaScript/cep.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>