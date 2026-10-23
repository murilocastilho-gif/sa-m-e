<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/conexao.php';

// Conexão de reserva
if (!isset($conexao) || !($conexao instanceof mysqli)) {
    if (isset($conn) && $conn instanceof mysqli) {
        $conexao = $conn;
    } elseif (isset($mysqli) && $mysqli instanceof mysqli) {
        $conexao = $mysqli;
    } else {
        $conexao = @new mysqli('localhost', 'root', '', 'ferrorama');
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    if (empty($email) || empty($senha)) {
        echo "<div style='font-family:sans-serif; padding:30px; text-align:center;'>
                <h3 style='color:red;'>Preencha o e-mail e a senha!</h3>
                <a href='tela-login.php'>Voltar ao Login</a>
              </div>";
        exit();
    }

    $stmt = $conexao->prepare("SELECT id_usuario, nome, email, senha, perfil FROM usuarios WHERE email = ? LIMIT 1");

    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado && $resultado->num_rows === 1) {
            $usuario = $resultado->fetch_assoc();
            $senhaBanco = (string)$usuario['senha'];

            $senhaValida = false;
            if (password_verify($senha, $senhaBanco) || $senha === $senhaBanco) {
                $senhaValida = true;
            }

            if ($senhaValida) {
                $_SESSION['id_usuario'] = $usuario['id_usuario'];
                $_SESSION['nome']       = $usuario['nome'];
                $_SESSION['perfil']     = $usuario['perfil'];

                session_write_close(); 

                echo "<!DOCTYPE html>
                <html lang='pt-BR'>
                <head>
                    <meta charset='UTF-8'>
                    <meta http-equiv='refresh' content='1;url=tela-home.php'>
                    <title>Autenticado com Sucesso</title>
                    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
                </head>
                <body class='bg-light d-flex align-items-center justify-content-center' style='height: 100vh;'>
                    <div class='card p-4 text-center shadow-sm' style='max-width: 400px;'>
                        <h4 class='text-success mb-3'>✓ Login efetuado!</h4>
                        <p class='text-muted'>A entrar no sistema Ferrorama...</p>
                        <a href='tela-home.php' class='btn btn-primary mt-2'>Aceder à Tela Home</a>
                    </div>
                </body>
                </html>";
                exit();
            } else {
                echo "<div style='font-family:sans-serif; padding:30px; text-align:center;'>
                        <h3 style='color:red;'>Senha incorreta!</h3>
                        <p>A senha digitada não confere com o registo na base de dados.</p>
                        <a href='tela-login.php'>Tentar novamente</a>
                      </div>";
                exit();
            }
        } else {
            echo "<div style='font-family:sans-serif; padding:30px; text-align:center;'>
                    <h3 style='color:red;'>E-mail não encontrado!</h3>
                    <p>Não existe nenhuma conta registada com este e-mail.</p>
                    <a href='tela-login.php'>Tentar novamente</a>
                  </div>";
            exit();
        }
    }
} else {
    header('Location: tela-login.php');
    exit();
}
?>