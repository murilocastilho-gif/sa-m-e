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

$sql = "SELECT * FROM sensores ORDER BY id_sensor DESC";
$resultado = ($conexao && !$conexao->connect_error) ? $conexao->query($sql) : false;
?>

<!-- BANNER DE SUCESSO -->
<?php if (isset($_GET['sucesso']) && $_GET['sucesso'] === 'excluido'): ?>
    <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert">
        <i class="fa-solid fa-circle-check me-2"></i>
        Sensor excluído com sucesso.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php elseif (isset($_GET['sucesso']) && $_GET['sucesso'] === 'salvo'): ?>
    <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert">
        <i class="fa-solid fa-circle-check me-2"></i>
        Sensor gravado com sucesso.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="row mb-4">
    <div class="col-12">
        <div class="p-4 bg-white rounded-3 shadow-sm border-start border-4 border-warning d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h2 class="h3 fw-bold text-dark mb-1"><i class="fa-solid fa-tower-observation text-warning me-2"></i>Telemetria & Sensores</h2>
                <p class="text-muted mb-0">Monitore dados de sensores, detecção de presença e cruzamentos da via.</p>
            </div>
            <?php if ($ehAdmin): ?>
                <a href="tela-cadastro-sensor.php" class="btn btn-warning text-dark fw-semibold px-3 py-2">
                    <i class="fa-solid fa-plus me-1"></i> Cadastrar Sensor
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
                        <th>NOME DO SENSOR</th>
                        <th>IDENTIFICAÇÃO</th>
                        <th>TIPO DE SENSOR</th>
                        <th>LOCALIZAÇÃO</th>
                        <th>STATUS</th>
                        <?php if ($ehAdmin): ?>
                            <th class="text-end pe-4">AÇÕES</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($resultado && $resultado->num_rows > 0): ?>
                        <?php while ($sensor = $resultado->fetch_assoc()): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-secondary">#<?php echo $sensor['id_sensor']; ?></td>
                                <td class="fw-bold text-dark"><?php echo htmlspecialchars($sensor['nome_sensor'] ?? $sensor['nome'] ?? 'Sensor'); ?></td>
                                <td><span class="badge bg-light text-dark border"><?php echo htmlspecialchars($sensor['identificacao'] ?? 'SNS-N/A'); ?></span></td>
                                <td class="fw-semibold text-secondary">
                                    <i class="fa-solid fa-microchip text-warning me-1"></i>
                                    <?php echo htmlspecialchars($sensor['tipo_sensor'] ?? $sensor['tipo'] ?? 'Presença'); ?>
                                </td>
                                <td><i class="fa-solid fa-location-dot text-danger me-1"></i> <?php echo htmlspecialchars($sensor['localizacao'] ?? 'Não especificada'); ?></td>
                                <td>
                                    <?php 
                                        $st = $sensor['status'] ?? 'Ativo';
                                        $bg = ($st === 'Ativo') ? 'bg-success' : (($st === 'Manutenção') ? 'bg-warning text-dark' : 'bg-secondary');
                                    ?>
                                    <span class="badge <?php echo $bg; ?> px-3 py-2 rounded-pill"><?php echo htmlspecialchars($st); ?></span>
                                </td>
                                <?php if ($ehAdmin): ?>
                                    <td class="text-end pe-4">
                                        <a href="tela-cadastro-sensor.php?id=<?php echo $sensor['id_sensor']; ?>" class="btn btn-light btn-sm text-primary me-1 border" title="Editar">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <a href="tela-exclusao-sensor.php?id=<?php echo $sensor['id_sensor']; ?>" onclick="return confirm('Deseja realmente excluir este sensor?');" class="btn btn-light btn-sm text-danger border" title="Excluir">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </a>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="<?php echo $ehAdmin ? '7' : '6'; ?>" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-tower-observation fa-2x mb-2 d-block text-secondary"></i>
                                Nenhum sensor cadastrado no sistema.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/rodape.php'; ?>