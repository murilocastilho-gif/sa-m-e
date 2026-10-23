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

$id_trem = null;
$nome_trem = '';
$modelo = '';
$velocidade_maxima = 80;
$status = 'Em Operação';
$modoEdicao = false;
$erro = '';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_trem = (int)$_GET['id'];
    $stmt = $conexao->prepare("SELECT * FROM trens WHERE id_trem = ? LIMIT 1");
    if ($stmt) {
        $stmt->bind_param("i", $id_trem);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res && $res->num_rows === 1) {
            $dados = $res->fetch_assoc();
            $nome_trem = $dados['nome_trem'] ?? '';
            $modelo = $dados['modelo'] ?? '';
            $velocidade_maxima = $dados['velocidade_maxima'] ?? 80;
            $status = $dados['status'] ?? 'Em Operação';
            $modoEdicao = true;
        }
        $stmt->close();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_trem = !empty($_POST['id_trem']) ? (int)$_POST['id_trem'] : null;
    $nome_trem = trim($_POST['nome_trem'] ?? '');
    $modelo = trim($_POST['modelo'] ?? '');
    $velocidade_maxima = (int)($_POST['velocidade_maxima'] ?? 80);
    $status = trim($_POST['status'] ?? 'Em Operação');

    if ($id_trem) {
        $modoEdicao = true;
    }

    if (empty($nome_trem)) {
        $erro = "Preencha o nome da locomotiva.";
    } else {
        if ($id_trem) {
            $stmt = $conexao->prepare("UPDATE trens SET nome_trem = ?, modelo = ?, velocidade_maxima = ?, status = ? WHERE id_trem = ?");
            if ($stmt) {
                $stmt->bind_param("ssisi", $nome_trem, $modelo, $velocidade_maxima, $status, $id_trem);
                if ($stmt->execute()) {
                    header('Location: tela-lista-de-trens.php');
                    exit();
                } else {
                    $erro = "Erro ao atualizar locomotiva: " . $stmt->error;
                }
                $stmt->close();
            } else {
                $erro = "Erro na consulta de atualização: " . $conexao->error;
            }
        } else {
            $stmt = $conexao->prepare("INSERT INTO trens (nome_trem, modelo, velocidade_maxima, status) VALUES (?, ?, ?, ?)");
            if ($stmt) {
                $stmt->bind_param("ssis", $nome_trem, $modelo, $velocidade_maxima, $status);
                if ($stmt->execute()) {
                    header('Location: tela-lista-de-trens.php');
                    exit();
                } else {
                    $erro = "Erro ao cadastrar locomotiva: " . $stmt->error;
                }
                $stmt->close();
            } else {
                $erro = "Erro na consulta de inserção: " . $conexao->error;
            }
        }
    }
}

require_once __DIR__ . '/cabecalho.php';
?>

<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-primary text-white p-4 rounded-top-4">
                <h4 class="fw-bold mb-0">
                    <i class="fa-solid fa-train me-2"></i>
                    <?php echo $modoEdicao ? 'Editar Locomotiva' : 'Cadastrar Nova Locomotiva'; ?>
                </h4>
            </div>
            <div class="card-body p-4">
                <?php if (!empty($erro)): ?>
                    <div class="alert alert-danger py-2 mb-3"><?php echo htmlspecialchars($erro); ?></div>
                <?php endif; ?>

                <form action="tela-cadastro-trens.php" method="POST">
                    <?php if ($modoEdicao): ?>
                        <input type="hidden" name="id_trem" value="<?php echo $id_trem; ?>">
                    <?php endif; ?>

                    <div class="mb-3">
                        <label for="nome_trem" class="form-label fw-semibold">Nome / Identificação da Locomotiva</label>
                        <input type="text" id="nome_trem" name="nome_trem" class="form-control form-control-lg" required placeholder="Ex: Locomotiva T-100" value="<?php echo htmlspecialchars($nome_trem); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="modelo" class="form-label fw-semibold">Modelo</label>
                        <input type="text" id="modelo" name="modelo" class="form-control" placeholder="Ex: GE U20C / EMD SD70" value="<?php echo htmlspecialchars($modelo); ?>">
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="velocidade_maxima" class="form-label fw-semibold">Velocidade Máxima (km/h)</label>
                            <input type="number" id="velocidade_maxima" name="velocidade_maxima" class="form-control" min="10" max="300" value="<?php echo htmlspecialchars($velocidade_maxima); ?>">
                        </div>

                        <div class="col-md-6">
                            <label for="status" class="form-label fw-semibold">Status</label>
                            <select id="status" name="status" class="form-select">
                                <option value="Em Operação" <?php echo ($status === 'Em Operação' || $status === 'Operacional') ? 'selected' : ''; ?>>Operacional</option>
                                <option value="Em Manutenção" <?php echo ($status === 'Em Manutenção' || $status === 'Manutenção') ? 'selected' : ''; ?>>Manutenção</option>
                                <option value="Inativo" <?php echo ($status === 'Inativo') ? 'selected' : ''; ?>>Inativo</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <a href="tela-lista-de-trens.php" class="btn btn-outline-secondary px-4 fw-semibold">Cancelar</a>
                        <button type="submit" class="btn btn-primary px-4 fw-semibold">
                            <i class="fa-solid fa-floppy-disk me-1"></i>
                            <?php echo $modoEdicao ? 'Salvar Alterações' : 'Cadastrar Trem'; ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/rodape.php'; ?>