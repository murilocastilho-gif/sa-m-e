document.addEventListener("DOMContentLoaded", function () {
    
    const formSensor = document.querySelector("form");
    if (formSensor && window.location.pathname.includes("tela-cadastro-sensor")) {
        formSensor.addEventListener("submit", function (e) {
            const nome = document.getElementById("nome") || document.querySelector("[name='nome']");
            const tipo = document.getElementById("tipo") || document.querySelector("[name='tipo']");

            if (nome && nome.value.trim() === "") {
                e.preventDefault();
                alert("Por favor, preencha o nome/identificador do sensor.");
                nome.focus();
                return false;
            }

            if (tipo && tipo.value === "") {
                e.preventDefault();
                alert("Por favor, selecione o tipo do sensor.");
                tipo.focus();
                return false;
            }
        });
    }

    const botoesExcluir = document.querySelectorAll(".btn-excluir-sensor, a[href*='excluir']");
    botoesExcluir.forEach(function (botao) {
        botao.addEventListener("click", function (e) {
            if (!confirm("Tem certeza que deseja remover este sensor do sistema?")) {
                e.preventDefault();
            }
        });
    });

    const elementosLeitura = document.querySelectorAll(".leitura-sensor");
    if (elementosLeitura.length > 0) {
        setInterval(function () {
            elementosLeitura.forEach(function (el) {
                const tipo = el.getAttribute("data-tipo") || "temperatura";
                let novoValor = 0;

                if (tipo === "temperatura") {
                    novoValor = (Math.random() * (45 - 20) + 20).toFixed(1) + " °C";
                } else if (tipo === "velocidade") {
                    novoValor = Math.floor(Math.random() * (120 - 40) + 40) + " km/h";
                } else if (tipo === "presenca") {
                    novoValor = Math.random() > 0.5 ? "Ocupado" : "Livre";
                } else {
                    novoValor = (Math.random() * 100).toFixed(0) + " %";
                }

                el.textContent = novoValor;
            });
        }, 3000);
    }
});