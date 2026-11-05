PHP
<?php 
require_once 'conexao.php';
require_once 'cabecalho.php';

if (!isset($_SESSION['id_usuario']) || empty($_SESSION['id_usuario'])) {
    header('Location: tela-login.php');
    exit();
}
$stmt = $pdo->query("SELECT * FROM usuarios");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="card border-0 shadow-sm rounded-4 mb-4" style="border-left: 5px solid #0d6efd !important;">
    <div class="card-body p-4 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="fw-bold mb-1"><i class="fa-solid fa-users text-primary me-2"></i>Gerenciamento de Usuários</h4>
            <p class="text-muted small mb-0">Controle de credenciais, perfis e privilégios de acesso do sistema.</p>
        </div>
        <a href="tela-cadastro-user.php" class="btn btn-primary rounded-3 fw-semibold">
            <i class="fa-solid fa-user-plus me-1"></i> Novo Usuário
        </a>
    </div>
</div>

<?php if (isset($_GET['sucesso'])): ?>
    <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
        <i class="fa-solid fa-circle-check me-2"></i>Operação realizada com sucesso!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">#</th>
                    <th>NOME</th>
                    <th>CPF</th>
                    <th>E-MAIL</th>
                    <th class="text-center">PERFIL</th>
                    <th class="text-center">STATUS</th>
                    <th class="text-center pe-4">AÇÕES</th>
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
                            <td class="ps-4 fw-bold text-muted">#<?= htmlspecialchars($id); ?></td>
                            <td class="fw-semibold"><?= htmlspecialchars($nome); ?></td>
                            <td><?= htmlspecialchars($cpf); ?></td>
                            <td><?= htmlspecialchars($email); ?></td>
                            <td class="text-center">
                                <span class="badge bg-<?= ($perfil === 'Administrador') ? 'danger' : 'primary'; ?>">
                                    <?= htmlspecialchars($perfil); ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-<?= ($status === 'Ativo') ? 'success' : 'secondary'; ?>">
                                    <?= htmlspecialchars($status); ?>
                                </span>
                            </td>
                            <td class="text-center pe-4">
                                <a href="tela-editar-user.php?id=<?= $id; ?>" class="btn btn-sm btn-outline-primary me-1" title="Editar Usuário">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a href="processa-exclusao-user.php?id=<?= $id; ?>" 
                                   class="btn btn-sm btn-outline-danger" 
                                   title="Excluir Usuário"
                                   onclick="return confirm('Confirma a exclusão deste usuário?');">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted p-4">
                            <i class="fa-solid fa-user-slash fa-2x mb-2 d-block opacity-50"></i>
                            Nenhum usuário cadastrado no sistema.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once 'rodape.php'; ?>