<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M-E Ferrovias — Sistema Inteligente de Gestão Ferroviária</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-navy: #0F2C59;
            --accent-green: #198754;
            --bg-light: #F8F9FA;
        }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #333; }
        .hero-section { background: linear-gradient(135deg, #0F2C59 0%, #1E40AF 100%); color: white; padding: 90px 0; }
        .feature-icon { width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3 sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4" href="#"><i class="fa-solid fa-train text-primary me-2"></i>M-E Ferrovias </a>
            <a href="tela-login.php" class="btn btn-outline-light rounded-pill px-4">Acessar Sistema</a>
        </div>
    </nav>

    <header class="hero-section text-center text-lg-start">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <span class="badge bg-warning text-dark mb-3 px-3 py-2 fw-semibold">Tecnologia IoT & Telemetria</span>
                    <h1 class="display-4 fw-bold mb-3">Monitoramento e Gestão Ferroviária em Tempo Real</h1>
                    <p class="lead mb-4 opacity-75">O M-E Ferrovias integra controle de frota, rastreamento de rotas e sensores de velocidade e presença para elevar a eficiência e segurança operacional.</p>
                    <div class="d-flex gap-3 justify-content-center justify-content-lg-start">
                        <a href="tela-login.php" class="btn btn-warning btn-lg fw-bold px-4 rounded-3 text-dark">Entrar na Plataforma</a>
                        <a href="#funcionalidades" class="btn btn-outline-light btn-lg px-4 rounded-3">Saiba Mais</a>
                    </div>
                </div>
                <div class="col-lg-5 mt-5 mt-lg-0 text-center">
                    <i class="fa-solid fa-train-subway text-white opacity-25" style="font-size: 15rem;"></i>
                </div>
            </div>
        </div>
    </header>

    <section class="py-5 bg-light">
        <div class="container py-4">
            <div class="text-center max-w-700 mx-auto mb-5">
                <h2 class="fw-bold">O Desafio Logístico Ferroviário</h2>
                <p class="text-muted">A ausência de telemetria integrada gera atrasos de rotas, riscos de colisões e falhas de alocação de locomotivas.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm p-4 rounded-4">
                        <div class="feature-icon bg-danger bg-opacity-10 text-danger mb-3"><i class="fa-solid fa-shield-cat"></i></div>
                        <h5 class="fw-bold">Segurança Operacional</h5>
                        <p class="text-muted small mb-0">Sensores de pista detectam presença e cruzamentos perigosos antes que acidentes ocorram.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm p-4 rounded-4">
                        <div class="feature-icon bg-primary bg-opacity-10 text-primary mb-3"><i class="fa-solid fa-route"></i></div>
                        <h5 class="fw-bold">Otimização de Trajetos</h5>
                        <p class="text-muted small mb-0">Gestão precisa de quilometragem e tempo estimado de viagem entre estações conectadas.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm p-4 rounded-4">
                        <div class="feature-icon bg-success bg-opacity-10 text-success mb-3"><i class="fa-solid fa-gauge-high"></i></div>
                        <h5 class="fw-bold">Controle em Tempo Real</h5>
                        <p class="text-muted small mb-0">Monitoramento da velocidade máxima e status de manutenção da frota ativa.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-dark text-white py-4 text-center">
        <div class="container">
            <p class="mb-0 small text-muted">&copy; 2026 Ferrorama — Plataforma de Gestão Ferroviária. Todos os direitos reservados.</p>
        </div>
    </footer>

</body>
</html>