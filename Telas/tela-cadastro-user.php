<?php 
require_once 'conexao.php';
require_once 'cabecalho.php';

$erroMsg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome   = $_POST['nome'] ?? '';
    $cpf    = $_POST['cpf'] ?? '';
    $email  = $_POST['email'] ?? '';
    $senha  = $_POST['senha'] ?? '';
    $perfil = $_POST['perfil'] ?? '';
    $status = $_POST['status'] ?? 'Ativo';

    try {
        $stmt = $pdo->prepare("INSERT INTO usuarios (nome, cpf, email, senha, perfil, status) VALUES (:nome, :cpf, :email, :senha, :perfil, :status)");
        
        $stmt->execute([
            ':nome'   => $nome,
            ':cpf'    => $cpf,
            ':email'  => $email,
            ':senha'  => $senha,
            ':perfil' => $perfil,
            ':status' => $status
        ]);

        header("Location: tela-lista-usuarios.php?sucesso=1");
        exit;

    } catch (PDOException $e) {
        $erroMsg = "Erro no MySQL: " . $e->getMessage();
    }
}
?>

<div class="card shadow-sm mt-3">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Cadastro de Usuário</h4>
    </div>
    <div class="card-body">

        <?php if (!empty($erroMsg)): ?>
            <div class="alert alert-danger mb-3">
                <?= htmlspecialchars($erroMsg); ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nome Completo *</label>
                    <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($_POST['nome'] ?? ''); ?>" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">CPF *</label>
                    <input type="text" name="cpf" class="form-control" placeholder="000.000.000-00" value="<?= htmlspecialchars($_POST['cpf'] ?? ''); ?>" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">E-mail *</label>
                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($_POST['email'] ?? ''); ?>" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Senha *</label>
                    <input type="password" name="senha" class="form-control" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Perfil de Acesso *</label>
                    <select name="perfil" class="form-select" required>
                        <option value="">Selecione...</option>
                        <option value="Administrador" <?= (($_POST['perfil'] ?? '') === 'Administrador') ? 'selected' : ''; ?>>Administrador</option>
                        <option value="Usuario" <?= (($_POST['perfil'] ?? '') === 'Usuario') ? 'selected' : ''; ?>>Usuário</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Status *</label>
                    <select name="status" class="form-select" required>
                        <option value="Ativo" <?= (($_POST['status'] ?? '') === 'Ativo') ? 'selected' : ''; ?>>Ativo</option>
                        <option value="Inativo" <?= (($_POST['status'] ?? '') === 'Inativo') ? 'selected' : ''; ?>>Inativo</option>
                    </select>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-3">
                <a href="tela-lista-usuarios.php" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-success">Salvar</button>
            </div>
        </form>
    </div>
</div>

<?php 
if (file_exists('rodape.php')) {
    require_once 'rodape.php';
} elseif (file_exists('rodape.php')) {
    require_once 'rodape.php';
}
?>