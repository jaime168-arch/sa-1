/**
 * Validação do Formulário de Trens (Projeto Ferrorama - Já.Ismaga)
 */

document.addEventListener('DOMContentLoaded', () => {
    const formTrem = document.querySelector('#form-trem');

    if (!formTrem) return;

    // Seleção dos campos do formulário
    const inputNome = document.querySelector('#nome_trem');
    const inputModelo = document.querySelector('#modelo');
    const inputCapacidade = document.querySelector('#capacidade');
    const selectStatus = document.querySelector('#status_trem');

    // Validação ao submeter o formulário
    formTrem.addEventListener('submit', (event) => {
        let erros = [];

        // Validação do Nome/Identificador do Trem
        if (!inputNome || inputNome.value.trim().length < 2) {
            erros.push('Informe um nome ou identificador válido para o trem (mínimo 2 caracteres).');
            marcarCampoInvalido(inputNome);
        } else {
            limparStatusCampo(inputNome);
        }

        // Validação do Modelo
        if (!inputModelo || inputModelo.value.trim() === '') {
            erros.push('Informe o modelo do trem.');
            marcarCampoInvalido(inputModelo);
        } else {
            limparStatusCampo(inputModelo);
        }

        // Validação da Capacidade (Deve ser um número inteiro positivo)
        const capacidadeVal = parseInt(inputCapacidade?.value, 10);
        if (!inputCapacidade || isNaN(capacidadeVal) || capacidadeVal <= 0) {
            erros.push('Informe uma capacidade válida de passageiros/carga (maior que zero).');
            marcarCampoInvalido(inputCapacidade);
        } else {
            limparStatusCampo(inputCapacidade);
        }

        // Validação do Status
        if (!selectStatus || selectStatus.value === '') {
            erros.push('Selecione o estado operacional do trem.');
            marcarCampoInvalido(selectStatus);
        } else {
            limparStatusCampo(selectStatus);
        }

        // Se houver erros, interrompe o envio e mostra a mensagem
        if (erros.length > 0) {
            event.preventDefault();
            exibirAlertaErro(erros.join('\n'));
        }
    });

    // Funções auxiliares para feedback visual
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
            formTrem.prepend(containerAlerta);
        }

        containerAlerta.innerHTML = `
            <strong>Atenção:</strong> Verifique os seguintes itens antes de guardar:
            <ul class="mb-0 mt-2">
                ${mensagem.split('\n').map(err => `<li>${err}</li>`).join('')}
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
    }
});