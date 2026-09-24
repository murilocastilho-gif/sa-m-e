<?php 
require_once 'conexao.php';
require_once 'cabecalho.php';

$stmt = $pdo->query("SELECT * FROM usuarios");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Gerenciamento de Usuários</h2>
    <a href="tela-cadastro-user.php" class="btn btn-primary">+ Novo Usuário</a>
</div>

<?php if (isset($_GET['sucesso'])): ?>
    <div class="alert alert-success">Operação realizada com sucesso!</div>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>E-mail</th>
                    <th>Perfil</th>
                    <th>Status</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($usuarios)): ?>
                    <?php foreach ($usuarios as $u): 
                        $id     = $u['id'] ?? $u['id_usuario'] ?? '';
                        $nome   = $u['nome'] ?? '';
                        $cpf    = $u['cpf'] ?? '';
                        $email  = $u['email'] ?? '';
                        $perfil = $u['perfil'] ?? $u['perfil_acesso'] ?? 'Indefinido';
                        $status = $u['status'] ?? 'Inativo';
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($id); ?></td>
                            <td><?= htmlspecialchars($nome); ?></td>
                            <td><?= htmlspecialchars($cpf); ?></td>
                            <td><?= htmlspecialchars($email); ?></td>
                            <td>
                                <span class="badge bg-<?= ($perfil === 'Administrador') ? 'danger' : 'info'; ?>">
                                    <?= htmlspecialchars($perfil); ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-<?= ($status === 'Ativo') ? 'success' : 'secondary'; ?>">
                                    <?= htmlspecialchars($status); ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="tela-editar-user.php?id=<?= $id; ?>" class="btn btn-sm btn-warning">Editar</a>
                                <a href="processa-exclusao-user.php?id=<?= $id; ?>" 
                                   class="btn btn-sm btn-danger" 
                                   onclick="return confirm('Confirma a exclusão deste utilizador?');">
                                    Excluir
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted p-3">Nenhum utilizador cadastrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once 'rodape.php'; ?>