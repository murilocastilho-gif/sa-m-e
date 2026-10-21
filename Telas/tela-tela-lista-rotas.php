<?php
require_once '../includes/auth.php';
exigirAutenticacao();
require_once 'conexao.php';
require_once 'cabecalho.php';

$sql = "SELECT r.*, t.nome_trem 
        FROM rotas r 
        INNER JOIN trens t ON r.id_trem = t.id_trem 
        ORDER BY r.id_rota DESC";
$resultado = $conexao->query($sql);
?>

<div style="max-width: 1000px; margin: 30px auto; padding: 20px; font-family: Arial, sans-serif;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Gestão de Rotas</h2>
        <a href="tela-cadastro-rota.php" style="padding: 10px 15px; background: #28a745; color: white; text-decoration: none; border-radius: 4px; font-weight: bold;">+ Nova Rota</a>
    </div>

    <?php if (isset($_GET['msg'])): ?>
        <div style="padding: 10px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 4px; margin-bottom: 15px;">
            <?php
                if ($_GET['msg'] == 'salvo') echo "Rota salva com sucesso!";
                elseif ($_GET['msg'] == 'excluido') echo "Rota excluída com sucesso!";
            ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['erro'])): ?>
        <div style="padding: 10px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 4px; margin-bottom: 15px;">
            <?php
                if ($_GET['erro'] == 'sem_permissao') echo "Apenas administradores podem excluir rotas.";
                elseif ($_GET['erro'] == 'sem_trem') echo "É necessário ter pelo menos um trem cadastrado para criar uma rota.";
            ?>
        </div>
    <?php endif; ?>

    <table style="width: 100%; border-collapse: collapse; background: white; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <thead>
            <tr style="background: #2c3e50; color: white; text-align: left;">
                <th style="padding: 12px; border: 1px solid #ddd;">ID</th>
                <th style="padding: 12px; border: 1px solid #ddd;">Nome da Rota</th>
                <th style="padding: 12px; border: 1px solid #ddd;">Origem</th>
                <th style="padding: 12px; border: 1px solid #ddd;">Destino</th>
                <th style="padding: 12px; border: 1px solid #ddd;">Distância (km)</th>
                <th style="padding: 12px; border: 1px solid #ddd;">Tempo (min)</th>
                <th style="padding: 12px; border: 1px solid #ddd;">Trem Vinculado</th>
                <th style="padding: 12px; border: 1px solid #ddd;">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($resultado && $resultado->num_rows > 0): ?>
                <?php while ($rota = $resultado->fetch_assoc()): ?>
                    <tr>
                        <td style="padding: 10px; border: 1px solid #ddd;"><?php echo $rota['id_rota']; ?></td>
                        <td style="padding: 10px; border: 1px solid #ddd;"><?php echo htmlspecialchars($rota['nome_rota']); ?></td>
                        <td style="padding: 10px; border: 1px solid #ddd;"><?php echo htmlspecialchars($rota['origem']); ?></td>
                        <td style="padding: 10px; border: 1px solid #ddd;"><?php echo htmlspecialchars($rota['destino']); ?></td>
                        <td style="padding: 10px; border: 1px solid #ddd;"><?php echo number_format($rota['distancia_km'], 2, ',', '.'); ?> km</td>
                        <td style="padding: 10px; border: 1px solid #ddd;"><?php echo $rota['tempo_estimado_min']; ?> min</td>
                        <td style="padding: 10px; border: 1px solid #ddd;"><?php echo htmlspecialchars($rota['nome_trem']); ?></td>
                        <td style="padding: 10px; border: 1px solid #ddd;">
                            <a href="tela-cadastro-rota.php?id=<?php echo $rota['id_rota']; ?>" style="color: #007bff; text-decoration: none; margin-right: 10px;">Editar</a>
                            <?php if (isset($_SESSION['perfil']) && $_SESSION['perfil'] === 'Administrador'): ?>
                                <a href="processa-exclusao-rota.php?id=<?php echo $rota['id_rota']; ?>" onclick="return confirm('Deseja realmente excluir esta rota?');" style="color: #dc3545; text-decoration: none;">Excluir</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" style="padding: 15px; text-align: center; border: 1px solid #ddd;">Nenhuma rota cadastrada.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once 'rodape.php'; ?>