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

$nomeUsuario   = $_SESSION['nome'] ?? 'Operador';
$perfilUsuario = $_SESSION['perfil'] ?? 'Usuario';
$ehAdmin       = (strcasecmp($perfilUsuario, 'Administrador') === 0);

$totalUsuarios = 0;
$totalTrens    = 0;
$totalRotas    = 0;
$totalSensores = 0;

if ($conexao && !$conexao->connect_error) {
    if ($ehAdmin) {
        if ($resT = $conexao->query("SELECT COUNT(*) as total FROM trens")) { $totalTrens = $resT->fetch_assoc()['total']; }
        if ($resR = $conexao->query("SELECT COUNT(*) as total FROM rotas")) { $totalRotas = $resR->fetch_assoc()['total']; }
        if ($resU = $conexao->query("SELECT COUNT(*) as total FROM usuarios")) { $totalUsuarios = $resU->fetch_assoc()['total']; }

        $resS = $conexao->query("SHOW TABLES LIKE 'sensores'");
        if ($resS && $resS->num_rows > 0) {
            if ($resSen = $conexao->query("SELECT COUNT(*) as total FROM sensores")) { $totalSensores = $resSen->fetch_assoc()['total']; }
        }
    }

    $sqlRotas = "SELECT r.*, t.nome_trem, t.status AS status_trem 
                 FROM rotas r 
                 LEFT JOIN trens t ON r.id_trem = t.id_trem 
                 ORDER BY r.id_rota DESC LIMIT 6";
    $resultadoRotas = $conexao->query($sqlRotas);
} else {
    $resultadoRotas = false;
}
?>

