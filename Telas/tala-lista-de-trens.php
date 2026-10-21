<?php
require_once '../includes/auth.php';
exigirAutenticacao();
require_once 'conexao.php';
require_once 'cabecalho.php';

$sql = "SELECT t.*, u.nome AS nome_responsavel 
        FROM trens t 
        LEFT JOIN usuarios u ON t.id_usuario_responsavel = u.id_usuario 
        ORDER BY t.id_trem DESC";
$resultado = $conexao->query($sql);
?>

<div style="max-width: 1000px; margin: 30px auto; padding: 20px; font-family: Arial, sans-serif;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Gestão de Trens</h2>
        <a href="tela-cadastro-trem.php" style="padding: 10px 15px; background: #28a745; color: white; text-decoration: none; border-radius: 4px; font-weight: bold;">+ Novo Trem</a>
    </div>

    <?php if (isset($_GET['msg'])): ?>
        <div style="padding: 10px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 4px; margin-bottom: 15px;">
            <?php
                if ($_GET['msg'] == 'salvo') echo "Trem salvo com sucesso!";
                elseif ($_GET['msg'] == 'excluido') echo "Trem excluído com sucesso!";
            ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['erro'])): ?>
        <div style="padding: 10px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 4px; margin-bottom: 15px;">
            <?php
                if ($_GET['erro'] == 'sem_permissao') echo "Apenas administradores podem excluir trens.";
                elseif ($_GET['erro'] == 'com_rotas') echo "Não é possível excluir este trem pois ele possui rotas vinculadas.";
            ?>
        </div>
    <?php endif; ?>

    <table style="width: 100%; border-collapse: collapse; background: white; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <thead>
            <tr style="background: #2c3e50; color: white; text-align: left;">
                <th style="padding: 12px; border: 1px solid #ddd;">ID</th>
                <th style="padding: 12px; border: 1px solid #ddd;">Nome</th>
                <th style="padding: 12px; border: 1px solid #ddd;">Modelo</th>
                <th style="padding: 12px; border: 1px solid #ddd;">Velocidade Máx.</th>
                <th style="padding: 12px; border: 1px solid #ddd;">Status</th>
                <th style="padding: 12px; border: 1px solid #ddd;">Responsável</th>
                <th style="padding: 12px; border: 1px solid #ddd;">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($resultado && $resultado->num_rows > 0): ?>
                <?php while ($trem = $resultado->fetch_assoc()): ?>
                    <tr>
                        <td style="padding: 10px; border: 1px solid #ddd;"><?php echo $trem['id_trem']; ?></td>
                        <td style="padding: 10px; border: 1px solid #ddd;"><?php echo htmlspecialchars($trem['nome_trem']); ?></td>
                        <td style="padding: 10px; border: 1px solid #ddd;"><?php echo htmlspecialchars($trem['modelo']); ?></td>
                        <td style="padding: 10px; border: 1px solid #ddd;"><?php echo $trem['velocidade_maxima']; ?> km/h</td>
                        <td style="padding: 10px; border: 1px solid #ddd;"><?php echo htmlspecialchars($trem['status']); ?></td>
                        <td style="padding: 10px; border: 1px solid #ddd;"><?php echo htmlspecialchars($trem['nome_responsavel'] ?? 'Nenhum'); ?></td>
                        <td style="padding: 10px; border: 1px solid #ddd;">
                            <a href="tela-cadastro-trem.php?id=<?php echo $trem['id_trem']; ?>" style="color: #007bff; text-decoration: none; margin-right: 10px;">Editar</a>
                            <?php if (isset($_SESSION['perfil']) && $_SESSION['perfil'] === 'Administrador'): ?>
                                <a href="processa-exclusao-trem.php?id=<?php echo $trem['id_trem']; ?>" onclick="return confirm('Deseja realmente excluir este trem?');" style="color: #dc3545; text-decoration: none;">Excluir</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="padding: 15px; text-align: center; border: 1px solid #ddd;">Nenhum trem cadastrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once 'rodape.php'; ?>