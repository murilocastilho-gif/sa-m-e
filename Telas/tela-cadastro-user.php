<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (file_exists(__DIR__ . '/conexao.php')) {
    require __DIR__ . '/conexao.php';
}

if (!isset($conexao) || !($conexao instanceof mysqli)) {
    if (isset($conn) && $conn instanceof mysqli) {
        $conexao = $conn;
    } elseif (isset($mysqli) && $mysqli instanceof mysqli) {
        $conexao = $mysqli;
    } else {
        $conexao = @new mysqli('localhost', 'root', '', 'ferrorama');
    }
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome   = trim($_POST['nome'] ?? '');
    $cpf    = trim($_POST['cpf'] ?? '');
    $email  = trim($_POST['email'] ?? '');
    $senha  = trim($_POST['senha'] ?? '');
    $perfil = $_POST['perfil'] ?? 'Usuario';
    $status = $_POST['status'] ?? 'Ativo';

    if (empty($nome) || empty($email) || empty($senha)) {
        $erro = "Preencha todos os campos obrigatórios!";
    } elseif ($conexao->connect_error) {
        $erro = "Erro ao ligar à base de dados MySQL: " . $conexao->connect_error;
    } else {
        $stmtCheck = $conexao->prepare("SELECT id_usuario FROM usuarios WHERE email = ? LIMIT 1");
        
        if ($stmtCheck) {
            $stmtCheck->bind_param("s", $email);
            $stmtCheck->execute();
            $resCheck = $stmtCheck->get_result();

            if ($resCheck->num_rows > 0) {
                $erro = "Este e-mail já está cadastrado!";
            } else {
                $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

                $stmtInsert = $conexao->prepare("INSERT INTO usuarios (nome, cpf, email, senha, perfil, status) VALUES (?, ?, ?, ?, ?, ?)");
                
                if ($stmtInsert) {
                    $stmtInsert->bind_param("ssssss", $nome, $cpf, $email, $senhaHash, $perfil, $status);
                    
                    if ($stmtInsert->execute()) {
                        header('Location: tela-login.php');
                        exit();
                    } else {
                        $erro = "Erro ao guardar no banco de dados: " . $stmtInsert->error;
                    }
                } else {
                    $erro = "Erro na instrução INSERT: " . $conexao->error;
                }
            }
        } else {
            $erro = "Erro na instrução SELECT: " . $conexao->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário - Ferrorama</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body class="bg-light">

<div class="container mt-5" style="max-width: 600px;">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Cadastro de Usuário</h4>
        </div>
        <div class="card-body">

            <?php if (!empty($erro)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($erro); ?></div>
            <?php endif; ?>

            <form action="tela-cadastro-user.php" method="POST">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nome Completo *</label>
                        <input type="text" name="nome" class="form-control" required placeholder="Digite o nome">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">CPF</label>
                        <input type="text" name="cpf" class="form-control" placeholder="000.000.000-00">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">E-mail *</label>
                        <input type="email" name="email" class="form-control" required placeholder="Digite seu e-mail">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Senha *</label>
                        <input type="password" name="senha" class="form-control" required placeholder="Digite sua senha">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Perfil de Acesso *</label>
                        <select name="perfil" class="form-select">
                            <option value="Usuario" selected>Usuário</option>
                            <option value="Administrador">Administrador</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status *</label>
                        <select name="status" class="form-select">
                            <option value="Ativo" selected>Ativo</option>
                            <option value="Inativo">Inativo</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-3">
                    <a href="tela-login.php" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-success">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>