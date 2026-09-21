document.addEventListener('DOMContentLoaded', () => {
    const deleteButtons = document.querySelectorAll('.btn-deletar-rota');

    deleteButtons.forEach(button => {
        button.addEventListener('click', (event) => {
            event.preventDefault();

            const rotaId = button.getAttribute('data-id');
            const rotaNome = button.getAttribute('data-nome') || `Rota #${rotaId}`;

            const confirmacao = confirm(`Tem a certeza que deseja eliminar a "${rotaNome}"?\nEsta ação não poderá ser desfeita.`);

            if (confirmacao) {
                window.location.href = `rota-deletar.php?id=${rotaId}`;
            }
        });
    });
});