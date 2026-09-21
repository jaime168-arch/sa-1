document.addEventListener('DOMContentLoaded', () => {
    const inputBusca = document.querySelector('#busca-trem');
    const selectFiltroStatus = document.querySelector('#filtro-status');
    const tabelaTrens = document.querySelector('#tabela-trens');

    if (!tabelaTrens) return;

    function aplicarFiltros() {
        const termo = inputBusca ? inputBusca.value.toLowerCase().trim() : '';
        const statusSelecionado = selectFiltroStatus ? selectFiltroStatus.value.toLowerCase() : '';
        const linhas = tabelaTrens.querySelectorAll('tbody tr');

        linhas.forEach(linha => {
            const conteudoLinha = linha.textContent.toLowerCase();
            const celulaStatus = linha.querySelector('.col-status') 
                ? linha.querySelector('.col-status').textContent.toLowerCase() 
                : '';

            const atendeBusca = conteudoLinha.includes(termo);
            const atendeStatus = statusSelecionado === '' || celulaStatus.includes(statusSelecionado);

            if (atendeBusca && atendeStatus) {
                linha.style.display = '';
            } else {
                linha.style.display = 'none';
            }
        });
    }

    if (inputBusca) {
        inputBusca.addEventListener('input', aplicarFiltros);
    }

    if (selectFiltroStatus) {
        selectFiltroStatus.addEventListener('change', aplicarFiltros);
    }
});