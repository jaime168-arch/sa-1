document.addEventListener("DOMContentLoaded", () => {
    carregarSensores();
});

async function carregarSensores() {
    try {
        const response = await fetch('/api/sensores'); // Ajuste a Rota da sua API se necessário
        const sensores = await response.json();

        const tabela = document.querySelector("tbody");
        tabela.innerHTML = "";

        if (sensores.length === 0) {
            tabela.innerHTML = `<tr><td colspan="5" class="text-center text-muted py-4">Nenhum sensor registado.</td></tr>`;
            return;
        }

        sensores.forEach(s => {
            const tr = document.createElement("tr");
            tr.innerHTML = `
                <td class="fw-bold text-dark">${s.codigo_sensor}</td>
                <td>${s.tipo}</td>
                <td>${s.localizacao}</td>
                <td><span class="badge bg-success">${s.status_leitura}</span></td>
                <td class="text-center">
                    <a href="sensor-form.html?id=${s.id}" class="btn btn-sm btn-outline-secondary me-1"><i class="bi bi-pencil"></i></a>
                    <button class="btn btn-sm btn-outline-danger" onclick="deletarSensor(${s.id})"><i class="bi bi-trash"></i></button>
                </td>
            `;
            tabela.appendChild(tr);
        });
    } catch (error) {
        console.error("Erro ao carregar sensores:", error);
    }
}