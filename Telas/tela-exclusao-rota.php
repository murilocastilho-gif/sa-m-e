<?php
require_once '../includes/auth.php';
exigirAdmin();
require_once 'conexao.php';

$id_rota = $_GET['id'] ?? null;

if ($id_rota) {
    $sql = "DELETE FROM rotas WHERE id_rota = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id_rota);
    $stmt->execute();
    $stmt->close();

    header('Location: tela-lista-rotas.php?msg=excluido');
    exit();
} else {
    header('Location: tela-lista-rotas.php');
    exit();
}
?>