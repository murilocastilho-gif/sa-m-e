<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ferrorama - Cadastro de Sensores</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="assets/style/style.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.html">
                <i class="fa-solid fa-train text-warning me-2"></i>FERRORAMA
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="index.html"><i class="fa-solid fa-house me-1"></i> Home</a>
                <a class="nav-link active" href="#"><i class="fa-solid fa-microchip me-1"></i> Sensores</a>
            </div>
        </div>
    </nav>

    <div class="container mb-5">
        <div class="row g-4">
            
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-dark text-white fw-bold">
                        <i class="fa-solid fa-plus-circle text-warning me-2"></i>Novo Sensor
                    </div>
                    <div class="card-body">
                        <form id="form-sensor">
                            <div class="mb-3">
                                <label for="nome-sensor" class="form-label fw-bold">Nome / Identificador</label>
                                <input type="text" id="nome-sensor" class="form-control" placeholder="Ex: Sensor Curva A" required>
                            </div>

                            <div class="mb-3">
                                <label for="tipo-sensor" class="form-label fw-bold">Tipo de Sensor</label>
                                <select id="tipo-sensor" class="form-select" required>
                                    <option value="" selected disabled>Selecione...</option>
                                    <option value="Presença / RFID">Presença / RFID</option>
                                    <option value="Velocidade (Óptico)">Velocidade (Óptico)</option>
                                    <option value="Fim de Curso (Física)">Fim de Curso (Física)</option>
                                    <option value="Tensão / Corrente">Tensão / Corrente</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="localizacao-sensor" class="form-label fw-bold">Localização no Trilho</label>
                                <input type="text" id="localizacao-sensor" class="form-control" placeholder="Ex: Trecho Norte - Bloco 2" required>
                            </div>

                            <div class="mb-3">
                                <label for="status-sensor" class="form-label fw-bold">Status Inicial</label>
                                <select id="status-sensor" class="form-select">
                                    <option value="Ativo">Ativo</option>
                                    <option value="Inativo">Inativo</option>
                                    <option value="Manutenção">Manutenção</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-warning w-100 fw-bold mt-2">
                                <i class="fa-solid fa-floppy-disk me-1"></i> Cadastrar Sensor
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-dark text-white fw-bold d-flex justify-content-between align-items-center">
                        <span><i class="fa-solid fa-list me-2"></i>Sensores Monitorados</span>
                        <span id="total-sensores" class="badge bg-warning text-dark">0 Cadastrados</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle