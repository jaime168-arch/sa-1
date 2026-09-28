document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('formCadastro');
    
    if (form) {
        form.addEventListener('submit', (e) => {
            const senha = document.getElementById('senha').value;
            const confirmarSenha = document.getElementById('confirmar_senha').value;

            if (senha !== confirmarSenha) {
                e.preventDefault(); // Impede o envio apenas se as senhas forem diferentes
                alert('As senhas digitadas não coincidem!');
            }
            // Deixe o formulário enviar via POST tradicional para o usuario-salvar.php
        });
    }
});