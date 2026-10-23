<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$nomeUsuario   = $_SESSION['nome'] ?? 'Operador';
$perfilUsuario = $_SESSION['perfil'] ?? 'Usuario';
$ehAdmin       = (strcasecmp($perfilUsuario, 'Administrador') === 0);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ferrorama - Painel de Controle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --nav-bg: #0f172a;
            --nav-hover: #1e293b;
            --accent-blue: #38bdf8;
            --body-bg: #f1f5f9;
        }

        body {
            background-color: var(--body-bg);
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar-ferrorama {
            background-color: var(--nav-bg) !important;
            border-bottom: 2px solid #1e293b;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.4rem;
            color: var(--accent-blue) !important;
            letter-spacing: -0.5px;
        }

        .nav-link {
            color: #94a3b8 !important;
            font-weight: 600;
            font-size: 0.92rem;
            padding: 8px 16px !important;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .nav-link:hover, .nav-link.active {
            color: #ffffff !important;
            background-color: var(--nav-hover);
        }

        .user-badge {
            background: #1e293b;
            border: 1px solid #334155;
            color: #f8fafc;
            font-size: 0.85rem;
            font-weight: 500;
            padding: 6px 14px;
            border-radius: 30px;
        }

        .content-container {
            flex: 1;
            padding: 32px 0;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-ferrorama sticky-top py-2">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="tela-home.php">
            <i class="fa-solid fa-train-subway"></i> Ferrorama
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-3">
                <li class="nav-item">
                    <a class="nav-link" href="tela-home.php"><i class="fa-solid fa-house me-1"></i> Início</a>
                </li>

                <?php if ($ehAdmin): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="tala-lista-de-trens.php"><i class="fa-solid fa-train me-1"></i> Trens</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="tela-tela-lista-rotas.php"><i class="fa-solid fa-route me-1"></i> Rotas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="tela-lista-sensores.php"><i class="fa-solid fa-tower-observation me-1"></i> Sensores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="tela-lista-usuarios.php"><i class="fa-solid fa-users me-1"></i> Usuários</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="tela-tela-lista-rotas.php"><i class="fa-solid fa-route me-1"></i> Consultar Rotas</a>
                    </li>
                <?php endif; ?>
            </ul>

            <div class="d-flex align-items-center gap-3">
                <div class="user-badge">
                    <i class="fa-solid fa-circle-user text-info me-1"></i> 
                    <?php echo htmlspecialchars($nomeUsuario); ?> 
                    <span class="badge <?php echo $ehAdmin ? 'bg-danger' : 'bg-primary'; ?> ms-1">
                        <?php echo htmlspecialchars($perfilUsuario); ?>
                    </span>
                </div>
                <a href="logout.php" class="btn btn-outline-danger btn-sm px-3 fw-semibold"><i class="fa-solid fa-right-from-bracket me-1"></i> Sair</a>
            </div>
        </div>
    </div>
</nav>

<div class="content-container">
    <div class="container">