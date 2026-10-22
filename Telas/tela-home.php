<?php
require_once 'auth.php';
exigirAutenticacao();

require_once 'conexao.php';
require_once 'cabecalho.php';

$ehAdmin = isset($_SESSION['perfil']) && $_SESSION['perfil'] === 'Administrador';

$totalUsuarios = 0;
$totalTrens = 0;
$totalRotas = 0;
$totalSensores = 0;

$resU = $conexao->query("SELECT COUNT(*) as total FROM usuarios");
if ($resU) { $totalUsuarios = $resU->fetch_assoc()['total']; }

$resT = $conexao->query("SELECT COUNT(*) as total FROM trens");
if ($resT) { $totalTrens = $resT->fetch_assoc()['total']; }

$resR = $conexao->query("SELECT COUNT(*) as total FROM rotas");
if ($resR) { $totalRotas = $resR->fetch_assoc()['total']; }

$resS = $conexao->query("SHOW TABLES LIKE 'sensores'");
if ($resS && $resS->num_rows > 0) {
    $resSen = $conexao->query("SELECT COUNT(*) as total FROM sensores");
    if ($resSen) { $totalSensores = $resSen->fetch_assoc()['total']; }
}

$sqlRotas = "SELECT r.*, t.nome_trem, t.status AS status_trem 
             FROM rotas r 
             INNER JOIN trens t ON r.id_trem = t.id_trem 
             ORDER BY r.id_rota DESC";
$resultadoRotas = $conexao->query($sqlRotas);
?>

<div class="main-container">
    <div class="dashboard-header">
        <h1 class="dashboard-title">Painel Geral de Controle Ferroviário</h1>
        <p class="dashboard-subtitle">Central de gerenciamento, controle de rotas e telemetria do Ferrorama.</p>
    </div>

    <div class="grid-stats">
        <div class="card-stat stat-blue">
            <div class="card-stat-title">Trens Cadastrados</div>
            <div class="card-stat-value"><?php echo $totalTrens; ?></div>
        </div>

        <div class="card-stat stat-green">
            <div class="card-stat-title">Rotas Mapeadas</div>
            <div class="card-stat-value"><?php echo $totalRotas; ?></div>
        </div>

        <div class="card-stat stat-yellow">
            <div class="card-stat-title">Sensores Ativos</div>
            <div class="card-stat-value"><?php echo $totalSensores; ?></div>
        </div>

        <div class="card-stat stat-cyan">
            <div class="card-stat-title">Usuários Registrados</div>
            <div class="card-stat-value"><?php echo $totalUsuarios; ?></div>
        </div>
    </div>

    <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 40px;">
        <div class="page-header" style="margin-bottom: 15px;">
            <div>
                <h2 style="margin: 0; color: #2c3e50;">🗺️ Controle Operacional de Rotas</h2>
                <p style="margin: 5px 0 0 0; color: #666; font-size: 14px;">Monitoramento dos trechos ativos e trens vinculados.</p>
            </div>
            <?php if ($ehAdmin): ?>
                <a href="tela-cadastro-rota.php" class="btn-add">+ Nova Rota</a>
            <?php endif; ?>
        </div>

        <table class="table-custom">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome da Rota</th>
                    <th>Origem → Destino</th>
                    <th>Distância</th>
                    <th>Tempo Est.</th>
                    <th>Trem Vinculado</th>
                    <th>Status do Trem</th>
                    <?php if ($ehAdmin): ?>
                        <th>Ações</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php if ($resultadoRotas && $resultadoRotas->num_rows > 0): ?>
                    <?php while ($rota = $resultadoRotas->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $rota['id_rota']; ?></td>
                            <td><strong><?php echo htmlspecialchars($rota['nome_rota']); ?></strong></td>
                            <td><?php echo htmlspecialchars($rota['origem']); ?> ➔ <?php echo htmlspecialchars($rota['destino']); ?></td>
                            <td><?php echo number_format($rota['distancia_km'], 2, ',', '.'); ?> km</td>
                            <td><?php echo $rota['tempo_estimado_min']; ?> min</td>
                            <td>🚂 <?php echo htmlspecialchars($rota['nome_trem']); ?></td>
                            <td>
                                <span class="badge-perfil" style="background-color: <?php echo ($rota['status_trem'] === 'Operacional') ? '#28a745' : '#ffc107'; ?>;">
                                    <?php echo htmlspecialchars($rota['status_trem']); ?>
                                </span>
                            </td>
                            <?php if ($ehAdmin): ?>
                                <td>
                                    <a href="tela-cadastro-rota.php?id=<?php echo $rota['id_rota']; ?>" class="btn-action-edit">Editar</a>
                                    <a href="tela-exclusao-rota.php?id=<?php echo $rota['id_rota']; ?>" onclick="return confirm('Deseja realmente excluir esta rota?');" class="btn-action-delete">Excluir</a>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="<?php echo $ehAdmin ? '8' : '7'; ?>" class="table-empty">Nenhuma rota cadastrada no momento.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- MÓDULOS DE ACESSO RÁPIDO (APENAS PARA ADMINISTRADORES) -->
    <?php if ($ehAdmin): ?>
        <h2 class="section-title">Módulos de Gestão Administrativa</h2>

        <div class="grid-modules">
            <div class="card-module">
                <div>
                    <h3 class="module-title">🚂 Gestão de Trens</h3>
                    <p class="module-text">Cadastre locomotivas, controle velocidades máximas e status operacional.</p>
                </div>
                <a href="tala-lista-de-trens.php" class="btn-module btn-blue">Gerenciar Trens</a>
            </div>

            <div class="card-module">
                <div>
                    <h3 class="module-title">🗺️ Gerenciador de Rotas</h3>
                    <p class="module-text">Acesse a listagem completa de rotas e relatórios detalhados.</p>
                </div>
                <a href="tela-tela-lista-rotas.php" class="btn-module btn-green">Ver Todas as Rotas</a>
            </div>

            <div class="card-module">
                <div>
                    <h3 class="module-title">📡 Telemetria e Sensores</h3>
                    <p class="module-text">Acompanhe o monitoramento de sensores de presença e velocidade.</p>
                </div>
                <a href="tela-lista-sensores.php" class="btn-module btn-yellow">Monitorar Sensores</a>
            </div>

            <div class="card-module">
                <div>
                    <h3 class="module-title">👤 Gestão de Usuários</h3>
                    <p class="module-text">Controle de utilizadores e permissões de acesso ao sistema.</p>
                </div>
                <a href="tela-lista-usuarios.php" class="btn-module btn-purple">Gerenciar Usuários</a>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'rodape.php'; ?>