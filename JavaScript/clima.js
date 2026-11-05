document.addEventListener("DOMContentLoaded", () => {
    const lat = -26.3045;
    const lon = -48.8487;
    const url = `https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&current_weather=true&timezone=America%2FSao_Paulo`;

    const climaContainer = document.getElementById("widget-clima");
    if (!climaContainer) return;

    fetch(url)
        .then(response => {
            if (!response.ok) throw new Error("Erro na requisição da API de Clima");
            return response.json();
        })
        .then(data => {
            const temp = Math.round(data.current_weather.temperature);
            const code = data.current_weather.weathercode;
            const dataHora = new Date(data.current_weather.time).toLocaleString('pt-BR');

            let condicao = "Céu Limpo";
            let icone = "fa-sun";
            
            if (code >= 1 && code <= 3) {
                condicao = "Parcialmente Nublado";
                icone = "fa-cloud-sun";
            } else if (code >= 45 && code <= 48) {
                condicao = "Nevoeiro";
                icone = "fa-smog";
            } else if (code >= 51 && code <= 67) {
                condicao = "Chuva Leve/Moderada";
                icone = "fa-cloud-rain";
            } else if (code >= 80 && code <= 99) {
                condicao = "Tempestade / Chuva Forte";
                icone = "fa-cloud-showers-heavy";
            }

            climaContainer.innerHTML = `
                <div class="d-flex align-items-center justify-content-between p-3 bg-white rounded-3 shadow-sm border border-light">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid ${icone} fa-2x text-warning me-3"></i>
                        <div>
                            <h6 class="mb-0 fw-bold text-dark">${temp}°C — ${condicao}</h6>
                            <small class="text-muted"><i class="fa-solid fa-location-dot me-1"></i>Pátio Ferroviário (Joinville/SC)</small>
                        </div>
                    </div>
                    <div class="text-end border-start ps-3 ms-2">
                        <small class="d-block text-muted" style="font-size: 0.75rem;">Última atualização:</small>
                        <small class="fw-semibold text-secondary" style="font-size: 0.75rem;">${dataHora}</small>
                    </div>
                </div>
            `;
        })
        .catch(error => {
            console.error("Falha ao carregar clima:", error);
            climaContainer.innerHTML = `
                <div class="alert alert-warning mb-0 p-2 text-center small">
                    <i class="fa-solid fa-triangle-exclamation me-1"></i> Não foi possível carregar as informações meteorológicas no momento.
                </div>
            `;
        });
});