<?php 
require_once 'conexao.php';
require_once 'cabecalho.php';

$mensagem = '';
$tipoAlert = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome   = trim(filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS));
    $cpf    = trim(filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_SPECIAL_CHARS));
    $email  = trim(filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL));
    $senha  = $_POST['senha'] ?? '';
    $perfil = $_POST['perfil'] ?? '';
    $status = $_POST['status'] ?? 'Ativo';

    if (empty($nome) || empty($cpf) || !$email || empty($senha) || empty($perfil)) {
        $mensagem = "Preencha todos os campos obrigatórios corretamente.";
        $tipoAlert = "danger";
    } elseif (strlen($senha) < 6) {
        $mensagem = "A palavra-passe deve ter pelo menos 6 caracteres.";
        $tipoAlert = "warning";
    } else {
        try {
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

            $sql = "INSERT INTO usuarios (nome, cpf, email, senha, perfil, status) 
                    VALUES (:nome, :cpf, :email, :senha, :perfil, :status)";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':nome'   => $nome,
                ':cpf'    => $cpf,
                ':email'  => $email,
                ':senha'  => $senhaHash,
                ':perfil' => $perfil,
                ':status' => $status
            ]);

            header("Location: tela-lista-usuarios.php?sucesso=cadastro");
            exit;

        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $mensagem = "O CPF ou E-mail informado já está registado.";
            } else {
                error_log($e->getMessage());
                $mensagem = "Erro ao guardar utilizador no banco de dados.";
            }
            $tipoAlert = "danger";
        }
    }
}
?>

<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Cadastro de Usuário</h4>
    </div>
    <div class="card-body">
        <?php if (!empty($mensagem)): ?>
            <div class="alert alert-<?= $tipoAlert; ?>" role="alert">
                <?= htmlspecialchars($mensagem); ?>
            </div>
        <?php endif; ?>

        <form action="tela-cadastro-user.php" method="POST">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nome Completo *</label>
                    <input type="text" class="form-control" name="nome" required minlength="3">
                </div>
                <div class="col-md-6">
                    <label class="form-label">CPF *</label>
                    <input type="text" class="form-control" name="cpf" placeholder="000.000.000-00" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">E-mail *</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Senha *</label>
                    <input type="password" class="form-control" name="senha" required minlength="6">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Perfil de Acesso *</label>
                    <select class="form-select" name="perfil" required>
                        <option value="" selected disabled>Selecione...</option>
                        <option value="Administrador">Administrador</option>
                        <option value="Operador">Operador</option>
                        <option value="Comprador">Comprador</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status *</label>
                    <select class="form-select" name="status" required>
                        <option value="Ativo" selected>Ativo</option>
                        <option value="Inativo">Inativo</option>
                    </select>
                </div>
            </div>
            <div class="mt-4 text-end">
                <a href="tela-lista-usuarios.php" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-success">Salvar</button>
            </div>
        </form>
    </div>
</div>

<?php require_once 'rodape.php'; ?>