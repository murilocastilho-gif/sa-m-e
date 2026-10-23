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

$id_sensor     = null;
$nome_sensor   = '';
$identificacao = '';
$tipo_sensor   = 'Presença';
$localizacao   = '';
$status        = 'Ativo';
$modoEdicao    = false;
$erro          = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_sensor     = !empty($_POST['id_sensor']) ? (int)$_POST['id_sensor'] : null;
    $nome_sensor   = trim($_POST['nome_sensor'] ?? '');
    $identificacao = trim($_POST['identificacao'] ?? '');
    $tipo_sensor   = trim($_POST['tipo_sensor'] ?? 'Presença');
    $localizacao   = trim($_POST['localizacao'] ?? '');
    $status        = trim($_POST['status'] ?? 'Ativo');

    if (empty($nome_sensor) || empty($identificacao) || empty($localizacao)) {
        $erro = "Por favor, preencha todos os campos obrigatórios (Nome, Identificação e Localização).";
    } else {
        if ($id_sensor) {
            $stmt = $conexao->prepare("UPDATE sensores SET nome_sensor = ?, identificacao = ?, tipo_sensor = ?, localizacao = ?, status = ? WHERE id_sensor = ?");
            if ($stmt) {
                $stmt->bind_param("sssssi", $nome_sensor, $identificacao, $tipo_sensor, $localizacao, $status, $id_sensor);
                $stmt->execute();
            }
        } else {
            $stmt = $conexao->prepare("INSERT INTO sensores (nome_sensor, identificacao, tipo_sensor, localizacao, status) VALUES (?, ?, ?, ?, ?)");
            if ($stmt) {
                $stmt->bind_param("sssss", $nome_sensor, $identificacao, $tipo_sensor, $localizacao, $status);
                $stmt->execute();
            }
        }

        header('Location: tela-lista-sensores.php?sucesso=salvo');
        exit();
    }
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_sensor = (int)$_GET['id'];
    $stmt = $conexao->prepare("SELECT * FROM sensores WHERE id_sensor = ? LIMIT 1");
    if ($stmt) {
        $stmt->bind_param("i", $id_sensor);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res && $res->num_rows === 1) {
            $dados = $res->fetch_assoc();
            $nome_sensor   = $dados['nome_sensor'] ?? $dados['nome'] ?? '';
            $identificacao = $dados['identificacao'] ?? '';
            $tipo_sensor   = $dados['tipo_sensor'] ?? $dados['tipo'] ?? 'Presença';
            $localizacao   = $dados['localizacao'] ?? '';
            $status        = $dados['status'] ?? 'Ativo';
            $modoEdicao    = true;
        }
    }
}

require_once __DIR__ . '/cabecalho.php';
?>

<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-7">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-warning text-dark p-4 rounded-top-4">
                <h4 class="fw-bold mb-0">
                    <i class="fa-solid fa-tower-observation me-2"></i>
                    <?php echo $modoEdicao ? 'Editar Sensor' : 'Cadastrar Novo Sensor'; ?>
                </h4>
            </div>

            <div class="card-body p-4">
                <?php if (!empty($erro)): ?>
                    <div class="alert alert-danger d-flex align-items-center py-3 mb-3 rounded-3" role="alert">
                        <i class="fa-solid fa-circle-exclamation fs-4 me-2"></i>
                        <div><strong><?php echo htmlspecialchars($erro); ?></strong></div>
                    </div>
                <?php endif; ?>

                <form action="tela-cadastro-sensor.php" method="POST">
                    <?php if ($modoEdicao): ?>
                        <input type="hidden" name="id_sensor" value="<?php echo $id_sensor; ?>">
                    <?php endif; ?>

                    <div class="mb-3">
                        <label for="nome_sensor" class="form-label fw-semibold">Nome do Sensor <span class="text-danger">*</span></label>
                        <input type="text" id="nome_sensor" name="nome_sensor" class="form-control form-control-lg" required placeholder="Ex: Sensor de Presença Trecho A" value="<?php echo htmlspecialchars($nome_sensor); ?>">
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="identificacao" class="form-label fw-semibold">Identificação / Código <span class="text-danger">*</span></label>
                            <input type="text" id="identificacao" name="identificacao" class="form-control" required placeholder="Ex: SNS-001-A" value="<?php echo htmlspecialchars($identificacao); ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="tipo_sensor" class="form-label fw-semibold">Tipo de Sensor <span class="text-danger">*</span></label>
                            <select id="tipo_sensor" name="tipo_sensor" class="form-select" required>
                                <option value="Presença" <?php echo ($tipo_sensor === 'Presença') ? 'selected' : ''; ?>>Presença / Passagem</option>
                                <option value="Temperatura" <?php echo ($tipo_sensor === 'Temperatura') ? 'selected' : ''; ?>>Temperatura</option>
                                <option value="Velocidade" <?php echo ($tipo_sensor === 'Velocidade') ? 'selected' : ''; ?>>Velocidade</option>
                                <option value="Cruzamento" <?php echo ($tipo_sensor === 'Cruzamento') ? 'selected' : ''; ?>>Cruzamento de Via</option>
                                <option value="Desvio" <?php echo ($tipo_sensor === 'Desvio') ? 'selected' : ''; ?>>Posicionamento de Desvio</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-8">
                            <label for="localizacao" class="form-label fw-semibold">Localização / Trecho <span class="text-danger">*</span></label>
                            <input type="text" id="localizacao" name="localizacao" class="form-control" required placeholder="Ex: Km 12 - Cruzamento Sul" value="<?php echo htmlspecialchars($localizacao); ?>">
                        </div>
                        <div class="col-md-4">
                            <label for="status" class="form-label fw-semibold">Status Operacional</label>
                            <select id="status" name="status" class="form-select">
                                <option value="Ativo" <?php echo ($status === 'Ativo') ? 'selected' : ''; ?>>Ativo</option>
                                <option value="Inativo" <?php echo ($status === 'Inativo') ? 'selected' : ''; ?>>Inativo</option>
                                <option value="Manutenção" <?php echo ($status === 'Manutenção') ? 'selected' : ''; ?>>Manutenção</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <a href="tela-lista-sensores.php" class="btn btn-outline-secondary px-4 fw-semibold">Cancelar</a>
                        <button type="submit" class="btn btn-warning px-4 fw-semibold text-dark">
                            <i class="fa-solid fa-floppy-disk me-1"></i>
                            <?php echo $modoEdicao ? 'Salvar Alterações' : 'Cadastrar Sensor'; ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/rodape.php'; ?>