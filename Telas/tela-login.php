<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Ferrorama</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body.page-login {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }

        .login-container {
            background: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            width: 100%;
            max-width: 420px;
        }

        .login-title {
            color: #0d6efd;
            font-size: 2rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 25px;
        }

        .form-label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 6px;
        }

        .form-control {
            padding: 10px 14px;
            border-radius: 6px;
            border: 1px solid #ced4da;
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background-color: #0d6efd;
            border: none;
            border-radius: 6px;
            color: #ffffff;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease;
            margin-top: 10px;
        }

        .btn-login:hover {
            background-color: #0b5ed7;
        }

        .login-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9rem;
            color: #6c757d;
        }

        .login-footer a {
            color: #0d6efd;
            text-decoration: none;
            font-weight: 600;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body class="page-login">

<div class="login-container">
    <h2 class="login-title">Ferrorama</h2>

    <?php if (isset($_GET['msg']) && $_GET['msg'] === 'cadastro_sucesso'): ?>
        <div class="alert alert-success py-2 text-center" role="alert">
            Registo realizado com sucesso! Faça login para aceder.
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['erro'])): ?>
        <div class="alert alert-danger py-2 text-center" role="alert">
            <?php 
                if ($_GET['erro'] === 'credenciais_invalidas') echo "E-mail ou palavra-passe incorretos!";
                elseif ($_GET['erro'] === 'campos_vazios') echo "Preencha todos os campos.";
            ?>
        </div>
    <?php endif; ?>

    <form action="verifica-login.php" method="POST">
        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" id="email" name="email" class="form-control" required placeholder="Digite o seu e-mail">
        </div>

        <div class="mb-3">
            <label for="senha" class="form-label">Palavra-passe</label>
            <input type="password" id="senha" name="senha" class="form-control" required placeholder="Digite a sua palavra-passe">
        </div>

        <button type="submit" class="btn-login">Entrar</button>
    </form>

    <div class="text-center mt-3">
    <div class="small mb-1">
        Ainda não tem uma conta? <a href="tela-cadastro-usuario.php" class="text-decoration-none fw-semibold">Registar-se</a>
    </div>
    <div class="small">
        <a href="tela-recuperar-senha.php" class="text-decoration-none">Esqueceu-se da palavra-passe?</a>
    </div>
</div>
    
</div>

</body>
</html>