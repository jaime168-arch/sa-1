async function deletarSensor(id) {
    if (!confirm("Tem certeza que deseja remover este sensor?")) return;

    try {
        const response = await fetch(`/api/sensores/${id}`, {
            method: 'DELETE'
        });

        if (response.ok) {
            location.reload();
        } else {
            alert("Erro ao eliminar o sensor.");
        }
    } catch (error) {
        console.error("Erro ao apagar sensor:", error);
    }
}