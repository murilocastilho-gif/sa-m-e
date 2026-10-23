<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['id_usuario']) || empty($_SESSION['id_usuario'])) {
    header('Location: tela-login.php');
    exit();
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

require_once __DIR__ . '/cabecalho.php';

$ehAdmin = isset($_SESSION['perfil']) && (strcasecmp($_SESSION['perfil'], 'Administrador') === 0);

$sql = "SELECT * FROM trens ORDER BY id_trem DESC";
$resultado = ($conexao && !$conexao->connect_error) ? $conexao->query($sql) : false;
?>

<div class="row mb-4">
    <div class="col-12">
        <div class="p-4 bg-white rounded-3 shadow-sm border-start border-4 border-primary d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h2 class="h3 fw-bold text-dark mb-1"><i class="fa-solid fa-train text-primary me-2"></i>Frota de Trens</h2>
                <p class="text-muted mb-0">Cadastre locomotivas, inspecione velocidades máximas e o status operacional.</p>
            </div>
            <?php if ($ehAdmin): ?>
                <!-- Link apontando para o seu ficheiro real: tela-cadastro-trens.php -->
                <a href="tela-cadastro-trens.php" class="btn btn-primary fw-semibold px-3 py-2">
                    <i class="fa-solid fa-plus me-1"></i> Cadastrar Locomotiva
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr class="text-secondary small fw-bold">
                        <th class="ps-4">ID</th>
                        <th>NOME DA LOCOMOTIVA</th>
                        <th>MODELO</th>
                        <th>VELOCIDADE MÁXIMA</th>
                        <th>STATUS OPERACIONAL</th>
                        <?php if ($ehAdmin): ?>
                            <th class="text-end pe-4">AÇÕES</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($resultado && $resultado->num_rows > 0): ?>
                        <?php while ($trem = $resultado->fetch_assoc()): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-secondary">#<?php echo $trem['id_trem']; ?></td>
                                <td>
                                    <span class="fw-bold text-dark"><i class="fa-solid fa-locomotive text-primary me-2"></i><?php echo htmlspecialchars($trem['nome_trem']); ?></span>
                                </td>
                                <td><span class="badge bg-light text-dark border"><?php echo htmlspecialchars($trem['modelo'] ?? 'Locomotiva Padrão'); ?></span></td>
                                <td class="fw-semibold text-dark">
                                    <i class="fa-solid fa-gauge-high text-info me-1"></i> <?php echo htmlspecialchars($trem['velocidade_maxima'] ?? '80'); ?> km/h
                                </td>
                                <td>
                                    <?php 
                                        $status = $trem['status'] ?? 'Operacional';
                                        $bgClass = ($status === 'Operacional') ? 'bg-success' : (($status === 'Manutenção') ? 'bg-warning text-dark' : 'bg-secondary');
                                    ?>
                                    <span class="badge <?php echo $bgClass; ?> px-3 py-2 rounded-pill">
                                        <i class="fa-solid fa-circle me-1 small"></i> <?php echo htmlspecialchars($status); ?>
                                    </span>
                                </td>
                                <?php if ($ehAdmin): ?>
                                    <td class="text-end pe-4">
                                        <a href="tela-cadastro-trens.php?id=<?php echo $trem['id_trem']; ?>" class="btn btn-light btn-sm text-primary me-1 border" title="Editar">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <a href="tela-exclusao-trem.php?id=<?php echo $trem['id_trem']; ?>" onclick="return confirm('Deseja realmente excluir esta locomotiva?');" class="btn btn-light btn-sm text-danger border" title="Excluir">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </a>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="<?php echo $ehAdmin ? '6' : '5'; ?>" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-train fa-2x mb-2 d-block text-secondary"></i>
                                Nenhuma locomotiva cadastrada na frota.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/rodape.php'; ?>