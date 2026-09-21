/**
 * Manipulação e Filtros da Listagem de Rotas (Projeto Ferrorama - Já.Ismaga)
 */

document.addEventListener('DOMContentLoaded', () => {
    const inputBusca = document.querySelector('#busca-rota');
    const tabelaRotas = document.querySelector('#tabela-rotas');

    // 1. Filtro de pesquisa em tempo real na tabela
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

    // 2. Destaque visual ao passar o rato nas linhas das rotas
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