<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['id_usuario']) || empty($_SESSION['id_usuario'])) {
    header('Location: tela-login.php');
    exit();
}

if (!isset($_SESSION['perfil']) || strcasecmp($_SESSION['perfil'], 'Administrador') !== 0) {
    header('Location: tela-home.php');
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

$id_rota            = null;
$nome_rota          = '';
$origem             = '';
$destino            = '';
$distancia_km       = '';
$tempo_estimado_min = '';
$id_trem            = null;
$modoEdicao         = false;
$erro               = '';

$listaTrens = [];
if ($conexao && !$conexao->connect_error) {
    $resTrens = $conexao->query("SELECT id_trem, nome_trem FROM trens ORDER BY nome_trem ASC");
    if ($resTrens) {
        while ($t = $resTrens->fetch_assoc()) {
            $listaTrens[] = $t;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_rota            = !empty($_POST['id_rota']) ? (int)$_POST['id_rota'] : null;
    $nome_rota          = trim($_POST['nome_rota'] ?? '');
    $origem             = trim($_POST['origem'] ?? '');
    $destino            = trim($_POST['destino'] ?? '');
    $distancia_km       = (float)($_POST['distancia_km'] ?? 0);
    $tempo_estimado_min = (int)($_POST['tempo_estimado_min'] ?? 0);
    $id_trem            = !empty($_POST['id_trem']) ? (int)$_POST['id_trem'] : null;

    if (empty($nome_rota) || empty($origem) || empty($destino)) {
        $erro = "Por favor, preencha o nome da rota, a origem e o destino.";
    } elseif (empty($id_trem)) {
        $erro = "ERRO: É obrigatório selecionar um trem para cadastrar a rota!";
    } else {
        if ($id_rota) {
            $stmt = $conexao->prepare("UPDATE rotas SET nome_rota = ?, origem = ?, destino = ?, distancia_km = ?, tempo_estimado_min = ?, id_trem = ? WHERE id_rota = ?");
            if ($stmt) {
                $stmt->bind_param("sssdiii", $nome_rota, $origem, $destino, $distancia_km, $tempo_estimado_min, $id_trem, $id_rota);
                $stmt->execute();
            }
        } else {
            $stmt = $conexao->prepare("INSERT INTO rotas (nome_rota, origem, destino, distancia_km, tempo_estimado_min, id_trem) VALUES (?, ?, ?, ?, ?, ?)");
            if ($stmt) {
                $stmt->bind_param("sssdii", $nome_rota, $origem, $destino, $distancia_km, $tempo_estimado_min, $id_trem);
                $stmt->execute();
            }
        }

        header('Location: tela-tela-lista-rotas.php');
        exit();
    }
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_rota = (int)$_GET['id'];
    $stmt = $conexao->prepare("SELECT * FROM rotas WHERE id_rota = ? LIMIT 1");
    if ($stmt) {
        $stmt->bind_param("i", $id_rota);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res && $res->num_rows === 1) {
            $dados = $res->fetch_assoc();
            $nome_rota          = $dados['nome_rota'];
            $origem             = $dados['origem'];
            $destino            = $dados['destino'];
            $distancia_km       = $dados['distancia_km'];
            $tempo_estimado_min = $dados['tempo_estimado_min'];
            $id_trem            = $dados['id_trem'];
            $modoEdicao         = true;
        }
    }
}

require_once __DIR__ . '/cabecalho.php';
?>

<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-7">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-success text-white p-4 rounded-top-4">
                <h4 class="fw-bold mb-0">
                    <i class="fa-solid fa-map-location-dot me-2"></i>
                    <?php echo $modoEdicao ? 'Editar Rota' : 'Cadastrar Nova Rota'; ?>
                </h4>
            </div>

            <div class="card-body p-4">
                <?php if (!empty($erro)): ?>
                    <div class="alert alert-danger d-flex align-items-center py-3 mb-3 rounded-3" role="alert">
                        <i class="fa-solid fa-circle-exclamation fs-4 me-2"></i>
                        <div><strong><?php echo htmlspecialchars($erro); ?></strong></div>
                    </div>
                <?php endif; ?>

                <form action="tela-cadastro-rota.php" method="POST">
                    <?php if ($modoEdicao): ?>
                        <input type="hidden" name="id_rota" value="<?php echo $id_rota; ?>">
                    <?php endif; ?>

                    <div class="mb-3">
                        <label for="nome_rota" class="form-label fw-semibold">Nome da Rota</label>
                        <input type="text" id="nome_rota" name="nome_rota" class="form-control form-control-lg" required placeholder="Ex: Rota Expressa Sul" value="<?php echo htmlspecialchars($nome_rota); ?>">
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="origem" class="form-label fw-semibold">Estação de Origem</label>
                            <input type="text" id="origem" name="origem" class="form-control" required placeholder="Ex: Estação Central" value="<?php echo htmlspecialchars($origem); ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="destino" class="form-label fw-semibold">Estação de Destino</label>
                            <input type="text" id="destino" name="destino" class="form-control" required placeholder="Ex: Terminal Norte" value="<?php echo htmlspecialchars($destino); ?>">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="distancia_km" class="form-label fw-semibold">Distância (km)</label>
                            <input type="number" step="0.1" id="distancia_km" name="distancia_km" class="form-control" placeholder="Ex: 45.5" value="<?php echo htmlspecialchars($distancia_km); ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="tempo_estimado_min" class="form-label fw-semibold">Tempo Estimado (minutos)</label>
                            <input type="number" id="tempo_estimado_min" name="tempo_estimado_min" class="form-control" placeholder="Ex: 60" value="<?php echo htmlspecialchars($tempo_estimado_min); ?>">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="id_trem" class="form-label fw-semibold">Atribuir Locomotiva / Trem <span class="text-danger">*</span></label>
                        <select id="id_trem" name="id_trem" class="form-select" required>
                            <option value="">-- Selecione uma locomotiva (Obrigatório) --</option>
                            <?php foreach ($listaTrens as $trem): ?>
                                <option value="<?php echo $trem['id_trem']; ?>" <?php echo ($id_trem == $trem['id_trem']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($trem['nome_trem']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <a href="tela-tela-lista-rotas.php" class="btn btn-outline-secondary px-4 fw-semibold">Cancelar</a>
                        <button type="submit" class="btn btn-success px-4 fw-semibold">
                            <i class="fa-solid fa-floppy-disk me-1"></i>
                            <?php echo $modoEdicao ? 'Salvar Alterações' : 'Cadastrar Rota'; ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/rodape.php'; ?>