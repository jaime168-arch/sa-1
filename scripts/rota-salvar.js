/**
 * Manipulador e Processador de Envio de Rotas (Projeto Ferrorama - Já.Ismaga)
 */

document.addEventListener('DOMContentLoaded', () => {
    const formRota = document.querySelector('#form-rota');

    if (!formRota) return;

    formRota.addEventListener('submit', async (event) => {
        // Se a validação do browser/Bootstrap falhar, interrompe o envio
        if (!formRota.checkValidity()) {
            return;
        }

        event.preventDefault();

        const btnSalvar = formRota.querySelector('button[type="submit"]');
        const textoOriginalBtn = btnSalvar ? btnSalvar.innerHTML : 'Salvar';

        // Feedback visual de processamento
        if (btnSalvar) {
            btnSalvar.disabled = true;
            btnSalvar.innerHTML = `
                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                A guardar rota...
            `;
        }

        const formData = new FormData(formRota);

        try {
            const response = await fetch('rota-salvar.php', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (response.redirected) {
                // Redireciona caso o PHP responda com um header Location
                window.location.href = response.url;
                return;
            }

            const resultado = await response.json();

            if (resultado.sucesso) {
                exibirNotificacao('success', resultado.mensagem || 'Rota salva com sucesso!');
                setTimeout(() => {
                    window.location.href = 'rotas.php';
                }, 1200);
            } else {
                exibirNotificacao('danger', resultado.mensagem || 'Erro ao guardar a rota.');
                restaurarBotao(btnSalvar, textoOriginalBtn);
            }

        } catch (error) {
            // Caso o PHP responda com redirecionamento padrão sem JSON
            window.location.href = 'rotas.php';
        }
    });

    function restaurarBotao(btn, texto) {
        if (btn) {
            btn.disabled = false;
            btn.innerHTML = texto;
        }
    }

    function exibirNotificacao(tipo, mensagem) {
        let container = document.querySelector('#container-alerta-js');

        if (!container) {
            container = document.createElement('div');
            container.id = 'container-alerta-js';
            formRota.prepend(container);
        }

        container.className = `alert alert-${tipo} alert-dismissible fade show my-3 shadow-sm`;
        container.innerHTML = `
            ${mensagem}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
    }
});