<?php
require_once '../includes/auth.php';
exigirAutenticacao();
require_once 'conexao.php';
require_once 'cabecalho.php';

$id_trem = $_GET['id'] ?? null;
$trem = [
    'id_trem' => '',
    'nome_trem' => '',
    'modelo' => '',
    'velocidade_maxima' => '',
    'status' => 'Operacional',
    'id_usuario_responsavel' => ''
];

if ($id_trem) {
    $sql = "SELECT * FROM trens WHERE id_trem = ? LIMIT 1";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id_trem);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows === 1) {
        $trem = $res->fetch_assoc();
    }
    $stmt->close();
}

$sqlUsuarios = "SELECT id_usuario, nome FROM usuarios ORDER BY nome ASC";
$resUsuarios = $conexao->query($sqlUsuarios);
?>

<div style="max-width: 600px; margin: 30px auto; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); font-family: Arial, sans-serif;">
    <h2><?php echo $id_trem ? 'Editar Trem' : 'Cadastrar Novo Trem'; ?></h2>

    <form action="processa-salvar-trem.php" method="POST">
        <input type="hidden" name="id_trem" value="<?php echo htmlspecialchars($trem['id_trem']); ?>">

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: bold; margin-bottom: 5px;">Nome do Trem:</label>
            <input type="text" name="nome_trem" required value="<?php echo htmlspecialchars($trem['nome_trem']); ?>" style="width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: bold; margin-bottom: 5px;">Modelo:</label>
            <input type="text" name="modelo" required value="<?php echo htmlspecialchars($trem['modelo']); ?>" style="width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: bold; margin-bottom: 5px;">Velocidade Máxima (km/h):</label>
            <input type="number" name="velocidade_maxima" required value="<?php echo htmlspecialchars($trem['velocidade_maxima']); ?>" style="width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: bold; margin-bottom: 5px;">Status:</label>
            <select name="status" style="width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px;">
                <option value="Operacional" <?php echo ($trem['status'] == 'Operacional') ? 'selected' : ''; ?>>Operacional</option>
                <option value="Em Manutenção" <?php echo ($trem['status'] == 'Em Manutenção') ? 'selected' : ''; ?>>Em Manutenção</option>
                <option value="Inativo" <?php echo ($trem['status'] == 'Inativo') ? 'selected' : ''; ?>>Inativo</option>
            </select>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-weight: bold; margin-bottom: 5px;">Usuário Responsável:</label>
            <select name="id_usuario_responsavel" style="width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px;">
                <option value="">Nenhum</option>
                <?php if ($resUsuarios && $resUsuarios->num_rows > 0): ?>
                    <?php while ($u = $resUsuarios->fetch_assoc()): ?>
                        <option value="<?php echo $u['id_usuario']; ?>" <?php echo ($trem['id_usuario_responsavel'] == $u['id_usuario']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($u['nome']); ?>
                        </option>
                    <?php endwhile; ?>
                <?php endif; ?>
            </select>
        </div>

        <button type="submit" style="padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">Salvar</button>
        <a href="tela-lista-trens.php" style="margin-left: 10px; color: #6c757d; text-decoration: none;">Cancelar</a>
    </form>
</div>

<?php require_once 'rodape.php'; ?>