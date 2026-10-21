async function buscarCEP(cepInput) {
    const cep = cepInput.value.replace(/\D/g, '');
    if (cep.length !== 8) {
        alert('Por favor, informe um CEP válido com 8 dígitos.');
        return;
    }

    try {
        const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
        const data = await response.json();

        if (data.erro) {
            alert('CEP não encontrado. Verifique o número digitado.');
            return;
        }

        // Auto-preenchimento dos campos do formulário
        if (document.getElementById('logradouro')) document.getElementById('logradouro').value = data.logradouro;
        if (document.getElementById('bairro')) document.getElementById('bairro').value = data.bairro;
        if (document.getElementById('cidade')) document.getElementById('cidade').value = data.localidade;
        if (document.getElementById('uf')) document.getElementById('uf').value = data.uf;

    } catch (error) {
        alert('Erro ao consultar a API de CEP. Verifique a sua conexão.');
    }
}