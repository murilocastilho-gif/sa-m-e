<?php
require_once 'conexao.php';

$id = $_GET['id'] ?? null;

if ($id) {
    try {
        $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id_usuario = :id");
        $stmt->execute([':id' => $id]);
    } catch (PDOException $e) {
        die("Erro ao excluir utilizador: " . $e->getMessage());
    }
}

header("Location: tela-lista-usuarios.php?sucesso=1");
exit;