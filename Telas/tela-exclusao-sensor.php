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

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_sensor = (int)$_GET['id'];

    $stmt = $conexao->prepare("DELETE FROM sensores WHERE id_sensor = ?");
    if ($stmt) {
        $stmt->bind_param("i", $id_sensor);
        $stmt->execute();
        $stmt->close();
    }
}

header('Location: tela-lista-sensores.php?sucesso=excluido');
exit();
?>