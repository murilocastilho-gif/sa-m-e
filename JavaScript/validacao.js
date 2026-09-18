document.addEventListener("DOMContentLoaded", () => {
    const formLogin = document.querySelector("#form-login");
    if (formLogin) {
        formLogin.addEventListener("submit", (e) => {
            const email = document.querySelector("#email").value.trim();
            const senha = document.querySelector("#senha").value.trim();

            if (!email || !senha) {
                e.preventDefault();
                alert("Por favor, preencha todos os campos para entrar.");
                return;
            }

            if (!validarEmail(email)) {
                e.preventDefault();
                alert("Por favor, insira um e-mail válido.");
            }
        });
    }

    const formCadastro = document.querySelector("#form-cadastro");
    if (formCadastro) {
        formCadastro.addEventListener("submit", (e) => {
            const nome = document.querySelector("#nome").value.trim();
            const email = document.querySelector("#email").value.trim();
            const telefone = document.querySelector("#telefone").value.trim();
            const senha = document.querySelector("#senha").value.trim();
            const confSenha = document.querySelector("#confirmar-senha").value.trim();

            if (!nome || !email || !telefone || !senha || !confSenha) {
                e.preventDefault();
                alert("Todos os campos são obrigatórios para o cadastro.");
                return;
            }

            if (!validarEmail(email)) {
                e.preventDefault();
                alert("O formato do e-mail inserido não é válido.");
                return;
            }

            if (senha.length < 6) {
                e.preventDefault();
                alert("A senha deve conter no mínimo 6 caracteres.");
                return;
            }

            if (senha !== confSenha) {
                e.preventDefault();
                alert("As senhas não coincidem. Digite novamente.");
                return;
            }
        });

        const campoTelefone = document.querySelector("#telefone");
        campoTelefone.addEventListener("input", (e) => {
            let value = e.target.value.replace(/\D/g, "");
            if (value.length > 11) value = value.slice(0, 11);
            
            if (value.length > 6) {
                e.target.value = `(${value.slice(0, 2)}) ${value.slice(2, 7)}-${value.slice(7)}`;
            } else if (value.length > 2) {
                e.target.value = `(${value.slice(0, 2)}) ${value.slice(2)}`;
            } else if (value.length > 0) {
                e.target.value = `(${value}`;
            }
        });
    }
});

function validarEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}