<style>
    .hero-banner {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        border-radius: 18px;
        color: #ffffff;
        padding: 32px;
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.18);
        border: 1px solid #334155;
        margin-bottom: 32px;
    }

    .hero-title {
        font-size: 1.85rem;
        font-weight: 800;
        letter-spacing: -0.5px;
    }

    .card-metric {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 24px;
        transition: all 0.25s ease;
        box-shadow: 0 4px 12px rgba(0,0,0,0.03);
    }

    .metric-icon-box {
        width: 54px;
        height: 54px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .metric-number {
        font-size: 2.1rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.1;
    }

    .metric-label {
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: #64748b;
    }

    .card-admin-module {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 24px;
        transition: all 0.25s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .table-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        overflow: hidden;
    }
</style>

<div class="hero-banner d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <div class="hero-title mb-1">
            <i class="fa-solid fa-house-user text-info me-2"></i> 
            <?php echo $ehAdmin ? 'Painel Geral de Controle' : 'Central de Consultas Ferroviárias'; ?>
        </div>
        <p class="mb-0 text-slate-300 opacity-75">
            Bem-vindo(a), <strong><?php echo htmlspecialchars($nomeUsuario); ?></strong>.
            <?php if ($ehAdmin): ?>
                Você possui privilégios de <span class="badge bg-danger">Administrador</span> do sistema.
            <?php else: ?>
                Consulte aqui as rotas e os trechos ferroviários disponíveis no Ferrorama.
            <?php endif; ?>
        </p>
    </div>

    <?php if ($ehAdmin): ?>
        <div class="d-flex gap-2">
            <a href="tela-cadastro-user.php" class="btn btn-outline-light rounded-3 fw-semibold">
                <i class="fa-solid fa-user-plus me-1"></i> Cadastrar Usuário
            </a>
            <a href="tela-cadastro-rota.php" class="btn btn-info text-white rounded-3 fw-semibold">
                <i class="fa-solid fa-circle-plus me-1"></i> Nova Rota
            </a>
        </div>
    <?php else: ?>
        <a href="tela-tela-lista-rotas.php" class="btn btn-info text-white rounded-3 fw-semibold px-4 py-2">
            <i class="fa-solid fa-magnifying-glass me-2"></i> Ver Todas as Rotas
        </a>
    <?php endif; ?>
</div>

<?php if ($ehAdmin): ?>
    <div class="row g-4 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card-metric">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="metric-label">Trens Cadastrados</div>
                        <div class="metric-number mt-1"><?php echo $totalTrens; ?></div>
                    </div>
                    <div class="metric-icon-box bg-primary-subtle text-primary">
                        <i class="fa-solid fa-train"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card-metric">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="metric-label">Rotas Mapeadas</div>
                        <div class="metric-number mt-1"><?php echo $totalRotas; ?></div>
                    </div>
                    <div class="metric-icon-box bg-success-subtle text-success">
                        <i class="fa-solid fa-route"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card-metric">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="metric-label">Sensores Ativos</div>
                        <div class="metric-number mt-1"><?php echo $totalSensores; ?></div>
                    </div>
                    <div class="metric-icon-box bg-warning-subtle text-warning-emphasis">
                        <i class="fa-solid fa-tower-observation"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card-metric">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="metric-label">Usuários Cadastrados</div>
                        <div class="metric-number mt-1"><?php echo $totalUsuarios; ?></div>
                    </div>
                    <div class="metric-icon-box bg-info-subtle text-info">
                        <i class="fa-solid fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="table-card mb-5">
    <div class="p-4 border-bottom bg-white d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div>
            <h5 class="fw-bold text-dark mb-1"><i class="fa-solid fa-route text-primary me-2"></i>Rotas Disponíveis</h5>
            <p class="text-muted small mb-0">Confira a lista de linhas e trajetos operacionais.</p>
        </div>
        <a href="tela-tela-lista-rotas.php" class="btn btn-outline-secondary btn-sm rounded-3 fw-semibold">
            Ver Lista Completa <i class="fa-solid fa-arrow-right ms-1"></i>
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr class="text-secondary small fw-bold">
                    <th class="ps-4">ID</th>
                    <th>NOME DA ROTA</th>
                    <th>ORIGEM ➔ DESTINO</th>
                    <th>DISTÂNCIA</th>
                    <th>TEMPO EST.</th>
                    <th>TREM ATRIBUÍDO</th>
                    <?php if ($ehAdmin): ?>
                        <th class="text-end pe-4">AÇÕES</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php if ($resultadoRotas && $resultadoRotas->num_rows > 0): ?>
                    <?php while ($rota = $resultadoRotas->fetch_assoc()): ?>
                        <tr>
                            <td class="ps-4 fw-bold text-secondary">#<?php echo $rota['id_rota']; ?></td>
                            <td class="fw-bold text-dark"><?php echo htmlspecialchars($rota['nome_rota']); ?></td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    <?php echo htmlspecialchars($rota['origem']); ?> 
                                    <i class="fa-solid fa-arrow-right-long text-primary mx-1"></i> 
                                    <?php echo htmlspecialchars($rota['destino']); ?>
                                </span>
                            </td>
                            <td class="fw-medium"><?php echo number_format($rota['distancia_km'], 1, ',', '.'); ?> km</td>
                            <td class="fw-medium"><i class="fa-regular fa-clock text-muted me-1"></i><?php echo $rota['tempo_estimado_min']; ?> min</td>
                            <td>
                                <?php if (!empty($rota['nome_trem'])): ?>
                                    <span class="text-dark fw-semibold"><i class="fa-solid fa-train text-secondary me-1"></i><?php echo htmlspecialchars($rota['nome_trem']); ?></span>
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
                            <i class="fa-solid fa-folder-open fa-2x mb-2 d-block text-secondary"></i>
                            Nenhuma rota registrada até o momento.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php if ($ehAdmin): ?>
    <div class="mb-4">
        <h5 class="fw-bold text-dark mb-1"><i class="fa-solid fa-cubes-stacked text-primary me-2"></i>Módulos Administrativos</h5>
        <p class="text-muted small">Acesso rápido aos painéis de gerenciamento do Ferrorama.</p>
    </div>

    <div class="row g-4">
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card-admin-module">
                <div>
                    <div class="metric-icon-box bg-primary-subtle text-primary mb-3">
                        <i class="fa-solid fa-train"></i>
                    </div>
                    <h6 class="fw-bold text-dark mb-2">Frota de Trens</h6>
                    <p class="text-muted small">Cadastre locomotivas, inspecione velocidades e status.</p>
                </div>
                <a href="tala-lista-de-trens.php" class="btn btn-primary btn-sm w-100 fw-semibold mt-3">
                    Acessar Trens <i class="fa-solid fa-chevron-right ms-1 small"></i>
                </a>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-3">
            <div class="card-admin-module">
                <div>
                    <div class="metric-icon-box bg-success-subtle text-success mb-3">
                        <i class="fa-solid fa-map-location-dot"></i>
                    </div>
                    <h6 class="fw-bold text-dark mb-2">Gestão de Rotas</h6>
                    <p class="text-muted small">Gerencie origens, destinos, distâncias e trens.</p>
                </div>
                <a href="tela-tela-lista-rotas.php" class="btn btn-outline-success btn-sm w-100 fw-semibold mt-3">
                    Acessar Rotas <i class="fa-solid fa-chevron-right ms-1 small"></i>
                </a>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-3">
            <div class="card-admin-module">
                <div>
                    <div class="metric-icon-box bg-warning-subtle text-warning-emphasis mb-3">
                        <i class="fa-solid fa-tower-observation"></i>
                    </div>
                    <h6 class="fw-bold text-dark mb-2">Telemetria & Sensores</h6>
                    <p class="text-muted small">Monitore dados de sensores e cruzamentos.</p>
                </div>
                <a href="tela-lista-sensores.php" class="btn btn-outline-warning btn-sm w-100 fw-semibold text-dark mt-3">
                    Acessar Sensores <i class="fa-solid fa-chevron-right ms-1 small"></i>
                </a>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-3">
            <div class="card-admin-module">
                <div>
                    <div class="metric-icon-box bg-info-subtle text-info mb-3">
                        <i class="fa-solid fa-user-gear"></i>
                    </div>
                    <h6 class="fw-bold text-dark mb-2">Usuários & Acessos</h6>
                    <p class="text-muted small">Controle de credenciais e perfis do sistema.</p>
                </div>
                <a href="tela-lista-usuarios.php" class="btn btn-outline-info btn-sm w-100 fw-semibold mt-3">
                    Acessar Usuários <i class="fa-solid fa-chevron-right ms-1 small"></i>
                </a>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/rodape.php'; ?>