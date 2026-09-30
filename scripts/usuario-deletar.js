document.addEventListener('DOMContentLoaded', () => {
    // Seleciona todos os botões que possuem a classe "btn-deletar-usuario"
    const deleteButtons = document.querySelectorAll('.btn-deletar-usuario');

    deleteButtons.forEach(button => {
        button.addEventListener('click', (event) => {
            event.preventDefault();

            const usuarioId = button.getAttribute('data-id');
            const usuarioNome = button.getAttribute('data-nome') || `Utilizador #${usuarioId}`;

            // Exibe a caixa de confirmação nativa do navegador
            const confirmacao = confirm(`Tem a certeza que deseja eliminar o utilizador "${usuarioNome}"?\nEsta ação não poderá ser desfeita.`);

            if (confirmacao) {
                window.location.href = `usuario-deletar.php?id=${usuarioId}`;
            }
        });
    });
});