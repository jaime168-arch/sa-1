document.addEventListener("DOMContentLoaded", async () => {
    await carregarTrens();

    const urlParams = new URLSearchParams(window.location.search);
    const sensorId = urlParams.get('id');

    if (sensorId) {
        carregarDadosSensor(sensorId);
    }
});

async function carregarTrens() {
    try {
        const response = await fetch('/api/trens');
        const trens = await response.json();
        const selectTrem = document.querySelector("select[name='trem_id']");

        trens.forEach(trem => {
            const option = document.createElement("option");
            option.value = trem.id;
            option.textContent = trem.nome;
            selectTrem.appendChild(option);
        });
    } catch (error) {
        console.error("Erro ao carregar lista de trens:", error);
    }
}

async function carregarDadosSensor(id) {
    try {
        const response = await fetch(`/api/sensores/${id}`);
        const sensor = await response.json();

        document.querySelector("input[name='id']").value = sensor.id;
        document.querySelector("input[name='codigo_sensor']").value = sensor.codigo_sensor;
        document.querySelector("input[name='tipo']").value = sensor.tipo;
        document.querySelector("input[name='localizacao']").value = sensor.localizacao;
        document.querySelector("input[name='status_leitura']").value = sensor.status_leitura;
        document.querySelector("select[name='trem_id']").value = sensor.trem_id;
    } catch (error) {
        console.error("Erro ao carregar sensor:", error);
    }
}