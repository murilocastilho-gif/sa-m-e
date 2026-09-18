<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ferrorama - Controle de Usuários</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style/style.css">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-custom shadow-sm">
        <div class="container d-flex flex-column">
            <div class="d-flex w-100 align-items-center justify-content-between mb-2">
                <a class="navbar-brand fw-bold text-white fs-3" href="tela-geral-home.html">
                    <span style="color: var(--laranja-ferrorama);">FERRO</span>RAMA
                </a>

                <div class="d-flex flex-grow-1 mx-4">
                    <input type="text" class="search-bar" placeholder="Buscar usuários por nome ou e-mail...">
                    <button class="btn-search"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>

                <div class="text-white d-none d-md-block">
                    <a href="tela-cadastro-user.html" class="nav-link-custom d-inline"><i class="fa-solid fa-user-plus me-1"></i> Novo Usuário</a>
                </div>
            </div>

            <div class="w-100">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link nav-link-custom" href="tela-geral-home.html">Home</a></li>
                    <li class="nav-item"><a class="nav-link nav-link-custom active fw-bold text-warning" href="#">Gerenciar Usuários</a></li>
                    <li class="nav-item"><a class="nav-link nav-link-custom" href="#">Produtos</a></li>
                    <li class="nav-item"><a class="nav-link nav-link-custom" href="#">Configurações</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5 mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold m-0"><i class="fa-solid fa-users-gear text-secondary me-2"></i>Usuários Cadastrados</h3>
            <span class="badge bg-dark px-3 py-2 fs-6">Total: 2 Integrantes</span>
        </div>

        <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle m-0">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" class="ps-4 py-3">ID</th>
                            <th scope="col" class="py-3">Nome Completo</th>
                            <th scope="col" class="py-3">E-mail</th>
                            <th scope="col" class="py-3">Telefone</th>
                            <th scope="col" class="py-3">Tipo de Usuário</th>
                            <th scope="col" class="text-center py-3 pe-4">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="ps-4 fw-bold text-secondary">#001</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; font-weight: 600;">MC</div>
                                    <span>Murilo Castilho</span>
                                </div>
                            </td>
                            <td>murilo.castilho@estudante.sesisenai.org.br</td>
                            <td>(47) 99999-1111</td>
                            <td><span class="badge bg-danger">Administrador</span></td>
                            <td class="text-center pe-4">
                                <button class="btn btn-sm btn-outline-secondary me-1" title="Editar"><i class="fa-solid fa-pen"></i></button>
                                <button class="btn btn-sm btn-outline-danger" title="Excluir"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td class="ps-4 fw-bold text-secondary">#002</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; font-weight: 600;">MC</div>
                                    <span>Murilo Castilho</span>
                                </div>
                            </td>
                            <td>murilo.castilho@estudante.sesisenai.org.br</td>
                            <td>(47) 99999-1111</td>
                            <td><span class="badge bg-primary">Scrum Master</span></td>
                            <td class="text-center pe-4">
                                <button class="btn btn-sm btn-outline-secondary me-1" title="Editar"><i class="fa-solid fa-pen"></i></button>
                                <button class="btn btn-sm btn-outline-danger" title="Excluir"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td class="ps-4 fw-bold text-secondary">#003</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; font-weight: 600;">EV</div>
                                    <span>Enzo Venturi</span>
                                </div>
                            </td>
                            <td>enzo_gubulin@estudante.sesisenai.org.br</td>
                            <td>(47) 97777-3333</td>
                            <td><span class="badge bg-success">Desenvolvedor</span></td>
                            <td class="text-center pe-4">
                                <button class="btn btn-sm btn-outline-secondary me-1" title="Editar"><i class="fa-solid fa-pen"></i></button>
                                <button class="btn btn-sm btn-outline-danger" title="Excluir"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td class="ps-4 fw-bold text-secondary">#004</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; font-weight: 600;">EV</div>
                                    <span>Enzo Venturis</span>
                                </div>
                            </td>
                            <td>enzo_gubulin@estudante.sesisenai.org.br</td>
                            <td>(47) 97777-3333</td>
                            <td><span class="badge bg-warning text-dark">Product Owner</span></td>
                            <td class="text-center pe-4">
                                <button class="btn btn-sm btn-outline-secondary me-1" title="Editar"><i class="fa-solid fa-pen"></i></button>
                                <button class="btn btn-sm btn-outline-danger" title="Excluir"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white pt-5 pb-4">
        <div class="container text-center text-md-left">
            <div class="row">
                <div class="col-md-3 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 font-weight-bold text-warning">Ferrorama</h5>
                    <p class="small text-secondary">A maior comunidade de colecionadores de trens elétricos do Brasil. O destino final para sua nostalgia.</p>
                </div>
                <div class="col-md-2 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 font-weight-bold text-warning">Links</h5>
                    <p><a href="tela-geral-home.html" class="text-white text-decoration-none small">Voltar para Home</a></p>
                    <p><a href="tela-cadastro-user.html" class="text-white text-decoration-none small">Cadastrar Usuário</a></p>
                </div>
                <div class="col-md-3 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 font-weight-bold text-warning">Contato</h5>
                    <p class="small"><i class="fas fa-home me-2"></i> Estação Central, SP</p>
                    <p class="small"><i class="fas fa-envelope me-2"></i> suporte@ferrorama.com</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../script/scripts.js"></script>
</body>
</html>