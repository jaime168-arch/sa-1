/**
 * Manipulador para eliminação de Trens (Projeto Ferrorama - Já.Ismaga)
 */

document.addEventListener('DOMContentLoaded', () => {
    // Seleciona todos os botões/links de eliminação na tabela de trens
    const deleteButtons = document.querySelectorAll('.btn-deletar-trem');

    deleteButtons.forEach(button => {
        button.addEventListener('click', (event) => {
            event.preventDefault();

            const tremId = button.getAttribute('data-id');
            const tremNome = button.getAttribute('data-nome') || `Trem #${tremId}`;

            // Solicita confirmação explícita do utilizador
            const confirmacao = confirm(`Tem certeza que deseja remover o "${tremNome}" da frota?\nEsta ação é irreversível.`);

            if (confirmacao) {
                // Encaminha para o script PHP de eliminação
                window.location.href = `trem-deletar.php?id=${tremId}`;
            }
        });
    });
});