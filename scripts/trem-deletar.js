document.addEventListener('DOMContentLoaded', () => {
    const deleteButtons = document.querySelectorAll('.btn-deletar-trem');

    deleteButtons.forEach(button => {
        button.addEventListener('click', (event) => {
            event.preventDefault();

            const tremId = button.getAttribute('data-id');
            const tremNome = button.getAttribute('data-nome') || `Trem #${tremId}`;

            const confirmacao = confirm(`Tem certeza que deseja remover o "${tremNome}" da frota?\nEsta ação é irreversível.`);

            if (confirmacao) {
                window.location.href = `trem-deletar.php?id=${tremId}`;
            }
        });
    });
});