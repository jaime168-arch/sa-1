document.addEventListener('DOMContentLoaded', () => {
    const inputBusca = document.querySelector('#busca-rota');
    const tabelaRotas = document.querySelector('#tabela-rotas');

    if (inputBusca && tabelaRotas) {
        inputBusca.addEventListener('input', () => {
            const termo = inputBusca.value.toLowerCase().trim();
            const linhas = tabelaRotas.querySelectorAll('tbody tr');

            linhas.forEach(linha => {
                const conteudoLinha = linha.textContent.toLowerCase();
                if (conteudoLinha.includes(termo)) {
                    linha.style.display = '';
                } else {
                    linha.style.display = 'none';
                }
            });
        });
    }

    const linhasTabela = document.querySelectorAll('#tabela-rotas tbody tr');
    linhasTabela.forEach(linha => {
        linha.addEventListener('mouseenter', () => {
            linha.classList.add('table-active');
        });
        linha.addEventListener('mouseleave', () => {
            linha.classList.remove('table-active');
        });
    });
});