/**
 * Manipulador para eliminação de Utilizadores (Projeto Ferrorama - Já.Ismaga)
 */

document.addEventListener('DOMContentLoaded', () => {
    // Seleciona todos os botões/links de eliminação na listagem de utilizadores
    const deleteButtons = document.querySelectorAll('.btn-deletar-usuario');

    deleteButtons.forEach(button => {
        button.addEventListener('click', (event) => {
            event.preventDefault();

            const usuarioId = button.getAttribute('data-id');
            const usuarioNome = button.getAttribute('data-nome') || `Utilizador #${usuarioId}`;

            // Solicita confirmação explícita antes de apagar
            const confirmacao = confirm(`Tem a certeza que deseja eliminar o utilizador "${usuarioNome}"?\nEsta ação não poderá ser desfeita.`);

            if (confirmacao) {
                // Redireciona para o script PHP de eliminação
                window.location.href = `usuario-deletar.php?id=${usuarioId}`;
            }
        });
    });
});