document.querySelector("form").addEventListener("submit", async (e) => {
    e.preventDefault();

    const id = document.querySelector("input[name='id']").value;
    const sensorData = {
        codigo_sensor: document.querySelector("input[name='codigo_sensor']").value,
        tipo: document.querySelector("input[name='tipo']").value,
        localizacao: document.querySelector("input[name='localizacao']").value,
        status_leitura: document.querySelector("input[name='status_leitura']").value,
        trem_id: document.querySelector("select[name='trem_id']").value
    };

    const url = id ? `/api/sensores/${id}` : '/api/sensores';
    const method = id ? 'PUT' : 'POST';

    try {
        const response = await fetch(url, {
            method: method,
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(sensorData)
        });

        if (response.ok) {
            window.location.href = "sensores.php"; // ou sensores.html
        } else {
            alert("Erro ao guardar o sensor.");
        }
    } catch (error) {
        console.error("Erro na requisição:", error);
    }
});