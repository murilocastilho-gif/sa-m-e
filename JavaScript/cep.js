function buscarCEP() {
    const cepInput = document.getElementById("cep");
    const logradouro = document.getElementById("logradouro");
    const bairro = document.getElementById("bairro");
    const cidade = document.getElementById("cidade");
    const estado = document.getElementById("estado");
    const msgErro = document.getElementById("cep-erro");

    if (!cepInput) return;

    let cep = cepInput.value.replace(/\D/g, ''); 

    if (msgErro) msgErro.textContent = "";

    if (cep.length !== 8) {
        if (msgErro) msgErro.textContent = "Digite um CEP válido com 8 dígitos.";
        return;
    }

    logradouro.value = "Buscando...";
    bairro.value = "Buscando...";
    cidade.value = "Buscando...";
    estado.value = "...";

    fetch(`https://viacep.com.br/ws/${cep}/json/`)
        .then(res => res.json())
        .then(dados => {
            if (dados.erro) {
                if (msgErro) msgErro.textContent = "CEP não encontrado na base de dados.";
                limparCamposEndereco();
                return;
            }

            logradouro.value = dados.logradouro || '';
            bairro.value = dados.bairro || '';
            cidade.value = dados.localidade || '';
            estado.value = dados.uf || '';
        })
        .catch(() => {
            if (msgErro) msgErro.textContent = "Erro ao comunicar com o serviço de CEP.";
            limparCamposEndereco();
        });
}

function limparCamposEndereco() {
    document.getElementById("logradouro").value = "";
    document.getElementById("bairro").value = "";
    document.getElementById("cidade").value = "";
    document.getElementById("estado").value = "";
}