<?php
require_once '../includes/auth.php';
exigirAutenticacao();
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_trem = $_POST['id_trem'] ?? null;
    $nome_trem = trim($_POST['nome_trem'] ?? '');
    $modelo = trim($_POST['modelo'] ?? '');
    $velocidade_maxima = (int)($_POST['velocidade_maxima'] ?? 0);
    $status = $_POST['status'] ?? 'Operacional';
    $id_usuario_responsavel = !empty($_POST['id_usuario_responsavel']) ? (int)$_POST['id_usuario_responsavel'] : null;

    if (empty($nome_trem) || empty($modelo) || $velocidade_maxima <= 0) {
        header('Location: tela-cadastro-trem.php?erro=campos_invalidos');
        exit();
    }

    if ($id_trem) {
        $sql = "UPDATE trens SET nome_trem = ?, modelo = ?, velocidade_maxima = ?, status = ?, id_usuario_responsavel = ? WHERE id_trem = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ssisii", $nome_trem, $modelo, $velocidade_maxima, $status, $id_usuario_responsavel, $id_trem);
    } else {
        $sql = "INSERT INTO trens (nome_trem, modelo, velocidade_maxima, status, id_usuario_responsavel) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ssisi", $nome_trem, $modelo, $velocidade_maxima, $status, $id_usuario_responsavel);
    }

    if ($stmt->execute()) {
        $stmt->close();
        header('Location: tela-lista-trens.php?msg=salvo');
        exit();
    } else {
        $stmt->close();
        header('Location: tela-cadastro-trem.php?erro=erro_banco');
        exit();
    }
} else {
    header('Location: tela-lista-trens.php');
    exit();
}
?> 