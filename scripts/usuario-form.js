document.addEventListener('DOMContentLoaded', () => {
    const formUsuario = document.querySelector('#form-usuario');

    if (!formUsuario) return;

    const inputNome = document.querySelector('#nome');
    const inputEmail = document.querySelector('#email');
    const inputSenha = document.querySelector('#senha');
    const inputConfirmarSenha = document.querySelector('#confirmar_senha');

    formUsuario.addEventListener('submit', (event) => {
        let erros = [];

        if (!inputNome || inputNome.value.trim().length < 3) {
            erros.push('Informe o nome completo (mínimo de 3 caracteres).');
            marcarCampoInvalido(inputNome);
        } else {
            limparStatusCampo(inputNome);
        }

        if (!inputEmail || !validarEmail(inputEmail.value.trim())) {
            erros.push('Informe um endereço de e-mail válido.');
            marcarCampoInvalido(inputEmail);
        } else {
            limparStatusCampo(inputEmail);
        }

        if (inputSenha && (inputSenha.value.length > 0 || !formUsuario.dataset.edicao)) {
            if (inputSenha.value.length < 6) {
                erros.push('A palavra-passe deve conter pelo menos 6 caracteres.');
                marcarCampoInvalido(inputSenha);
            } else {
                limparStatusCampo(inputSenha);
            }

            if (inputConfirmarSenha && inputSenha.value !== inputConfirmarSenha.value) {
                erros.push('As palavras-passe introduzidas não coincidem.');
                marcarCampoInvalido(inputConfirmarSenha);
            } else if (inputConfirmarSenha) {
                limparStatusCampo(inputConfirmarSenha);
            }
        }

        if (erros.length > 0) {
            event.preventDefault();
            exibirAlertaErro(erros.join('\n'));
        }
    });

    function validarEmail(email) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }

    function marcarCampoInvalido(campo) {
        if (campo) {
            campo.classList.add('is-invalid');
            campo.classList.remove('is-valid');
        }
    }

    function limparStatusCampo(campo) {
        if (campo) {
            campo.classList.remove('is-invalid');
            campo.classList.add('is-valid');
        }
    }

    function exibirAlertaErro(mensagem) {
        let containerAlerta = document.querySelector('#container-alerta-js');
        
        if (!containerAlerta) {
            containerAlerta = document.createElement('div');
            containerAlerta.id = 'container-alerta-js';
            containerAlerta.className = 'alert alert-danger alert-dismissible fade show my-3';
            formUsuario.prepend(containerAlerta);
        }

        containerAlerta.innerHTML = `
            <strong>Atenção:</strong> Por favor, corrija os erros abaixo:
            <ul class="mb-0 mt-2">
                ${mensagem.split('\n').map(err => `<li>${err}</li>`).join('')}
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
    }
});