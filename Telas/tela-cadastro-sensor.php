<?php
require_once '../conexao.php';
require_once '../cabecalho.php';
$mensagem = '';
$tipoAlert = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome        = trim(filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS));
    $tipo        = trim(filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_SPECIAL_CHARS));
    $localizacao = trim(filter_input(INPUT_POST, 'localizacao', FILTER_SANITIZE_SPECIAL_CHARS));
    $status      = trim(filter_input(INPUT_POST, 'status', FILTER_SANITIZE_SPECIAL_CHARS));

    if (empty($nome) || empty($tipo) || empty($localizacao) || empty($status)) {
        $mensagem = "Preencha todos os campos obrigatórios.";
        $tipoAlert = "danger";
    } else {
        try {
            $sql = "INSERT INTO sensores (nome, tipo, localizacao, status) VALUES (:nome, :tipo, :localizacao, :status)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':nome'        => $nome,
                ':tipo'        => $tipo,
                ':localizacao' => $localizacao,
                ':status'      => $status
            ]);

            $mensagem = "Sensor cadastrado com sucesso!";
            $tipoAlert = "success";
        } catch (PDOException $e) {
            error_log($e->getMessage());
            $mensagem = "Erro ao cadastrar sensor no banco de dados.";
            $tipoAlert = "danger";
        }
    }
}

try {
    $stmt = $pdo->query("SELECT * FROM sensores ORDER BY id DESC");
    $sensores = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log($e->getMessage());
    $sensores = [];
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ferrorama - Cadastro de Sensores</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="tela-lista-usuarios.php">
                <i class="fa-solid fa-train text-warning me-2"></i>FERRORAMA
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="tela-lista-usuarios.php"><i class="fa-solid fa-users me-1"></i> Usuários</a>
                <a class="nav-link active" href="tela-cadastro-sensor.php"><i class="fa-solid fa-microchip me-1"></i> Sensores</a>
            </div>
        </div>
    </nav>

    <div class="container mb-5">
        
        <?php if (!empty($mensagem)): ?>
            <div class="alert alert-<?= $tipoAlert; ?> alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($mensagem); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="row g-4">
            
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-dark text-white fw-bold">
                        <i class="fa-solid fa-plus-circle text-warning me-2"></i>Novo Sensor
                    </div>
                    <div class="card-body">
                        <form action="tela-cadastro-sensor.php" method="POST">
                            <div class="mb-3">
                                <label for="nome-sensor" class="form-label fw-bold">Nome / Identificador</label>
                                <input type="text" id="nome-sensor" name="nome" class="form-control" placeholder="Ex: Sensor Curva A" required>
                            </div>

                            <div class="mb-3">
                                <label for="tipo-sensor" class="form-label fw-bold">Tipo de Sensor</label>
                                <select id="tipo-sensor" name="tipo" class="form-select" required>
                                    <option value="" selected disabled>Selecione...</option>
                                    <option value="Presença / RFID">Presença / RFID</option>
                                    <option value="Velocidade (Óptico)">Velocidade (Óptico)</option>
                                    <option value="Fim de Curso (Física)">Fim de Curso (Física)</option>
                                    <option value="Tensão / Corrente">Tensão / Corrente</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="localizacao-sensor" class="form-label fw-bold">Localização no Trilho</label>
                                <input type="text" id="localizacao-sensor" name="localizacao" class="form-control" placeholder="Ex: Trecho Norte - Bloco 2" required>
                            </div>

                            <div class="mb-3">
                                <label for="status-sensor" class="form-label fw-bold">Status Inicial</label>
                                <select id="status-sensor" name="status" class="form-select" required>
                                    <option value="Ativo" selected>Ativo</option>
                                    <option value="Inativo">Inativo</option>
                                    <option value="Manutenção">Manutenção</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-warning w-100 fw-bold mt-2">
                                <i class="fa-solid fa-floppy-disk me-1"></i> Cadastrar Sensor
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-dark text-white fw-bold d-flex justify-content-between align-items-center">
                        <span><i class="fa-solid fa-list me-2"></i>Sensores Monitorados</span>
                        <span id="total-sensores" class="badge bg-warning text-dark"><?= count($sensores); ?> Cadastrados</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Identificador</th>
                                        <th>Tipo</th>
                                        <th>Localização</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($sensores) > 0): ?>
                                        <?php foreach ($sensores as $sensor): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($sensor['id']); ?></td>
                                                <td class="fw-bold"><?= htmlspecialchars($sensor['nome']); ?></td>
                                                <td><?= htmlspecialchars($sensor['tipo']); ?></td>
                                                <td><?= htmlspecialchars($sensor['localizacao']); ?></td>
                                                <td>
                                                    <?php 
                                                        $badgeClass = 'secondary';
                                                        if ($sensor['status'] === 'Ativo') $badgeClass = 'success';
                                                        if ($sensor['status'] === 'Manutenção') $badgeClass = 'warning text-dark';
                                                    ?>
                                                    <span class="badge bg-<?= $badgeClass; ?>">
                                                        <?= htmlspecialchars($sensor['status']); ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center text-muted p-4">Nenhum sensor cadastrado até o momento.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>