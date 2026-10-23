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
    $id_trem = (int)$_GET['id'];

    $qtdRotas = 0;
    $res = $conexao->query("SELECT COUNT(*) AS total FROM rotas WHERE id_trem = " . $id_trem);
    if ($res && $row = $res->fetch_assoc()) {
        $qtdRotas = (int)$row['total'];
    }

    if ($qtdRotas > 0) {
        header('Location: tala-lista-de-trens.php?erro=vinculado');
        exit();
    }

    try {
        $stmtDelete = $conexao->prepare("DELETE FROM trens WHERE id_trem = ?");
        if ($stmtDelete) {
            $stmtDelete->bind_param("i", $id_trem);
            if (!$stmtDelete->execute()) {
                header('Location: tala-lista-de-trens.php?erro=vinculado');
                exit();
            }
            $stmtDelete->close();
        }
    } catch (Exception $e) {
        header('Location: tala-lista-de-trens.php?erro=vinculado');
        exit();
    } catch (Throwable $t) {
        header('Location: tala-lista-de-trens.php?erro=vinculado');
        exit();
    }
}

header('Location: tala-lista-de-trens.php?sucesso=excluido');
exit();
?>