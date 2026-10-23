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

$sql = "SELECT r.*, t.nome_trem, t.status AS status_trem 
        FROM rotas r 
        LEFT JOIN trens t ON r.id_trem = t.id_trem 
        ORDER BY r.id_rota DESC";

$resultado = ($conexao && !$conexao->connect_error) ? $conexao->query($sql) : false;
?>

<div class="row mb-4">
    <div class="col-12">
        <div class="p-4 bg-white rounded-3 shadow-sm border-start border-4 border-success d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h2 class="h3 fw-bold text-dark mb-1"><i class="fa-solid fa-map-location-dot text-success me-2"></i>Gestão de Rotas</h2>
                <p class="text-muted mb-0">Gerencie origens, destinos, distâncias e os trens atribuídos a cada rota.</p>
            </div>
            <?php if ($ehAdmin): ?>
                <a href="tela-cadastro-rota.php" class="btn btn-success fw-semibold px-3 py-2">
                    <i class="fa-solid fa-plus me-1"></i> Nova Rota
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
                        <th>NOME DA ROTA</th>
                        <th>ORIGEM ➔ DESTINO</th>
                        <th>DISTÂNCIA (KM)</th>
                        <th>TEMPO EST.</th>
                        <th>TREM ATRIBUÍDO</th>
                        <?php if ($ehAdmin): ?>
                            <th class="text-end pe-4">AÇÕES</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($resultado && $resultado->num_rows > 0): ?>
                        <?php while ($rota = $resultado->fetch_assoc()): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-secondary">#<?php echo $rota['id_rota']; ?></td>
                                <td>
                                    <strong class="text-dark"><?php echo htmlspecialchars($rota['nome_rota']); ?></strong>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border px-3 py-2">
                                        <i class="fa-solid fa-location-dot text-danger me-1"></i> <?php echo htmlspecialchars($rota['origem']); ?> 
                                        <i class="fa-solid fa-arrow-right-long text-success mx-2"></i> 
                                        <i class="fa-solid fa-location-flag text-primary me-1"></i> <?php echo htmlspecialchars($rota['destino']); ?>
                                    </span>
                                </td>
                                <td class="fw-bold text-dark">
                                    <i class="fa-solid fa-ruler-horizontal text-muted me-1"></i> <?php echo number_format($rota['distancia_km'], 1, ',', '.'); ?> km
                                </td>
                                <td class="fw-semibold text-secondary">
                                    <i class="fa-regular fa-clock text-warning me-1"></i> <?php echo $rota['tempo_estimado_min']; ?> min
                                </td>
                                <td>
                                    <?php if (!empty($rota['nome_trem'])): ?>
                                        <span class="text-dark fw-semibold"><i class="fa-solid fa-train text-primary me-1"></i><?php echo htmlspecialchars($rota['nome_trem']); ?></span>
                                    <?php else: ?>
                                        <span class="text-muted fst-italic">Nenhum trem vinculado</span>
                                    <?php endif; ?>
                                </td>
                                <?php if ($ehAdmin): ?>
                                    <td class="text-end pe-4">
                                        <a href="tela-cadastro-rota.php?id=<?php echo $rota['id_rota']; ?>" class="btn btn-light btn-sm text-primary me-1 border" title="Editar">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <a href="tela-exclusao-rota.php?id=<?php echo $rota['id_rota']; ?>" onclick="return confirm('Deseja realmente excluir esta rota?');" class="btn btn-light btn-sm text-danger border" title="Excluir">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </a>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="<?php echo $ehAdmin ? '7' : '6'; ?>" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-route fa-2x mb-2 d-block text-secondary"></i>
                                Nenhuma rota cadastrada no momento.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/rodape.php'; ?>