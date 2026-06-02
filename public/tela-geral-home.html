<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ferrorama - Central de Peças e Coleções</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-custom shadow-sm">
        <div class="container d-flex flex-column">
            <div class="d-flex w-100 align-items-center justify-content-between mb-3">
                <a class="navbar-brand fw-bold text-white fs-3 m-0" href="../index.html">
                    <span style="color: var(--laranja-ferrorama);">FERRO</span>RAMA
                </a>

                <div class="d-flex flex-grow-1 mx-4 search-container">
                    <input type="text" id="campo-busca" class="search-bar" placeholder="Buscar locomotivas, trilhos, vagões...">
                    <button id="botao-busca" class="btn-search"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>

                <div class="d-none d-lg-flex align-items-center text-nowrap gap-3">
                    <a href="tela-login.html" class="nav-link-custom m-0"><i class="fa-regular fa-user me-1"></i> Entrar</a>
                    <a class="nav-link-custom m-0 position-relative" data-bs-toggle="offcanvas" href="#carrinhoLateral" role="button">
                        <i class="fa-solid fa-cart-shopping fs-5"></i>
                        <span id="badge-carrinho" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem;">0</span>
                    </a>
                </div>
            </div>

            <div class="w-100">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 flex-row gap-3 overflow-auto">
                    <li class="nav-item"><a class="nav-link-custom" href="#secao-categorias">Categorias</a></li>
                    <li class="nav-item"><a class="nav-link-custom" href="#" onclick="ativarFiltroMenu(event, 'motores')">Locomotivas</a></li>
                    <li class="nav-item"><a class="nav-link-custom" href="#" onclick="ativarFiltroMenu(event, 'trilhos')">Trilhos e Curvas</a></li>
                    <li class="nav-item"><a class="nav-link-custom" href="#vitrine-produtos">Ofertas do Dia</a></li>
                    <li class="nav-item"><a class="nav-link-custom" href="tela-cadastro-user.html">Vender Peças</a></li>
                    <li class="nav-item"><a class="nav-link-custom text-warning fw-bold" href="tela-lista-usuarios.html">Gerenciar Usuários</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="carrinhoLateral" aria-labelledby="carrinhoLateralLabel">
        <div class="offcanvas-header bg-dark text-white">
            <h5 class="offcanvas-title" id="carrinhoLateralLabel"><i class="fa-solid fa-cart-shopping me-2"></i>Seu Carrinho</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column">
            <div id="lista-carrinho" class="flex-grow-1 overflow-auto">
            </div>
            <div class="border-top pt-3 mt-3">
                <h5 class="fw-bold d-flex justify-content-between">Total: <span id="total-carrinho">R$ 0,00</span></h5>
                <button class="btn btn-warning w-100 fw-bold mt-2" onclick="simularCompra()">Finalizar Compra</button>
                <button class="btn btn-outline-danger w-100 fw-bold mt-2" onclick="limparCarrinho()">Esvaziar Carrinho</button>
            </div>
        </div>
    </div>

    <div class="container mt-4">
        <div class="hero-banner shadow">
            <div>
                <h1 class="display-4 fw-bold">Expedição Natal 2026</h1>
                <p class="fs-5">Complete sua coleção com sets exclusivos de locomotivas a vapor.</p>
                <button id="btn-ver-ofertas" class="btn btn-warning btn-lg fw-bold px-5">Ver Ofertas</button>
            </div>
        </div>
    </div>

    <div class="container mt-5" id="secao-categorias">
        <div class="row text-center row-cols-2 row-cols-md-6 g-3">
            <div class="col">
                <div class="cat-card cat-card-active" id="filter-todos"><i class="fa-solid fa-border-all"></i></div>
                <p class="small fw-bold">Todos</p>
            </div>
            <div class="col">
                <div class="cat-card" id="filter-motores"><i class="fa-solid fa-train"></i></div>
                <p class="small fw-bold">Motores</p>
            </div>
            <div class="col">
                <div class="cat-card" id="filter-trilhos"><i class="fa-solid fa-road"></i></div>
                <p class="small fw-bold">Trilhos</p>
            </div>
            <div class="col">
                <div class="cat-card" id="filter-sets"><i class="fa-solid fa-box-open"></i></div>
                <p class="small fw-bold">Sets Completos</p>
            </div>
            <div class="col">
                <div class="cat-card" id="filter-pecas"><i class="fa-solid fa-gears"></i></div>
                <p class="small fw-bold">Reposição</p>
            </div>
            <div class="col">
                <div class="cat-card" id="filter-cenarios"><i class="fa-solid fa-mountain-sun"></i></div>
                <p class="small fw-bold">Cenários</p>
            </div>
        </div>
    </div>

    <div class="container mt-5 mb-5" id="vitrine-produtos">
        <h3 class="mb-4 fw-bold">Inspirado no seu histórico</h3>
        <div class="row g-4" id="grade-produtos">
            
            <div class="col-md-3 produto-item" data-category="motores">
                <div class="card product-card shadow-sm" onclick="adicionarAoCarrinho(this)">
                    <div class="product-img"><i class="fa-solid fa-train-subway fa-4x"></i></div>
                    <div class="card-body">
                        <p class="mb-1 text-muted small">Novo</p>
                        <h6 class="card-title mb-2">Locomotiva XP-300 Clássica Estrela</h6>
                        <div class="price-tag">R$ 450,00</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 produto-item" data-category="sets">
                <div class="card product-card shadow-sm" onclick="adicionarAoCarrinho(this)">
                    <div class="product-img"><i class="fa-solid fa-train-tram fa-4x"></i></div>
                    <div class="card-body">
                        <p class="mb-1 text-muted small">Usado</p>
                        <h6 class="card-title mb-2">Vagão de Carga Petrobras</h6>
                        <div class="price-tag">R$ 89,90</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 produto-item" data-category="cenarios">
                <div class="card product-card shadow-sm" onclick="adicionarAoCarrinho(this)">
                    <div class="product-img"><i class="fa-solid fa-bridge fa-4x"></i></div>
                    <div class="card-body">
                        <p class="mb-1 text-muted small">Novo</p>
                        <h6 class="card-title mb-2">Kit Expansão: Ponte Metálica</h6>
                        <div class="price-tag">R$ 120,00</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 produto-item" data-category="trilhos">
                <div class="card product-card shadow-sm" onclick="adicionarAoCarrinho(this)">
                    <div class="product-img"><i class="fa-solid fa-shuffle fa-4x"></i></div>
                    <div class="card-body">
                        <p class="mb-1 text-muted small">Novo</p>
                        <h6 class="card-title mb-2">Cruzamento de Trilhos em X</h6>
                        <div class="price-tag">R$ 55,00</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 produto-item" data-category="motores">
                <div class="card product-card shadow-sm" onclick="adicionarAoCarrinho(this)">
                    <div class="product-img"><i class="fa-solid fa-train fa-4x"></i></div>
                    <div class="card-body">
                        <p class="mb-1 text-muted small">Usado</p>
                        <h6 class="card-title mb-2">Locomotiva Maria Fumaça</h6>
                        <div class="price-tag">R$ 320,00</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 produto-item" data-category="pecas">
                <div class="card product-card shadow-sm" onclick="adicionarAoCarrinho(this)">
                    <div class="product-img"><i class="fa-solid fa-gears fa-4x"></i></div>
                    <div class="card-body">
                        <p class="mb-1 text-muted small">Novo</p>
                        <h6 class="card-title mb-2">Engrenagem Eixo Central</h6>
                        <div class="price-tag">R$ 25,50</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 produto-item" data-category="cenarios">
                <div class="card product-card shadow-sm" onclick="adicionarAoCarrinho(this)">
                    <div class="product-img"><i class="fa-solid fa-tree fa-4x"></i></div>
                    <div class="card-body">
                        <p class="mb-1 text-muted small">Novo</p>
                        <h6 class="card-title mb-2">Kit 10 Árvores Pinheiros</h6>
                        <div class="price-tag">R$ 45,00</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 produto-item" data-category="sets">
                <div class="card product-card shadow-sm" onclick="adicionarAoCarrinho(this)">
                    <div class="product-img"><i class="fa-solid fa-box-open fa-4x"></i></div>
                    <div class="card-body">
                        <p class="mb-1 text-muted small">Novo</p>
                        <h6 class="card-title mb-2">Ferrorama XP 100 - Edição Nova</h6>
                        <div class="price-tag">R$ 799,00</div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <footer class="bg-dark text-white pt-5 pb-4 mt-auto">
        <div class="container text-center text-md-left">
            <div class="row">
                <div class="col-md-3 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 font-weight-bold text-warning">Ferrorama</h5>
                    <p class="small text-secondary">A maior comunidade de colecionadores de trens elétricos do Brasil.</p>
                </div>
                <div class="col-md-2 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 font-weight-bold text-warning">Links</h5>
                    <p><a href="tela-cadastro-user.html" class="text-white text-decoration-none small">Minha Conta</a></p>
                    <p><a href="#carrinhoLateral" data-bs-toggle="offcanvas" class="text-white text-decoration-none small">Meus Pedidos</a></p>
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

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            atualizarInterfaceCarrinho();

            const campoBusca = document.getElementById("campo-busca");
            const botaoBusca = document.getElementById("botao-busca");
            const produtos = document.querySelectorAll(".produto-item");

            const executarBusca = () => {
                const termo = campoBusca.value.trim().toLowerCase();
                if (termo !== "") {
                    produtos.forEach(produto => {
                        const titulo = produto.querySelector(".card-title").textContent.toLowerCase();
                        if (titulo.includes(termo)) {
                            produto.style.display = "block";
                        } else {
                            produto.style.display = "none";
                        }
                    });
                } else {
                    produtos.forEach(produto => produto.style.display = "block");
                }
            };

            botaoBusca.addEventListener("click", executarBusca);
            campoBusca.addEventListener("keypress", (e) => {
                if (e.key === "Enter") executarBusca();
            });

            const btnOfertas = document.getElementById("btn-ver-ofertas");
            btnOfertas.addEventListener("click", () => {
                document.getElementById("vitrine-produtos").scrollIntoView({ behavior: 'smooth' });
            });

            const filtros = document.querySelectorAll(".cat-card");
            filtros.forEach(filtro => {
                filtro.addEventListener("click", function() {
                    filtros.forEach(f => f.classList.remove("cat-card-active"));
                    this.classList.add("cat-card-active");

                    const categoriaNome = this.id.replace("filter-", "");

                    produtos.forEach(produto => {
                        if (categoriaNome === "todos" || produto.dataset.category === categoriaNome) {
                            produto.style.display = "block";
                        } else {
                            produto.style.display = "none";
                        }
                    });
                });
            });
        });

        function ativarFiltroMenu(event, categoria) {
            event.preventDefault();
            document.getElementById('vitrine-produtos').scrollIntoView({ behavior: 'smooth' });
            
            const filtros = document.querySelectorAll(".cat-card");
            filtros.forEach(f => f.classList.remove("cat-card-active"));
            
            const filtroAtivo = document.getElementById("filter-" + categoria);
            if(filtroAtivo) filtroAtivo.classList.add("cat-card-active");
            
            const produtos = document.querySelectorAll(".produto-item");
            produtos.forEach(produto => {
                if (categoria === "todos" || produto.dataset.category === categoria) {
                    produto.style.display = "block";
                } else {
                    produto.style.display = "none";
                }
            });
        }

        function adicionarAoCarrinho(cardElement) {
            const titulo = cardElement.querySelector(".card-title").textContent;
            const precoTexto = cardElement.querySelector(".price-tag").textContent;
            const precoFloat = parseFloat(precoTexto.replace("R$", "").replace(".", "").replace(",", ".").trim());

            let carrinho = JSON.parse(localStorage.getItem("itensCarrinhoFerrorama")) || [];
            
            carrinho.push({ nome: titulo, preco: precoFloat });
            localStorage.setItem("itensCarrinhoFerrorama", JSON.stringify(carrinho));

            atualizarInterfaceCarrinho();

            const badgeCarrinho = document.getElementById("badge-carrinho");
            badgeCarrinho.classList.add("bg-warning", "text-dark");
            setTimeout(() => {
                badgeCarrinho.classList.remove("bg-warning", "text-dark");
            }, 300);
        }

        function atualizarInterfaceCarrinho() {
            const carrinho = JSON.parse(localStorage.getItem("itensCarrinhoFerrorama")) || [];
            const badgeCarrinho = document.getElementById("badge-carrinho");
            const listaCarrinho = document.getElementById("lista-carrinho");
            const totalCarrinho = document.getElementById("total-carrinho");

            badgeCarrinho.textContent = carrinho.length;
            listaCarrinho.innerHTML = "";

            let total = 0;

            if (carrinho.length === 0) {
                listaCarrinho.innerHTML = "<p class='text-muted mt-3'>Seu carrinho está vazio.</p>";
            } else {
                carrinho.forEach((item, index) => {
                    total += item.preco;
                    listaCarrinho.innerHTML += `
                        <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                            <div>
                                <h6 class="mb-0 text-truncate" style="max-width: 180px; font-size: 0.9rem;">${item.nome}</h6>
                                <small class="text-success fw-bold">R$ ${item.preco.toFixed(2).replace('.', ',')}</small>
                            </div>
                            <button class="btn btn-sm btn-outline-danger" onclick="removerItem(${index})"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    `;
                });
            }

            totalCarrinho.textContent = `R$ ${total.toFixed(2).replace('.', ',')}`;
        }

        function removerItem(index) {
            let carrinho = JSON.parse(localStorage.getItem("itensCarrinhoFerrorama")) || [];
            carrinho.splice(index, 1);
            localStorage.setItem("itensCarrinhoFerrorama", JSON.stringify(carrinho));
            atualizarInterfaceCarrinho();
        }

        function limparCarrinho() {
            localStorage.removeItem("itensCarrinhoFerrorama");
            atualizarInterfaceCarrinho();
        }

        function simularCompra() {
            const carrinho = JSON.parse(localStorage.getItem("itensCarrinhoFerrorama")) || [];
            if (carrinho.length === 0) {
                alert("Adicione itens ao carrinho primeiro!");
                return;
            }
            alert("Compra finalizada com sucesso!");
            limparCarrinho();
            
            const offcanvasElement = document.getElementById('carrinhoLateral');
            const offcanvas = bootstrap.Offcanvas.getInstance(offcanvasElement);
            if (offcanvas) {
                offcanvas.hide();
            }
        }
    </script>
</body>
</html>