<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


function exigirAutenticacao() {
    if (!isset($_SESSION['id_usuario'])) {
        header('Location: tela-login.php?erro=nao_autenticado');
        exit();
    }
}


function exigirAdmin() {
    exigirAutenticacao();
    if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] !== 'Administrador') {
        header('Location: Tela-trilho.php?erro=acesso_negado');
        exit();
    }
}
?>