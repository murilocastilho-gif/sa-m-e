<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ferrorama - Cadastro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style/style.css">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">

    <div class="card shadow p-4" style="width: 100%; max-width: 500px;">
        <h2 class="text-center mb-4 text-primary">Criar Conta</h2>
        <form>
            <div class="mb-3">
                <label for="nome" class="form-label">Nome Completo</label>
                <input type="text" class="form-control" id="nome" placeholder="Digite seu nome" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control" id="email" placeholder="Digite seu e-mail" required>
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <input type="password" class="form-control" id="senha" placeholder="Crie uma senha" required>
            </div>
            <div class="mb-3">
                <label for="confirmar-senha" class="form-label">Confirmar Senha</label>
                <input type="password" class="form-control" id="confirmar-senha" placeholder="Confirme sua senha" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Cadastrar</button>
            <div class="text-center mt-3">
                <a href="tela-login.html" class="text-decoration-none">Já possui uma conta? Faça login</a>
            </div>
        </form>
    </div>

    <script src="../script/validacao.js"></script>
    <script src="../script/botoes.js"></script>
</body>
</html>