function irParaCadastro() {
    window.location.href = "tela-cadastro-user.html";
}

function voltarLogin() {
    window.location.href = "tela-login.html";
}

function entrarSistema() {
    document.getElementById("loginForm").requestSubmit();
}

function cadastrarUsuario() {
    document.getElementById("cadastroForm").requestSubmit();
}

function logout() {
    localStorage.removeItem("usuarioLogado");
    window.location.href = "tela-login.html";
}