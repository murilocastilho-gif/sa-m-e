<?php
require_once '../includes/auth.php';
exigirAdmin();
require_once 'conexao.php';

$id_trem = $_GET['id'] ?? null;

if ($id_trem) {
    $sqlCheck = "SELECT COUNT(*) as total FROM rotas WHERE id_trem = ?";
    $stmtCheck = $conexao->prepare($sqlCheck);
    if ($stmtCheck) {
        $stmtCheck->bind_param("i", $id_trem);
        $stmtCheck->execute();
        $resCheck = $stmtCheck->get_result()->fetch_assoc();
        $stmtCheck->close();

        if ($resCheck['total'] > 0) {
            header('Location: tela-lista-trens.php?erro=com_rotas');
            exit();
        }
    }

    $sql = "DELETE FROM trens WHERE id_trem = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id_trem);
    $stmt->execute();
    $stmt->close();

    header('Location: tela-lista-trens.php?msg=excluido');
    exit();
} else {
    header('Location: tela-lista-trens.php');
    exit();
}
?>