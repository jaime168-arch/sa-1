document.addEventListener('DOMContentLoaded', () => {
    const cadastroForm = document.getElementById('formCadastro');

    if (!cadastroForm) return;

    const nomeInput = document.getElementById('nome');
    const emailInput = document.getElementById('email');
    const senhaInput = document.getElementById('senha');
    const confirmarSenhaInput = document.getElementById('confirmar_senha');

    cadastroForm.addEventListener('submit', (event) => {
        const nome = nomeInput ? nomeInput.value.trim() : '';
        const email = emailInput ? emailInput.value.trim() : '';
        const senha = senhaInput ? senhaInput.value : '';
        const confirmarSenha = confirmarSenhaInput ? confirmarSenhaInput.value : '';

        if (!nome || nome.length < 3) {
            event.preventDefault();
            alert('Informe seu nome completo com pelo menos 3 caracteres.');
            return;
        }

        const emailValido = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        if (!emailValido) {
            event.preventDefault();
            alert('Informe um e-mail válido.');
            return;
        }

        if (senha.length < 6) {
            event.preventDefault();
            alert('A senha deve ter pelo menos 6 caracteres.');
            return;
        }

        if (senha !== confirmarSenha) {
            event.preventDefault();
            alert('As senhas não coincidem!');
            return;
        }

        alert('Cadastro realizado com sucesso! Redirecionando...');
    });
});