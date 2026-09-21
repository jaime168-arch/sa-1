/**
 * Manipulador para exclusão de Rotas (Projeto Ferrorama - Já.Ismaga)
 */

document.addEventListener('DOMContentLoaded', () => {
    // Seleciona todos os botões ou links de eliminação de rotas
    const deleteButtons = document.querySelectorAll('.btn-deletar-rota');

    deleteButtons.forEach(button => {
        button.addEventListener('click', (event) => {
            event.preventDefault();

            const rotaId = button.getAttribute('data-id');
            const rotaNome = button.getAttribute('data-nome') || `Rota #${rotaId}`;

            // Mensagem de confirmação ao utilizador
            const confirmacao = confirm(`Tem a certeza que deseja eliminar a "${rotaNome}"?\nEsta ação não poderá ser desfeita.`);

            if (confirmacao) {
                // Redireciona para o script PHP de eliminação
                window.location.href = `rota-deletar.php?id=${rotaId}`;
            }
        });
    });
});