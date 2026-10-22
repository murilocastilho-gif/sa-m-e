<?php
require_once '../includes/auth.php';
exigirAutenticacao();
require_once 'conexao.php';
require_once 'cabecalho.php';

$sqlTrens = "SELECT id_trem, nome_trem FROM trens ORDER BY nome_trem ASC";
$resTrens = $conexao->query($sqlTrens);

if (!$resTrens || $resTrens->num_rows === 0) {
    header('Location: tela-lista-rotas.php?erro=sem_trem');
    exit();
}

$id_rota = $_GET['id'] ?? null;
$rota = [
    'id_rota' => '',
    'nome_rota' => '',
    'origem' => '',
    'destino' => '',
    'distancia_km' => '',
    'tempo_estimado_min' => '',
    'id_trem' => ''
];

if ($id_rota) {
    $sql = "SELECT * FROM rotas WHERE id_rota = ? LIMIT 1";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id_rota);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows === 1) {
        $rota = $res->fetch_assoc();
    }
    $stmt->close();
}
?>

<div style="max-width: 600px; margin: 30px auto; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); font-family: Arial, sans-serif;">
    <h2><?php echo $id_rota ? 'Editar Rota' : 'Cadastrar Nova Rota'; ?></h2>

    <form action="processa-salvar-rota.php" method="POST">
        <input type="hidden" name="id_rota" value="<?php echo htmlspecialchars($rota['id_rota']); ?>">

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: bold; margin-bottom: 5px;">Nome da Rota:</label>
            <input type="text" name="nome_rota" required value="<?php echo htmlspecialchars($rota['nome_rota']); ?>" placeholder="Ex: Linha Norte Express" style="width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: bold; margin-bottom: 5px;">Estação de Origem:</label>
            <input type="text" name="origem" required value="<?php echo htmlspecialchars($rota['origem']); ?>" placeholder="Ex: Estação Central" style="width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: bold; margin-bottom: 5px;">Estação de Destino:</label>
            <input type="text" name="destino" required value="<?php echo htmlspecialchars($rota['destino']); ?>" placeholder="Ex: Terminal Carga Sul" style="width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: bold; margin-bottom: 5px;">Distância (km):</label>
            <input type="number" step="0.01" name="distancia_km" required value="<?php echo htmlspecialchars($rota['distancia_km']); ?>" placeholder="Ex: 45.5" style="width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: bold; margin-bottom: 5px;">Tempo Estimado (minutos):</label>
            <input type="number" name="tempo_estimado_min" required value="<?php echo htmlspecialchars($rota['tempo_estimado_min']); ?>" placeholder="Ex: 60" style="width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-weight: bold; margin-bottom: 5px;">Trem Vinculado:</label>
            <select name="id_trem" required style="width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px;">
                <option value="">Selecione um trem...</option>
                <?php while ($t = $resTrens->fetch_assoc()): ?>
                    <option value="<?php echo $t['id_trem']; ?>" <?php echo ($rota['id_trem'] == $t['id_trem']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($t['nome_trem']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <button type="submit" style="padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">Salvar Rota</button>
        <a href="tela-lista-rotas.php" style="margin-left: 10px; color: #6c757d; text-decoration: none;">Cancelar</a>
    </form>
</div>

<?php require_once 'rodape.php'; ?>