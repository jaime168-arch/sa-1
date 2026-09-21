/**
 * Autenticação de Login via JavaScript (Projeto Ferrorama - Já.Ismaga)
 */

document.addEventListener('DOMContentLoaded', () => {
    const formLogin = document.querySelector('#loginForm');

    if (!formLogin) return;

    formLogin.addEventListener('submit', async (event) => {
        event.preventDefault(); // Impede o recarregamento tradicional da página

        const inputEmail = document.querySelector('#email');
        const inputSenha = document.querySelector('#password');
        const btnEntrar = formLogin.querySelector('button[type="submit"]');
        const textoOriginalBtn = btnEntrar ? btnEntrar.innerHTML : 'Entrar';

        // Validação simples do lado do cliente
        if (!inputEmail.value.trim() || !inputSenha.value.trim()) {
            exibirNotificacao('danger', 'Por favor, preencha o e-mail e a senha.');
            return;
        }

        // Desativa o botão e mostra animação de carregamento
        if (btnEntrar) {
            btnEntrar.disabled = true;
            btnEntrar.innerHTML = `
                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                Entrando...
            `;
        }

        const formData = new FormData(formLogin);

        try {
            const response = await fetch('autenticar.php', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            // Se o servidor respondeu com redirecionamento (ex: para home.php)
            if (response.redirected) {
                window.location.href = response.url;
                return;
            }

            const resultado = await response.json();

            if (resultado.sucesso) {
                exibirNotificacao('success', resultado.mensagem || 'Login realizado com sucesso!');
                setTimeout(() => {
                    window.location.href = resultado.redirecionar || 'home.php';
                }, 800);
            } else {
                exibirNotificacao('danger', resultado.mensagem || 'E-mail ou senha incorretos.');
                restaurarBotao(btnEntrar, textoOriginalBtn);
            }

        } catch (error) {
            // Em caso de envio legados ou redirecionamento padrão do PHP
            window.location.href = 'home.php';
        }
    });

    function restaurarBotao(btn, texto) {
        if (btn) {
            btn.disabled = false;
            btn.innerHTML = texto;
        }
    }

    function exibirNotificacao(tipo, mensagem) {
        let container = document.querySelector('#alerta-login-js');

        if (!container) {
            container = document.createElement('div');
            container.id = 'alerta-login-js';
            formLogin.prepend(container);
        }

        container.className = `alert alert-${tipo} alert-dismissible fade show mb-3 shadow-sm`;
        container.innerHTML = `
            ${mensagem}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
    }
});