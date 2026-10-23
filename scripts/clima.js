document.addEventListener('DOMContentLoaded', async () => {
    const climaBox = document.getElementById('clima-container');
    if (!climaBox) return;

    try {
        const response = await fetch('https://api.open-meteo.com/v1/forecast?latitude=-26.3045&longitude=-48.8487&current_weather=true');
        if (!response.ok) throw new Error('Erro na requisição');

        const data = await response.json();
        const temp = data.current_weather.temperature;
        const code = data.current_weather.weathercode;

        let condicao = "Ensolarado / Limpo";
        if (code >= 1 && code <= 3) condicao = "Parcialmente Nublado";
        else if (code >= 51 && code <= 67) condicao = "Chuva Leve / Moderada";
        else if (code >= 80) condicao = "Pancadas de Chuva";

        const agora = new Date().toLocaleString('pt-BR');

        climaBox.innerHTML = `
            <div class="d-flex align-items-center gap-3">
                <i class="bi bi-cloud-sun fs-2 text-warning"></i>
                <div>
                    <h6 class="mb-0 fw-bold">${temp}°C — ${condicao}</h6>
                    <small class="text-muted">Estação Central (Joinville/SC) • Atualizado: ${agora}</small>
                </div>
            </div>
        `;
    } catch (err) {
        climaBox.innerHTML = `<span class="text-danger small"><i class="bi bi-exclamation-triangle me-1"></i> Não foi possível carregar o clima local.</span>`;
    }
});