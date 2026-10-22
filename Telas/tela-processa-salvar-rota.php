<?php
require_once '../includes/auth.php';
exigirAutenticacao();
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_rota = $_POST['id_rota'] ?? null;
    $nome_rota = trim($_POST['nome_rota'] ?? '');
    $origem = trim($_POST['origem'] ?? '');
    $destino = trim($_POST['destino'] ?? '');
    $distancia_km = (float)($_POST['distancia_km'] ?? 0);
    $tempo_estimado_min = (int)($_POST['tempo_estimado_min'] ?? 0);
    $id_trem = (int)($_POST['id_trem'] ?? 0);

    if (empty($nome_rota) || empty($origem) || empty($destino) || $distancia_km <= 0 || $tempo_estimado_min <= 0 || $id_trem <= 0) {
        header('Location: tela-cadastro-rota.php?erro=campos_invalidos');
        exit();
    }

    if ($id_rota) {
        $sql = "UPDATE rotas SET nome_rota = ?, origem = ?, destino = ?, distancia_km = ?, tempo_estimado_min = ?, id_trem = ? WHERE id_rota = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("sssdiii", $nome_rota, $origem, $destino, $distancia_km, $tempo_estimado_min, $id_trem, $id_rota);
    } else {
        $sql = "INSERT INTO rotas (nome_rota, origem, destino, distancia_km, tempo_estimado_min, id_trem) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("sssdii", $nome_rota, $origem, $destino, $distancia_km, $tempo_estimado_min, $id_trem);
    }

    if ($stmt->execute()) {
        $stmt->close();
        header('Location: tela-lista-rotas.php?msg=salvo');
        exit();
    } else {
        $stmt->close();
        header('Location: tela-cadastro-rota.php?erro=erro_banco');
        exit();
    }
} else {
    header('Location: tela-lista-rotas.php');
    exit();
}
?>