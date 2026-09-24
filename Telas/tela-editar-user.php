<?php
session_start();

if (file_exists('../conexao.php')) {
    require_once '../conexao.php';
} elseif (file_exists('conexao.php')) {
    require_once 'conexao.php';
} else {
    die("Erro: O ficheiro conexao.php não foi encontrado.");
}

if (file_exists('cabecalho.php')) {
    require_once 'cabecalho.php';
} elseif (file_exists('../cabecalho.php')) {
    require_once '../cabecalho.php';
}

$erroMsg = '';

$id_usuario = $_GET['id'] ?? $_GET['id_usuario'] ?? null;

if (!$id_usuario) {
    header("Location: tela-lista-usuarios.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome   = trim($_POST['nome'] ?? '');
    $cpf    = trim($_POST['cpf'] ?? '');
    $email  = trim($_POST['email'] ?? '');
    $senha  = trim($_POST['senha'] ?? '');
    $perfil = $_POST['perfil'] ?? '';
    $status = $_POST['status'] ?? 'Ativo';

    try {
        if (!empty($senha)) {
            $sql = "UPDATE usuarios SET nome = :nome, cpf = :cpf, email = :email, senha = :senha, perfil = :perfil, status = :status WHERE id_usuario = :id";
            $params = [
                ':nome'   => $nome,
                ':cpf'    => $cpf,
                ':email'  => $email,
                ':senha'  => $senha,
                ':perfil' => $perfil,
                ':status' => $status,
                ':id'     => $id_usuario
            ];
        } else {
            $sql = "UPDATE usuarios SET nome = :nome, cpf = :cpf, email = :email, perfil = :perfil, status = :status WHERE id_usuario = :id";
            $params = [
                ':nome'   => $nome,
                ':cpf'    => $cpf,
                ':email'  => $email,
                ':perfil' => $perfil,
                ':status' => $status,
                ':id'     => $id_usuario
            ];
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        header("Location: tela-lista-usuarios.php?sucesso=2");
        exit;

    } catch (PDOException $e) {
        $erroMsg = "Erro no MySQL: " . $e->getMessage();
    }
}

try {
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id_usuario = :id");
    $stmt->execute([':id' => $id_usuario]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        header("Location: tela-lista-usuarios.php");
        exit;
    }
} catch (PDOException $e) {
    die("Erro ao buscar utilizador: " . $e->getMessage());
}
?>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Editar Usuário</h4>
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
                        <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($_POST['nome'] ?? $usuario['nome']); ?>" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">CPF *</label>
                        <input type="text" name="cpf" class="form-control" value="<?= htmlspecialchars($_POST['cpf'] ?? $usuario['cpf']); ?>" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">E-mail *</label>
                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($_POST['email'] ?? $usuario['email']); ?>" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Senha (Deixe em branco para não alterar)</label>
                        <input type="password" name="senha" class="form-control" placeholder="Nova senha opcional">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Perfil de Acesso *</label>
                        <select name="perfil" class="form-select" required>
                            <option value="Administrador" <?= (($usuario['perfil'] ?? '') === 'Administrador') ? 'selected' : ''; ?>>Administrador</option>
                            <option value="Usuario" <?= (($usuario['perfil'] ?? '') === 'Usuario') ? 'selected' : ''; ?>>Usuário</option>
                            <option value="Comprador" <?= (($usuario['perfil'] ?? '') === 'Comprador') ? 'selected' : ''; ?>>Comprador</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status *</label>
                        <select name="status" class="form-select" required>
                            <option value="Ativo" <?= (($usuario['status'] ?? '') === 'Ativo') ? 'selected' : ''; ?>>Ativo</option>
                            <option value="Inativo" <?= (($usuario['status'] ?? '') === 'Inativo') ? 'selected' : ''; ?>>Inativo</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-3">
                    <a href="tela-lista-usuarios.php" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-success">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php 
if (file_exists('rodape.php')) {
    require_once 'rodape.php';
} elseif (file_exists('../rodape.php')) {
    require_once '../rodape.php';
}
?>